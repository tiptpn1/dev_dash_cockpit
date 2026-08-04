CREATE OR REPLACE PROCEDURE `dashboard-cockpit.data_dash.sp_laporan_lm16_karet`(p_region STRING, p_plant STRING, p_tahun STRING, p_bulan STRING)
BEGIN

DECLARE v_start INT64;
DECLARE v_end INT64;
DECLARE v_start_tl int64;
DECLARE v_end_tl int64;
DECLARE v_tahun_lalu int64;
DECLARE prd_tahun_lalu NUMERIC;
DECLARE prd_tahun_ini NUMERIC;

SET v_tahun_lalu = CAST(p_tahun AS INT64) - 1;
SET v_start = CAST(CONCAT(p_tahun, '001') AS INT64);
SET v_end   = CAST(CONCAT(p_tahun, LPAD(p_bulan, 3, '0')) AS INT64);
SET v_start_tl = CAST(CONCAT(v_tahun_lalu, '001') AS INT64);
SET v_end_tl = CAST(CONCAT(v_tahun_lalu, LPAD(p_bulan, 3, '0')) AS INT64);

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
-- 🔥 LM16 - BIAYA
-- ==========================================
CREATE TEMP TABLE temp_biaya AS
SELECT X.kode, X.grup, X.uraian, coalesce(Y.tahun_lalu,0) tahun_lalu, coalesce(Y.tahun_ini,0) tahun_ini
FROM `data_dash.m_format_report` X
LEFT JOIN (
  SELECT
    grpaccttext,
    ROUND(SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, amount, 0)), 0) AS tahun_lalu,
    ROUND(SUM(IF(tahun_periode BETWEEN v_start AND v_end, amount, 0)), 0) AS tahun_ini
  FROM `dashboard-cockpit.data_dash.cds_lm16`
  WHERE LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
  GROUP BY grpaccttext
) Y ON X.uraian = Y.grpaccttext
WHERE X.jenis_laporan = 'LM16_Karet'
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
LEFT JOIN (
 select * from `data_dash.cds_lm16_prd`
  WHERE batch NOT IN ('PHTG', 'PLSM')                              -- ← pindah ke ON
  AND (p_region IS NULL OR p_region = '' OR region = p_region)  -- ← pindah ke ON
  AND plant IN (SELECT plant FROM plant_list)  
) B ON A.uraian = B.grpolah
WHERE A.jenis_laporan = 'LM16_Karet'
AND A.kode = 'CA01'
GROUP BY A.kode, A.grup, A.uraian

UNION ALL

-- CA02: Produksi non-PHTG/PLSM (quantity positif)
SELECT A.kode, A.grup, A.uraian,
  SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, B.quantity, 0)) AS tahun_lalu,
  SUM(IF(B.tahun_periode BETWEEN v_start AND v_end, B.quantity, 0)) AS tahun_ini
FROM `data_dash.m_format_report` A
LEFT JOIN (
  select * from `data_dash.cds_lm16_prd` 
  WHERE batch NOT IN ('PHTG', 'PLSM')                              -- ← pindah ke ON
  AND (p_region IS NULL OR p_region = '' OR region = p_region)  -- ← pindah ke ON
  AND plant IN (SELECT plant FROM plant_list)                    -- ← filter via plant_list
) B
  ON A.uraian = B.grpolah
WHERE A.jenis_laporan = 'LM16_Karet'
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
  FROM `data_dash.cds_lm16_prd`
  WHERE batch IN ('PHTG', 'PLSM')
  AND movement = '261'
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND plant IN (SELECT plant FROM plant_list)                      -- ← filter via plant_list
) B ON A.kode = B.kode
WHERE A.jenis_laporan = 'LM16_Karet'
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
  FROM `data_dash.cds_lm16_prd`
  WHERE batch IN ('PHTG', 'PLSM')
  AND movement IN ('101', '102', '701')
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND plant IN (SELECT plant FROM plant_list)                      -- ← filter via plant_list
) B ON A.kode = B.kode
WHERE A.jenis_laporan = 'LM16_Karet'
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

SELECT kode, uraian, 
CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND(tahun_lalu*100,0) ELSE ROUND(tahun_lalu,0) END AS biaya_tahun_lalu, 
CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND(tahun_ini*100,0) ELSE ROUND(tahun_ini,0) END AS biaya_tahun_ini,
CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND((tahun_lalu*100)/ NULLIF(prd_tahun_lalu,0),2) ELSE NULL END AS biaya_per_kg_tahun_lalu,
CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND((tahun_ini*100)/ NULLIF(prd_tahun_ini,0),2) ELSE NULL END AS biaya_per_kg_tahun_ini
FROM temp_gabungan
order by kode;


END;