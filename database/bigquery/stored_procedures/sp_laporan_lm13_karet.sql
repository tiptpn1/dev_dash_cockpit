CREATE OR REPLACE PROCEDURE `dashboard-cockpit.data_dash.sp_laporan_lm13_karet`(p_region STRING, p_plant STRING, p_tahun STRING, p_bulan STRING)
BEGIN

DECLARE v_start_tl, v_end_tl, v_start, v_end INT64;
DECLARE v_thn_lalu INT64;

DECLARE gaji_karpim_tahun_lalu, gaji_karpim_tahun_ini   NUMERIC;
DECLARE gaji_karpel_tahun_lalu, gaji_karpel_tahun_ini   NUMERIC;
DECLARE total_9901_tahun_lalu,  total_9901_tahun_ini    NUMERIC;
DECLARE luas_areal_tahun_lalu,  luas_areal_tahun_ini    NUMERIC;
DECLARE prd_tahun_lalu,         prd_tahun_ini           NUMERIC;

SET v_thn_lalu = CAST(p_tahun AS INT64) - 1;
SET v_start    = CAST(CONCAT(p_tahun,   '001')             AS INT64);
SET v_end      = CAST(CONCAT(p_tahun,   LPAD(p_bulan,3,'0')) AS INT64);
SET v_start_tl = CAST(CONCAT(v_thn_lalu,'001')             AS INT64);
SET v_end_tl   = CAST(CONCAT(v_thn_lalu,LPAD(p_bulan,3,'0')) AS INT64);

-- ============================================================
-- PLANT LIST  (sama seperti sebelumnya)
-- ============================================================
CREATE TEMP TABLE plant_list AS
SELECT DISTINCT plant
FROM `data_dash.ref_plant_group`
WHERE (p_region IS NULL OR p_region = '' OR CAST(regional AS STRING) = p_region)
  AND (p_plant  IS NULL OR p_plant  = '' OR group_id = p_plant);

-- ============================================================
-- 🔥 OPTIMASI UTAMA:
--    Semua nilai 9901 diambil DALAM SATU SCAN cds_lm14
--    (sebelumnya 6 SET terpisah = 6 full scan)
-- ============================================================
CREATE TEMP TABLE agg_9901 AS
SELECT
  SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl
         AND account IN ('51101204','90021010','90021020','90021500','90021540'),
         amount, 0)) AS gaji_karpim_tl,
  SUM(IF(tahun_periode BETWEEN v_start    AND v_end
         AND account IN ('51101204','90021010','90021020','90021500','90021540'),
         amount, 0)) AS gaji_karpim_ti,

  SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl
         AND account IN (
           '51100402','51100403','51100410','51100412','51100413',
           '51100427','51100429','51100430','51100433','51100434',
           '51100440','51100441','51100442','51100456','51100459',
           '51100639','51100640','51101021','51101071','54000016',
           '51100401','51101047','51101061','90021522',
           '98000401','98000402','98000403','98000410','98000412',
           '98000413','98000427','98000429','98000430','98000433',
           '98000434','98000440','98000441','98000442','98000456',
           '98000459','98000639','98000640','98001021','98001071',
           '98043000','98043001','90021036','90021501','90021526',
           '98001204','90021504'
         ), amount, 0)) AS gaji_karpel_tl,
  SUM(IF(tahun_periode BETWEEN v_start    AND v_end
         AND account IN (
           '51100402','51100403','51100410','51100412','51100413',
           '51100427','51100429','51100430','51100433','51100434',
           '51100440','51100441','51100442','51100456','51100459',
           '51100639','51100640','51101021','51101071','54000016',
           '51100401','51101047','51101061','90021522',
           '98000401','98000402','98000403','98000410','98000412',
           '98000413','98000427','98000429','98000430','98000433',
           '98000434','98000440','98000441','98000442','98000456',
           '98000459','98000639','98000640','98001021','98001071',
           '98043000','98043001','90021036','90021501','90021526',
           '98001204','90021504'
         ), amount, 0)) AS gaji_karpel_ti,

  SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, amount, 0)) AS total_tl,
  SUM(IF(tahun_periode BETWEEN v_start    AND v_end,    amount, 0)) AS total_ti

FROM `data_dash.cds_lm14` d
-- ✅ Ganti IN (SELECT...) dengan JOIN langsung
JOIN plant_list pl ON LEFT(d.profitcenter, 4) = pl.plant
WHERE d.jobcode = '9901'
  AND d.tahun_periode BETWEEN v_start_tl AND v_end;

-- Assign ke variabel dari single-row result
SET gaji_karpim_tahun_lalu = (SELECT gaji_karpim_tl FROM agg_9901);
SET gaji_karpim_tahun_ini  = (SELECT gaji_karpim_ti FROM agg_9901);
SET gaji_karpel_tahun_lalu = (SELECT gaji_karpel_tl FROM agg_9901);
SET gaji_karpel_tahun_ini  = (SELECT gaji_karpel_ti FROM agg_9901);
SET total_9901_tahun_lalu  = (SELECT total_tl       FROM agg_9901);
SET total_9901_tahun_ini   = (SELECT total_ti       FROM agg_9901);

-- ============================================================
-- PEMEL  (tidak berubah strukturnya, sudah efisien)
-- ============================================================
CREATE TEMP TABLE agg_pemel AS
WITH a_agg AS (
  SELECT a.jobcode, a.tahun_periode, a.profitcenter, a.region,
         SUM(a.amount) AS amount
  FROM `data_dash.cds_lm14` a
  JOIN plant_list pl ON LEFT(a.profitcenter, 4) = pl.plant
  WHERE a.jobcode <> '9901'
    AND a.tahun_periode BETWEEN v_start_tl AND v_end
  GROUP BY a.jobcode, a.tahun_periode, a.profitcenter, a.region
),
b_agg AS (
  SELECT b.jobcode, b.tahun_periode, b.profitcenter,
         SUM(b.quantity) AS quantity, SUM(b.amount) AS amount
  FROM `data_dash.cds_lm14_bb` b
  JOIN plant_list pl ON LEFT(b.profitcenter, 4) = pl.plant
  WHERE b.tahun_periode BETWEEN v_start_tl AND v_end
  GROUP BY b.jobcode, b.tahun_periode, b.profitcenter
)
SELECT
  a.jobcode,
  SUM(IF(a.tahun_periode BETWEEN v_start_tl AND v_end_tl, COALESCE(b.quantity,0), 0)) AS qty_tahun_lalu,
  SUM(IF(a.tahun_periode BETWEEN v_start_tl AND v_end_tl, COALESCE(b.amount,0),   0)) AS barang_bahan_tahun_lalu,
  SUM(IF(a.tahun_periode BETWEEN v_start_tl AND v_end_tl, a.amount - COALESCE(b.amount,0), 0)) AS biaya_pemeliharaan_tahun_lalu,
  SUM(IF(a.tahun_periode BETWEEN v_start_tl AND v_end_tl, a.amount, 0)) AS biaya_total_tahun_lalu,
  SUM(IF(a.tahun_periode BETWEEN v_start    AND v_end,    COALESCE(b.quantity,0), 0)) AS qty_tahun_ini,
  SUM(IF(a.tahun_periode BETWEEN v_start    AND v_end,    COALESCE(b.amount,0),   0)) AS barang_bahan_tahun_ini,
  SUM(IF(a.tahun_periode BETWEEN v_start    AND v_end,    a.amount - COALESCE(b.amount,0), 0)) AS biaya_pemeliharaan_tahun_ini,
  SUM(IF(a.tahun_periode BETWEEN v_start    AND v_end,    a.amount, 0)) AS biaya_total_tahun_ini
FROM a_agg a
LEFT JOIN b_agg b
  ON a.jobcode = b.jobcode AND a.tahun_periode = b.tahun_periode AND a.profitcenter = b.profitcenter
GROUP BY a.jobcode;

-- ============================================================
-- BIAYA LAIN (EA%)
-- ============================================================
CREATE TEMP TABLE agg_lain AS
SELECT
  X.jobcode, X.gl, X.uraian,
  0 AS qty_tahun_lalu, 0 AS barang_bahan_tahun_lalu,
  (COALESCE(X.nilai_tahun_lalu,0) + COALESCE(Y.nilai_tahun_lalu,0)) AS biaya_pemeliharaan_tahun_lalu,
  (COALESCE(X.nilai_tahun_lalu,0) + COALESCE(Y.nilai_tahun_lalu,0)) AS biaya_total_tahun_lalu,
  0 AS qty_tahun_ini, 0 AS barang_bahan_tahun_ini,
  (COALESCE(X.nilai_tahun_ini,0)  + COALESCE(Y.nilai_tahun_ini,0))  AS biaya_pemeliharaan_tahun_ini,
  (COALESCE(X.nilai_tahun_ini,0)  + COALESCE(Y.nilai_tahun_ini,0))  AS biaya_total_tahun_ini
FROM (
  SELECT A.jobcode, A.gl, A.uraian,
    SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, COALESCE(B.amount,0), 0)) AS nilai_tahun_lalu,
    SUM(IF(B.tahun_periode BETWEEN v_start    AND v_end,    COALESCE(B.amount,0), 0)) AS nilai_tahun_ini
  FROM `data_dash.m_format_report` AS A
  LEFT JOIN `data_dash.cds_lm14` AS B
         ON A.jobcode = B.jobcode AND A.gl = B.account
  JOIN plant_list pl ON LEFT(B.profitcenter, 4) = pl.plant
  WHERE A.jenis_laporan = 'LM14_Karet'
    AND A.jobcode = '9901'
    AND A.kode LIKE 'EA%'
    AND (p_region IS NULL OR p_region = '' OR B.region = p_region)
    AND B.tahun_periode BETWEEN v_start_tl AND v_end  -- 🔥 tambahan pruning
  GROUP BY A.jobcode, A.gl, A.uraian
) AS X
LEFT JOIN (
  SELECT A.uraian_4,
    SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, COALESCE(B.amount,0), 0)) AS nilai_tahun_lalu,
    SUM(IF(B.tahun_periode BETWEEN v_start    AND v_end,    COALESCE(B.amount,0), 0)) AS nilai_tahun_ini
  FROM `data_dash.report_hierarchy` AS A
  LEFT JOIN `data_dash.cds_lm14` AS B
         ON A.key1 = B.jobcode AND A.key2 = B.account
  JOIN plant_list pl ON LEFT(B.profitcenter, 4) = pl.plant
  WHERE A.jenis_laporan = 'LM14_Karet'
    AND A.key1 = '-'
    AND (p_region IS NULL OR p_region = '' OR B.region = p_region)
    AND B.tahun_periode BETWEEN v_start_tl AND v_end  -- 🔥 tambahan pruning
  GROUP BY A.uraian_4
) AS Y ON X.uraian = Y.uraian_4
ORDER BY X.jobcode, X.gl, X.uraian;

-- ============================================================
-- REPORT → FINAL 14 (tidak berubah)
-- ============================================================
CREATE TEMP TABLE report AS
SELECT
  X.kode, X.grup, X.jobcode, X.uraian, X.gl,
  COALESCE(P.qty_tahun_lalu,0)                 + COALESCE(L.qty_tahun_lalu,0)                 AS qty_tahun_lalu,
  COALESCE(P.barang_bahan_tahun_lalu,0)        + COALESCE(L.barang_bahan_tahun_lalu,0)        AS barang_bahan_tahun_lalu,
  COALESCE(P.biaya_pemeliharaan_tahun_lalu,0)  + COALESCE(L.biaya_pemeliharaan_tahun_lalu,0)  AS biaya_pemeliharaan_tahun_lalu,
  COALESCE(P.biaya_total_tahun_lalu,0)         + COALESCE(L.biaya_total_tahun_lalu,0)         AS biaya_total_tahun_lalu,
  COALESCE(P.qty_tahun_ini,0)                  + COALESCE(L.qty_tahun_ini,0)                  AS qty_tahun_ini,
  COALESCE(P.barang_bahan_tahun_ini,0)         + COALESCE(L.barang_bahan_tahun_ini,0)         AS barang_bahan_tahun_ini,
  COALESCE(P.biaya_pemeliharaan_tahun_ini,0)   + COALESCE(L.biaya_pemeliharaan_tahun_ini,0)   AS biaya_pemeliharaan_tahun_ini,
  COALESCE(P.biaya_total_tahun_ini,0)          + COALESCE(L.biaya_total_tahun_ini,0)          AS biaya_total_tahun_ini
FROM `data_dash.m_format_report` X
LEFT JOIN agg_pemel P ON X.jobcode = P.jobcode AND X.gl IS NULL
LEFT JOIN agg_lain  L ON X.jobcode = L.jobcode AND X.gl = L.gl
WHERE X.jenis_laporan = 'LM14_Karet';

CREATE TEMP TABLE final_14 AS
WITH final_with_aa AS (
  SELECT kode, grup, jobcode, uraian,
    qty_tahun_lalu, barang_bahan_tahun_lalu,
    CASE WHEN kode='AA01' THEN gaji_karpim_tahun_lalu
         WHEN kode='AA02' THEN gaji_karpel_tahun_lalu
         ELSE biaya_pemeliharaan_tahun_lalu END AS biaya_pemeliharaan_tahun_lalu,
    CASE WHEN kode='AA01' THEN gaji_karpim_tahun_lalu
         WHEN kode='AA02' THEN gaji_karpel_tahun_lalu
         ELSE biaya_total_tahun_lalu       END AS biaya_total_tahun_lalu,
    qty_tahun_ini, barang_bahan_tahun_ini,
    CASE WHEN kode='AA01' THEN gaji_karpim_tahun_ini
         WHEN kode='AA02' THEN gaji_karpel_tahun_ini
         ELSE biaya_pemeliharaan_tahun_ini END AS biaya_pemeliharaan_tahun_ini,
    CASE WHEN kode='AA01' THEN gaji_karpim_tahun_ini
         WHEN kode='AA02' THEN gaji_karpel_tahun_ini
         ELSE biaya_total_tahun_ini        END AS biaya_total_tahun_ini
  FROM report
),
pengurang AS (
  SELECT
    SUM(biaya_pemeliharaan_tahun_lalu) AS pengurang_tahun_lalu,
    SUM(biaya_pemeliharaan_tahun_ini)  AS pengurang_tahun_ini
  FROM final_with_aa WHERE kode LIKE 'EA%' OR kode LIKE 'AA%'
)
SELECT
  f.kode, f.grup, f.uraian,
  f.qty_tahun_lalu,
  ROUND(f.barang_bahan_tahun_lalu * 100, 0) AS barang_bahan_tahun_lalu,
  CASE WHEN f.kode='EB16' THEN ROUND((total_9901_tahun_lalu - p.pengurang_tahun_lalu)*100,0)
       ELSE ROUND(f.biaya_pemeliharaan_tahun_lalu*100,0) END AS biaya_pemeliharaan_tahun_lalu,
  CASE WHEN f.kode='EB16' THEN ROUND((total_9901_tahun_lalu - p.pengurang_tahun_lalu)*100,0)
       ELSE ROUND(f.biaya_total_tahun_lalu*100,0)             END AS biaya_total_tahun_lalu,
  f.qty_tahun_ini,
  ROUND(f.barang_bahan_tahun_ini * 100, 0) AS barang_bahan_tahun_ini,
  CASE WHEN f.kode='EB16' THEN ROUND((total_9901_tahun_ini - p.pengurang_tahun_ini)*100,0)
       ELSE ROUND(f.biaya_pemeliharaan_tahun_ini*100,0)       END AS biaya_pemeliharaan_tahun_ini,
  CASE WHEN f.kode='EB16' THEN ROUND((total_9901_tahun_ini  - p.pengurang_tahun_ini)*100,0)
       ELSE ROUND(f.biaya_total_tahun_ini*100,0)              END AS biaya_total_tahun_ini
FROM final_with_aa f CROSS JOIN pengurang p;

-- ============================================================
-- LUAS AREAL  (tidak berubah)
-- ============================================================
SET luas_areal_tahun_lalu = (
  SELECT SUM(COALESCE(ha_planted,0)) FROM `data_dash.cds_lm14_mf`
  WHERE tahun_periode = v_end_tl AND fase = 'KM'
    AND plant IN (SELECT plant FROM plant_list));

SET luas_areal_tahun_ini = (
  SELECT SUM(COALESCE(ha_planted,0)) FROM `data_dash.cds_lm14_mf`
  WHERE tahun_periode = v_end    AND fase = 'KM'
    AND plant IN (SELECT plant FROM plant_list));

-- ============================================================
-- LM16 – BIAYA & PRODUKSI  (ditambah pruning tahun_periode)
-- ============================================================
CREATE TEMP TABLE temp_biaya AS
SELECT X.kode, X.grup, X.uraian, Y.tahun_lalu, Y.tahun_ini
FROM `data_dash.m_format_report` X
LEFT JOIN (
  SELECT
    c.grpaccttext,
    ROUND(SUM(IF(c.tahun_periode BETWEEN v_start_tl AND v_end_tl, c.amount, 0)), 0) AS tahun_lalu,
    ROUND(SUM(IF(c.tahun_periode BETWEEN v_start    AND v_end,    c.amount, 0)), 0) AS tahun_ini
  FROM `dashboard-cockpit.data_dash.cds_lm16` c
  -- ✅ Ganti IN (SELECT...) dengan JOIN langsung di dalam subquery
  JOIN plant_list pl ON LEFT(c.profitcenter, 4) = pl.plant
  WHERE c.tahun_periode BETWEEN v_start_tl AND v_end
  GROUP BY c.grpaccttext
) Y ON X.uraian = Y.grpaccttext
WHERE X.jenis_laporan = 'LM16_Karet'
  AND LEFT(X.kode, 1) IN ('A', 'B');

CREATE TEMP TABLE temp_produksi AS

-- CA01
SELECT A.kode, A.grup, A.uraian,
  SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, -(B.quantity), 0)) AS tahun_lalu,
  SUM(IF(B.tahun_periode BETWEEN v_start    AND v_end,    -(B.quantity), 0)) AS tahun_ini
FROM `data_dash.m_format_report` A
LEFT JOIN `data_dash.cds_lm16_prd` B
       ON A.uraian = B.grpolah
      AND B.batch NOT IN ('PHTG','PLSM')
      AND (p_region IS NULL OR p_region = '' OR B.region = p_region)
      AND B.tahun_periode BETWEEN v_start_tl AND v_end
-- ✅ Ganti IN subquery → JOIN langsung
JOIN plant_list pl ON B.plant = pl.plant
WHERE A.jenis_laporan = 'LM16_Karet' AND A.kode = 'CA01'
GROUP BY A.kode, A.grup, A.uraian

UNION ALL

-- CA02
SELECT A.kode, A.grup, A.uraian,
  SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, B.quantity, 0)) AS tahun_lalu,
  SUM(IF(B.tahun_periode BETWEEN v_start    AND v_end,    B.quantity, 0)) AS tahun_ini
FROM `data_dash.m_format_report` A
LEFT JOIN `data_dash.cds_lm16_prd` B
       ON A.uraian = B.grpolah
      AND B.batch NOT IN ('PHTG','PLSM')
      AND (p_region IS NULL OR p_region = '' OR B.region = p_region)
      AND B.tahun_periode BETWEEN v_start_tl AND v_end
-- ✅ Ganti IN subquery → JOIN langsung
JOIN plant_list pl ON B.plant = pl.plant
WHERE A.jenis_laporan = 'LM16_Karet' AND A.kode = 'CA02'
GROUP BY A.kode, A.grup, A.uraian

UNION ALL

-- DA01
SELECT A.kode, A.grup, A.uraian,
  COALESCE(B.tahun_lalu, 0),
  COALESCE(B.tahun_ini,  0)
FROM `data_dash.m_format_report` A
LEFT JOIN (
  SELECT 'DA01' AS kode,
    SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, -(quantity), 0)) AS tahun_lalu,
    SUM(IF(tahun_periode BETWEEN v_start    AND v_end,    -(quantity), 0)) AS tahun_ini
  FROM `data_dash.cds_lm16_prd` d
  -- ✅ JOIN langsung di dalam subquery
  JOIN plant_list pl ON d.plant = pl.plant
  WHERE d.batch IN ('PHTG','PLSM') AND d.movement = '261'
    AND d.tahun_periode BETWEEN v_start_tl AND v_end
    AND (p_region IS NULL OR p_region = '' OR d.region = p_region)
) B ON A.kode = B.kode
WHERE A.jenis_laporan = 'LM16_Karet' AND A.kode = 'DA01'

UNION ALL

-- DA02
SELECT A.kode, A.grup, A.uraian,
  COALESCE(B.tahun_lalu, 0),
  COALESCE(B.tahun_ini,  0)
FROM `data_dash.m_format_report` A
LEFT JOIN (
  SELECT 'DA02' AS kode,
    SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, -(quantity), 0)) AS tahun_lalu,
    SUM(IF(tahun_periode BETWEEN v_start    AND v_end,    -(quantity), 0)) AS tahun_ini
  FROM `data_dash.cds_lm16_prd` d
  -- ✅ JOIN langsung di dalam subquery
  JOIN plant_list pl ON d.plant = pl.plant
  WHERE d.batch IN ('PHTG','PLSM') AND d.movement IN ('101','102','701')
    AND d.tahun_periode BETWEEN v_start_tl AND v_end
    AND (p_region IS NULL OR p_region = '' OR d.region = p_region)
) B ON A.kode = B.kode
WHERE A.jenis_laporan = 'LM16_Karet' AND A.kode = 'DA02';

-- ============================================================
-- GABUNGAN & FINAL OUTPUT  (tidak berubah)
-- ============================================================
CREATE TEMP TABLE temp_gabungan AS
SELECT * FROM temp_biaya UNION ALL SELECT * FROM temp_produksi;

SET prd_tahun_lalu = (SELECT SUM(tahun_lalu) FROM temp_gabungan WHERE LEFT(kode,1) IN ('C','D'));
SET prd_tahun_ini  = (SELECT SUM(tahun_ini)  FROM temp_gabungan WHERE LEFT(kode,1) IN ('C','D'));

CREATE TEMP TABLE final_16 AS
SELECT kode, grup, uraian,
  CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND(tahun_lalu*100,0) ELSE ROUND(tahun_lalu,0) END AS biaya_tahun_lalu,
  CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND(tahun_ini *100,0) ELSE ROUND(tahun_ini, 0) END AS biaya_tahun_ini
FROM temp_gabungan ORDER BY kode;

CREATE TEMP TABLE gabungan_final AS
SELECT 'LM14' AS jenis, grup,
  SUM(biaya_total_tahun_lalu) AS biaya_tahun_lalu,
  SUM(biaya_total_tahun_ini)  AS biaya_tahun_ini
FROM final_14 GROUP BY grup
UNION ALL
SELECT 'LM16', grup,
  SUM(biaya_tahun_lalu), SUM(biaya_tahun_ini)
FROM final_16 GROUP BY grup;

SELECT
  A.kode, A.uraian,
  CASE WHEN A.kode='AA01' THEN luas_areal_tahun_lalu ELSE ROUND(B.biaya_tahun_lalu,0) END AS biaya_tahun_lalu,
  CASE WHEN A.kode='AA01' THEN luas_areal_tahun_ini  ELSE ROUND(B.biaya_tahun_ini, 0) END AS biaya_tahun_ini,
  CASE WHEN LEFT(A.kode,1) NOT IN ('A','B') THEN FORMAT('%.2F', ROUND(B.biaya_tahun_lalu/NULLIF(prd_tahun_lalu,0),2)) ELSE NULL END AS biaya_per_kg_tahun_lalu,
  CASE WHEN LEFT(A.kode,1) NOT IN ('A','B') THEN FORMAT('%.2F', ROUND(B.biaya_tahun_ini /NULLIF(prd_tahun_ini, 0),2)) ELSE NULL END AS biaya_per_kg_tahun_ini,
  CASE WHEN LEFT(A.kode,1) NOT IN ('A')     THEN FORMAT('%.2F', ROUND(B.biaya_tahun_lalu/NULLIF(luas_areal_tahun_lalu,0),2)) ELSE NULL END AS biaya_per_ha_tahun_lalu,
  CASE WHEN LEFT(A.kode,1) NOT IN ('A')     THEN FORMAT('%.2F', ROUND(B.biaya_tahun_ini /NULLIF(luas_areal_tahun_ini, 0),2)) ELSE NULL END AS biaya_per_ha_tahun_ini
FROM `data_dash.m_format_report` A
LEFT JOIN gabungan_final B ON A.kode = B.grup
WHERE A.jenis_laporan = 'LM13_Karet'
ORDER BY A.kode;

END;