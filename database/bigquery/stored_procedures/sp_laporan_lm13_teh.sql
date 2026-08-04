CREATE OR REPLACE PROCEDURE `dashboard-cockpit.data_dash.sp_laporan_lm13_teh`(p_region STRING, p_plant STRING, p_tahun STRING, p_bulan STRING)
BEGIN

DECLARE v_start_tl INT64;
DECLARE v_end_tl INT64;
DECLARE v_start INT64;
DECLARE v_end INT64;
DECLARE v_thn_lalu INT64;

DECLARE gaji_karpim_tahun_lalu NUMERIC;
DECLARE gaji_karpim_tahun_ini NUMERIC;
DECLARE gaji_karpel_tahun_lalu NUMERIC;
DECLARE gaji_karpel_tahun_ini NUMERIC;
DECLARE total_9901_tahun_lalu NUMERIC;
DECLARE total_9901_tahun_ini NUMERIC;
DECLARE pengurang_tahun_lalu NUMERIC;
DECLARE pengurang_tahun_ini NUMERIC;

DECLARE luas_areal_tahun_lalu NUMERIC;
DECLARE luas_areal_tahun_ini NUMERIC;
DECLARE prd_tahun_lalu NUMERIC;
DECLARE prd_tahun_ini NUMERIC;

SET v_thn_lalu =  CAST(p_tahun AS INT64) - 1; 
SET v_start = CAST(CONCAT(p_tahun, '001') AS INT64);
SET v_end   = CAST(CONCAT(p_tahun, LPAD(p_bulan, 3, '0')) AS INT64);
SET v_start_tl = CAST(CONCAT(v_thn_lalu, '001') AS INT64); 
SET v_end_tl = CAST(CONCAT(v_thn_lalu, LPAD(p_bulan, 3, '0')) AS INT64);

-- ==========================================
-- 🔥 RESOLVE PLANT GROUP
-- Hierarki: regional → group_id → plant
-- ==========================================
CREATE TEMP TABLE plant_list AS
SELECT DISTINCT plant
FROM `data_dash.ref_plant_group`
WHERE
  (p_region IS NULL OR p_region = '' OR CAST(regional AS STRING) = p_region)
  AND (p_plant IS NULL OR p_plant = '' OR group_id = p_plant);

-- ==========================================
-- 🔥 PEMEL
-- ==========================================
CREATE TEMP TABLE agg_pemel AS

WITH a_agg AS (
  SELECT
    a.jobcode,
    a.tahun_periode,
    a.profitcenter,
    a.region,
    SUM(a.amount) AS amount
  FROM `data_dash.cds_lm14th` a
  JOIN plant_list pl
    ON LEFT(a.profitcenter, 4) = pl.plant  -- ← filter via plant_list (sudah cover region & group)
  WHERE a.jobcode <> '9901'
  AND a.tahun_periode BETWEEN v_start_tl AND v_end
  GROUP BY a.jobcode, a.tahun_periode, a.profitcenter, a.region
),

b_agg AS (
  SELECT
    b.jobcode,
    b.tahun_periode,
    b.profitcenter,
    SUM(b.quantity) AS quantity,
    SUM(b.amount)   AS amount
  FROM `data_dash.cds_lm14th_bb` b
  JOIN plant_list pl
    ON LEFT(b.profitcenter, 4) = pl.plant  -- ← filter via plant_list
  WHERE b.tahun_periode BETWEEN v_start_tl AND v_end
  GROUP BY b.jobcode, b.tahun_periode, b.profitcenter
)

SELECT
  a.jobcode,

  SUM(IF(a.tahun_periode BETWEEN v_start_tl AND v_end_tl, COALESCE(b.quantity,0), 0)) AS qty_tahun_lalu,
  SUM(IF(a.tahun_periode BETWEEN v_start_tl AND v_end_tl, COALESCE(b.amount,0), 0)) AS barang_bahan_tahun_lalu,
  SUM(IF(a.tahun_periode BETWEEN v_start_tl AND v_end_tl, a.amount - COALESCE(b.amount,0), 0)) AS biaya_pemeliharaan_tahun_lalu,
  SUM(IF(a.tahun_periode BETWEEN v_start_tl AND v_end_tl, a.amount, 0)) AS biaya_total_tahun_lalu,

  SUM(IF(a.tahun_periode BETWEEN v_start AND v_end, COALESCE(b.quantity,0), 0)) AS qty_tahun_ini,
  SUM(IF(a.tahun_periode BETWEEN v_start AND v_end, COALESCE(b.amount,0), 0)) AS barang_bahan_tahun_ini,
  SUM(IF(a.tahun_periode BETWEEN v_start AND v_end, a.amount - COALESCE(b.amount,0), 0)) AS biaya_pemeliharaan_tahun_ini,
  SUM(IF(a.tahun_periode BETWEEN v_start AND v_end, a.amount, 0)) AS biaya_total_tahun_ini

FROM a_agg a
LEFT JOIN b_agg b
  ON a.jobcode = b.jobcode
 AND a.tahun_periode = b.tahun_periode
 AND a.profitcenter = b.profitcenter

GROUP BY a.jobcode;

-- ==========================================
-- 🔥 BIAYA LAIN (FA%)
-- ==========================================
CREATE TEMP TABLE agg_lain AS
SELECT
  a.jobcode,
  a.gl,

  0 AS qty_tahun_lalu,
  0 AS barang_bahan_tahun_lalu,
  SUM(IF(b.tahun_periode BETWEEN v_start_tl AND v_end_tl, b.amount, 0)) AS biaya_pemeliharaan_tahun_lalu,
  SUM(IF(b.tahun_periode BETWEEN v_start_tl AND v_end_tl, b.amount, 0)) AS biaya_total_tahun_lalu,

  0 AS qty_tahun_ini,
  0 AS barang_bahan_tahun_ini,
  SUM(IF(b.tahun_periode BETWEEN v_start AND v_end, b.amount, 0)) AS biaya_pemeliharaan_tahun_ini,
  SUM(IF(b.tahun_periode BETWEEN v_start AND v_end, b.amount, 0)) AS biaya_total_tahun_ini

FROM `data_dash.m_format_report` a
JOIN `data_dash.cds_lm14th` b
  ON a.gl = b.account
JOIN plant_list pl                              -- ← filter via plant_list
  ON LEFT(b.profitcenter, 4) = pl.plant

WHERE a.kode LIKE 'FA%'

GROUP BY a.jobcode, a.gl;

-- ==========================================
-- 🔥 9901 (GAJI + TOTAL)
-- ==========================================
SET gaji_karpim_tahun_lalu = (
  SELECT SUM(amount) FROM `data_dash.cds_lm14th`
  WHERE tahun_periode BETWEEN v_start_tl AND v_end_tl
  AND jobcode = '9901'
  AND LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
  AND account IN ('51101204','90021010','90021020','90021500','90021540')
);

SET gaji_karpim_tahun_ini = (
  SELECT SUM(amount) FROM `data_dash.cds_lm14th`
  WHERE tahun_periode BETWEEN v_start AND v_end
  AND jobcode = '9901'
  AND LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
  AND account IN ('51101204','90021010','90021020','90021500','90021540')
);

SET gaji_karpel_tahun_lalu = (
  SELECT SUM(amount) FROM `data_dash.cds_lm14th`
  WHERE tahun_periode BETWEEN v_start_tl AND v_end_tl
  AND jobcode = '9901'
  AND LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
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
  )
);

SET gaji_karpel_tahun_ini = (
  SELECT SUM(amount) FROM `data_dash.cds_lm14th`
  WHERE tahun_periode BETWEEN v_start AND v_end
  AND jobcode = '9901'
  AND LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
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
  )
);

SET total_9901_tahun_lalu = (
  SELECT SUM(amount) FROM `data_dash.cds_lm14th`
  WHERE tahun_periode BETWEEN v_start_tl AND v_end_tl
  AND jobcode = '9901'
  AND LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
);

SET total_9901_tahun_ini = (
  SELECT SUM(amount) FROM `data_dash.cds_lm14th`
  WHERE tahun_periode BETWEEN v_start AND v_end
  AND jobcode = '9901'
  AND LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
);

-- ==========================================
-- 🔥 REPORT
-- ==========================================
CREATE TEMP TABLE report AS
SELECT
  X.kode,
  X.grup,
  X.jobcode,
  X.uraian,
  X.gl,

  COALESCE(P.qty_tahun_lalu,0) + COALESCE(L.qty_tahun_lalu,0) AS qty_tahun_lalu,
  COALESCE(P.barang_bahan_tahun_lalu,0) + COALESCE(L.barang_bahan_tahun_lalu,0) AS barang_bahan_tahun_lalu,
  COALESCE(P.biaya_pemeliharaan_tahun_lalu,0) + COALESCE(L.biaya_pemeliharaan_tahun_lalu,0) AS biaya_pemeliharaan_tahun_lalu,
  COALESCE(P.biaya_total_tahun_lalu,0) + COALESCE(L.biaya_total_tahun_lalu,0) AS biaya_total_tahun_lalu,

  COALESCE(P.qty_tahun_ini,0) + COALESCE(L.qty_tahun_ini,0) AS qty_tahun_ini,
  COALESCE(P.barang_bahan_tahun_ini,0) + COALESCE(L.barang_bahan_tahun_ini,0) AS barang_bahan_tahun_ini,
  COALESCE(P.biaya_pemeliharaan_tahun_ini,0) + COALESCE(L.biaya_pemeliharaan_tahun_ini,0) AS biaya_pemeliharaan_tahun_ini,
  COALESCE(P.biaya_total_tahun_ini,0) + COALESCE(L.biaya_total_tahun_ini,0) AS biaya_total_tahun_ini

FROM `data_dash.m_format_report` X

LEFT JOIN agg_pemel P
  ON X.jobcode = P.jobcode
 AND X.gl = ''  -- 🔥 penting

LEFT JOIN agg_lain L
  ON X.jobcode = L.jobcode
 AND X.gl = L.gl

WHERE X.jenis_laporan = 'LM14_Teh';

-- ==========================================
-- 🔥 BUNGKUS → FINAL 14
-- ==========================================
CREATE TEMP TABLE final_14 AS
WITH final_with_aa AS (
  SELECT
    kode,
    grup,
    jobcode,
    uraian,
    -- TAHUN LALU
    qty_tahun_lalu,
    barang_bahan_tahun_lalu,
    CASE
      WHEN kode = 'AA01' THEN gaji_karpim_tahun_lalu
      WHEN kode = 'AA02' THEN gaji_karpel_tahun_lalu
      ELSE biaya_pemeliharaan_tahun_lalu
    END AS biaya_pemeliharaan_tahun_lalu,
    CASE
      WHEN kode = 'AA01' THEN gaji_karpim_tahun_lalu
      WHEN kode = 'AA02' THEN gaji_karpel_tahun_lalu
      ELSE biaya_total_tahun_lalu
    END AS biaya_total_tahun_lalu,
    -- TAHUN INI
    qty_tahun_ini,
    barang_bahan_tahun_ini,
    CASE
      WHEN kode = 'AA01' THEN gaji_karpim_tahun_ini
      WHEN kode = 'AA02' THEN gaji_karpel_tahun_ini
      ELSE biaya_pemeliharaan_tahun_ini
    END AS biaya_pemeliharaan_tahun_ini,
    CASE
      WHEN kode = 'AA01' THEN gaji_karpim_tahun_ini
      WHEN kode = 'AA02' THEN gaji_karpel_tahun_ini
      ELSE biaya_total_tahun_ini
    END AS biaya_total_tahun_ini
  FROM report
),
pengurang AS (
  SELECT
    SUM(biaya_pemeliharaan_tahun_lalu) AS pengurang_tahun_lalu,
    SUM(biaya_pemeliharaan_tahun_ini)  AS pengurang_tahun_ini
  FROM final_with_aa
  WHERE kode LIKE 'FA%' OR kode LIKE 'AA%'
)

-- 🔥 FINAL 14
SELECT
  f.kode,
  f.grup,
  f.uraian,

  -- TAHUN LALU
  f.qty_tahun_lalu,
  ROUND(f.barang_bahan_tahun_lalu * 100, 0) AS barang_bahan_tahun_lalu,
  CASE
    WHEN f.kode = 'FB01' THEN ROUND((total_9901_tahun_lalu - p.pengurang_tahun_lalu) * 100, 0)
    ELSE ROUND(f.biaya_pemeliharaan_tahun_lalu * 100, 0)
  END AS biaya_pemeliharaan_tahun_lalu,
  CASE
    WHEN f.kode = 'FB01' THEN ROUND((total_9901_tahun_lalu - p.pengurang_tahun_lalu) * 100, 0)
    ELSE ROUND(f.biaya_total_tahun_lalu * 100, 0)
  END AS biaya_total_tahun_lalu,

  -- TAHUN INI
  f.qty_tahun_ini,
  ROUND(f.barang_bahan_tahun_ini * 100, 0) AS barang_bahan_tahun_ini,
  CASE
    WHEN f.kode = 'FB01' THEN ROUND((total_9901_tahun_ini - p.pengurang_tahun_ini) * 100, 0)
    ELSE ROUND(f.biaya_pemeliharaan_tahun_ini * 100, 0)
  END AS biaya_pemeliharaan_tahun_ini,
  CASE
    WHEN f.kode = 'FB01' THEN ROUND((total_9901_tahun_ini - p.pengurang_tahun_ini) * 100, 0)
    ELSE ROUND(f.biaya_total_tahun_ini * 100, 0)
  END AS biaya_total_tahun_ini

FROM final_with_aa f
CROSS JOIN pengurang p;

-- ==========================================
-- 🔥 LUAS AREAL
-- ==========================================
SET luas_areal_tahun_lalu = (
  SELECT SUM(ha_planted)
  FROM `data_dash.cds_lm14_mf`
  WHERE tahun_periode = v_end_tl
  AND plant IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
);

SET luas_areal_tahun_ini = (
  SELECT SUM(ha_planted)
  FROM `data_dash.cds_lm14_mf`
  WHERE tahun_periode = v_end
  AND plant IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
);

-- ==========================================
-- 🔥 LM16 - BIAYA
-- ==========================================
CREATE TEMP TABLE temp_biaya AS
SELECT X.kode, X.grup, X.uraian, Y.tahun_lalu, Y.tahun_ini
FROM `data_dash.m_format_report` X
LEFT JOIN (
  SELECT
    grpaccttext,
    ROUND(SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, amount, 0)), 0) AS tahun_lalu,
    ROUND(SUM(IF(tahun_periode BETWEEN v_start AND v_end, amount, 0)), 0) AS tahun_ini
  FROM `dashboard-cockpit.data_dash.cds_lm16th`
  WHERE LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
  GROUP BY grpaccttext
) Y ON X.uraian = Y.grpaccttext
WHERE X.jenis_laporan = 'LM16_Teh'
AND LEFT(X.kode, 1) IN ('A', 'B');

-- ==========================================
-- 🔥 LM16 - PRODUKSI
-- ==========================================
CREATE TEMP TABLE temp_produksi AS

-- CA01: Produksi non-PHTG/PLSM (quantity negatif)
SELECT A.kode, A.grup, A.uraian,
  SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, -(B.quantity), 0)) AS tahun_lalu,
  SUM(IF(B.tahun_periode BETWEEN v_start AND v_end, -(B.quantity), 0)) AS tahun_ini
FROM `data_dash.m_format_report` A
LEFT JOIN
(
  SELECT *
  FROM `data_dash.cds_lm16th_prod`
  WHERE batch NOT IN ('PHTG', 'PLSM')
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND plant IN (SELECT plant FROM plant_list)                      -- ← filter via plant_list
) B
  ON A.uraian = B.grpolah
WHERE A.jenis_laporan = 'LM16_Teh'
AND A.kode = 'CA01'
GROUP BY A.kode, A.grup, A.uraian

UNION ALL

-- CA02: Produksi non-PHTG/PLSM (quantity positif)
SELECT A.kode, A.grup, A.uraian,
  SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, B.quantity, 0)) AS tahun_lalu,
  SUM(IF(B.tahun_periode BETWEEN v_start AND v_end, B.quantity, 0)) AS tahun_ini
FROM `data_dash.m_format_report` A
LEFT JOIN 
(
  SELECT *
  FROM `data_dash.cds_lm16th_prod`
  WHERE batch NOT IN ('PHTG', 'PLSM')
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND plant IN (SELECT plant FROM plant_list)                      -- ← filter via plant_list
) B 
  ON A.uraian = B.grpolah
WHERE A.jenis_laporan = 'LM16_Teh'
AND A.kode = 'CA02'
GROUP BY A.kode, A.grup, A.uraian

UNION ALL

-- DA01: PHTG/PLSM movement 261
SELECT A.kode, A.grup, A.uraian,
  COALESCE(B.tahun_lalu, 0) AS tahun_lalu,
  COALESCE(B.tahun_ini, 0) AS tahun_ini
FROM `data_dash.m_format_report` A
LEFT JOIN (
  SELECT 'DA01' AS kode,
    SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, -(quantity), 0)) AS tahun_lalu,
    SUM(IF(tahun_periode BETWEEN v_start AND v_end, -(quantity), 0)) AS tahun_ini
  FROM `data_dash.cds_lm16th_prod`
  WHERE batch IN ('PHTG', 'PLSM')
  AND movement = '261'
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND plant IN (SELECT plant FROM plant_list)                      -- ← filter via plant_list
) B ON A.kode = B.kode
WHERE A.jenis_laporan = 'LM16_Teh'
AND A.kode = 'DA01'

UNION ALL

-- DA02: PHTG/PLSM movement 101/102/701
SELECT A.kode, A.grup, A.uraian,
  COALESCE(B.tahun_lalu, 0) AS tahun_lalu,
  COALESCE(B.tahun_ini, 0) AS tahun_ini
FROM `data_dash.m_format_report` A
LEFT JOIN (
  SELECT 'DA02' AS kode,
    SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, -(quantity), 0)) AS tahun_lalu,
    SUM(IF(tahun_periode BETWEEN v_start AND v_end, -(quantity), 0)) AS tahun_ini
  FROM `data_dash.cds_lm16th_prod`
  WHERE batch IN ('PHTG', 'PLSM')
  AND movement IN ('101', '102', '701')
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND plant IN (SELECT plant FROM plant_list)                      -- ← filter via plant_list
) B ON A.kode = B.kode
WHERE A.jenis_laporan = 'LM16_Teh'
AND A.kode = 'DA02';

-- ==========================================
-- 🔥 GABUNGAN BIAYA & PRODUKSI
-- ==========================================
CREATE TEMP TABLE temp_gabungan AS
SELECT * FROM temp_biaya
UNION ALL
SELECT * FROM temp_produksi;

-- ISI PARAMETER JUMLAH PRODUKSI PEMBAGI HP
SET prd_tahun_lalu = (SELECT SUM(tahun_lalu) FROM temp_gabungan WHERE LEFT(kode, 1) IN ('C', 'D'));
SET prd_tahun_ini  = (SELECT SUM(tahun_ini)  FROM temp_gabungan WHERE LEFT(kode, 1) IN ('C', 'D'));

-- ==========================================
-- 🔥 FINAL 16
-- ==========================================
CREATE TEMP TABLE final_16 AS
SELECT
  kode, grup, uraian,
  CASE WHEN LEFT(kode, 1) NOT IN ('C', 'D') THEN ROUND(tahun_lalu * 100, 0) ELSE ROUND(tahun_lalu, 0) END AS biaya_tahun_lalu,
  CASE WHEN LEFT(kode, 1) NOT IN ('C', 'D') THEN ROUND(tahun_ini  * 100, 0) ELSE ROUND(tahun_ini,  0) END AS biaya_tahun_ini
FROM temp_gabungan
ORDER BY kode;

-- ==========================================
-- 🔥 GABUNG LM14 & LM16
-- ==========================================
CREATE TEMP TABLE gabungan_final AS
SELECT 'LM14' AS jenis, grup,
  SUM(biaya_total_tahun_lalu) AS biaya_tahun_lalu,
  SUM(biaya_total_tahun_ini)  AS biaya_tahun_ini
FROM final_14
GROUP BY grup

UNION ALL

SELECT 'LM16' AS jenis, grup,
  SUM(biaya_tahun_lalu) AS biaya_tahun_lalu,
  SUM(biaya_tahun_ini)  AS biaya_tahun_ini
FROM final_16
GROUP BY grup;

-- ==========================================
-- 🔥 FINAL OUTPUT (RELASI LM13)
-- ==========================================
SELECT
  A.kode,
  A.uraian,
  CASE WHEN A.kode = 'AA01' THEN luas_areal_tahun_lalu ELSE ROUND(COALESCE(B.biaya_tahun_lalu, 0), 0) END AS biaya_tahun_lalu,
  CASE WHEN A.kode = 'AA01' THEN luas_areal_tahun_ini  ELSE ROUND(COALESCE(B.biaya_tahun_ini,  0), 0) END AS biaya_tahun_ini,
  CASE WHEN LEFT(A.kode, 1) NOT IN ('A', 'B') THEN FORMAT('%.2F', ROUND(B.biaya_tahun_lalu / NULLIF(prd_tahun_lalu,0), 2)) ELSE NULL END AS biaya_per_kg_tahun_lalu,
  CASE WHEN LEFT(A.kode, 1) NOT IN ('A', 'B') THEN FORMAT('%.2F', ROUND(B.biaya_tahun_ini  / NULLIF(prd_tahun_ini,0),  2)) ELSE NULL END AS biaya_per_kg_tahun_ini,
  CASE WHEN LEFT(A.kode, 1) NOT IN ('A')       THEN FORMAT('%.2F', ROUND(B.biaya_tahun_lalu / NULLIF(luas_areal_tahun_lalu,0), 2)) ELSE NULL END AS biaya_per_ha_tahun_lalu,
  CASE WHEN LEFT(A.kode, 1) NOT IN ('A')       THEN FORMAT('%.2F', ROUND(B.biaya_tahun_ini  / NULLIF(luas_areal_tahun_ini,0),  2)) ELSE NULL END AS biaya_per_ha_tahun_ini

FROM `data_dash.m_format_report` A
LEFT JOIN gabungan_final B
  ON A.kode = B.grup
WHERE A.jenis_laporan = 'LM13_Teh'
ORDER BY A.kode;

END;