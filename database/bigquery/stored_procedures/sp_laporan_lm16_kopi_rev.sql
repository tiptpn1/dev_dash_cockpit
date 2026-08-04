CREATE OR REPLACE PROCEDURE `dashboard-cockpit.data_dash.sp_laporan_lm16_kopi_rev`(p_region STRING, p_plant STRING, p_tahun STRING, p_bulan STRING)
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
SELECT X.lev2, X.lev1, Y.stasiun, X.kode, X.grup, X.uraian, 
coalesce(SUM(Y.tahun_lalu),0) tahun_lalu, 
coalesce(SUM(Y.tahun_ini),0) tahun_ini
FROM `data_dash.ref_format_report_rev` X
LEFT JOIN (
  SELECT 
    concat(right(costcenter,2),'-',stppk) as stasiun, grpaccttext,
    ROUND(SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, amount, 0)), 0) AS tahun_lalu,
    ROUND(SUM(IF(tahun_periode BETWEEN v_start AND v_end, amount, 0)), 0) AS tahun_ini
  FROM `dashboard-cockpit.data_dash.cds_lm16kp`
  WHERE LEFT(profitcenter, 4) IN (SELECT plant FROM plant_list)  -- ← filter via plant_list
  GROUP BY concat(right(costcenter,2),'-',stppk),grpaccttext
) Y ON X.uraian = Y.grpaccttext
WHERE X.jenis_laporan = 'LM16_Kopi'
AND LEFT(X.kode, 1) IN ('A', 'B')
GROUP BY X.lev2, X.lev1, Y.stasiun, X.kode, X.grup, X.uraian;

-- ==========================================
-- 🔥 LM16 - PRODUKSI
-- ==========================================
CREATE TEMP TABLE temp_produksi AS

-- CA01: Produksi non-PHTG/PLSM (quantity negatif)
SELECT A.lev2, A.lev1, '' as stasiun, A.kode, A.grup, A.uraian,
  SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, -(B.quantity), 0)) AS tahun_lalu,
  SUM(IF(B.tahun_periode BETWEEN v_start AND v_end, -(B.quantity), 0)) AS tahun_ini
FROM `data_dash.ref_format_report_rev` A
LEFT JOIN 
(
SELECT * FROM
`data_dash.cds_lm16kp_prod`
WHERE batch NOT IN ('PHTG', 'PLSM')                              
  AND (p_region IS NULL OR p_region = '' OR region = p_region)  
  AND plant IN (SELECT plant FROM plant_list)
) B
ON A.uraian = B.grpolah                     
WHERE A.jenis_laporan = 'LM16_Kopi'
AND A.kode = 'CA01'
GROUP BY A.lev2, A.lev1, A.kode, A.grup, A.uraian

UNION ALL

-- CA02: Produksi non-PHTG/PLSM (quantity positif)
SELECT A.lev2, A.lev1, '' as stasiun, A.kode, A.grup, A.uraian,
  SUM(IF(B.tahun_periode BETWEEN v_start_tl AND v_end_tl, B.quantity, 0)) AS tahun_lalu,
  SUM(IF(B.tahun_periode BETWEEN v_start AND v_end, B.quantity, 0)) AS tahun_ini
FROM `data_dash.ref_format_report_rev` A
LEFT JOIN 
(
SELECT * FROM
`data_dash.cds_lm16kp_prod` 
  WHERE batch NOT IN ('PHTG', 'PLSM')                              -- ← pindah ke ON
  AND (p_region IS NULL OR p_region = '' OR region = p_region)  -- ← pindah ke ON
  AND plant IN (SELECT plant FROM plant_list)                    -- ← filter via plant_list
) B
ON A.uraian = B.grpolah
WHERE A.jenis_laporan = 'LM16_Kopi'
AND A.kode = 'CA02'
GROUP BY A.lev2, A.lev1, A.kode, A.grup, A.uraian

UNION ALL

-- DA01: PHTG/PLSM movement 261
SELECT A.lev2, A.lev1, '' as stasiun, A.kode, A.grup, A.uraian,
  COALESCE(B.tahun_lalu, 0) AS tahun_lalu,
  COALESCE(B.tahun_ini, 0) AS tahun_ini
FROM `data_dash.ref_format_report_rev` A
LEFT JOIN (
  SELECT 'DA01' AS kode,
    SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, -(quantity), 0)) AS tahun_lalu,
    SUM(IF(tahun_periode BETWEEN v_start AND v_end, -(quantity), 0)) AS tahun_ini
  FROM `data_dash.cds_lm16kp_prod`
  WHERE batch IN ('PHTG', 'PLSM')
  AND movement = '261'
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND plant IN (SELECT plant FROM plant_list)                      -- ← filter via plant_list
) B ON A.kode = B.kode
WHERE A.jenis_laporan = 'LM16_Kopi'
AND A.kode = 'DA01'

UNION ALL

-- DA02: PHTG/PLSM movement 101/102/701
SELECT A.lev2, A.lev1, '' as stasiun, A.kode, A.grup, A.uraian,
  COALESCE(B.tahun_lalu, 0) AS tahun_lalu,
  COALESCE(B.tahun_ini, 0) AS tahun_ini
FROM `data_dash.ref_format_report_rev` A
LEFT JOIN (
  SELECT 'DA02' AS kode,
    SUM(IF(tahun_periode BETWEEN v_start_tl AND v_end_tl, -(quantity), 0)) AS tahun_lalu,
    SUM(IF(tahun_periode BETWEEN v_start AND v_end, -(quantity), 0)) AS tahun_ini
  FROM `data_dash.cds_lm16kp_prod`
  WHERE batch IN ('PHTG', 'PLSM')
  AND movement IN ('101', '102', '701')
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND plant IN (SELECT plant FROM plant_list)                      -- ← filter via plant_list
) B ON A.kode = B.kode
WHERE A.jenis_laporan = 'LM16_Kopi'
AND A.kode = 'DA02';

-- ISI PARAMETER JUMLAH PRODUKSI PEMBAGI HP
SET prd_tahun_lalu = (SELECT SUM(tahun_lalu) FROM temp_produksi WHERE LEFT(kode, 1) IN ('C', 'D'));
SET prd_tahun_ini  = (SELECT SUM(tahun_ini)  FROM temp_produksi WHERE LEFT(kode, 1) IN ('C', 'D'));

-- ==========================================
-- 🔥 GABUNGAN BIAYA & PRODUKSI
-- ==========================================
CREATE TEMP TABLE temp_gabungan AS
SELECT * FROM temp_biaya
UNION ALL
SELECT * FROM temp_produksi;

SELECT lev2, lev1, stasiun, kode, uraian, 
CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND(tahun_lalu*100,0) ELSE ROUND(tahun_lalu,0) END AS biaya_tahun_lalu, 
CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND(tahun_ini*100,0) ELSE ROUND(tahun_ini,0) END AS biaya_tahun_ini,
CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND(SAFE_DIVIDE(IFNULL(tahun_lalu,0)*100, prd_tahun_lalu),2) ELSE 0 END AS biaya_per_kg_tahun_lalu,
CASE WHEN LEFT(kode,1) NOT IN ('C','D') THEN ROUND(SAFE_DIVIDE(IFNULL(tahun_ini,0)*100, prd_tahun_ini),2) ELSE 0 END AS biaya_per_kg_tahun_ini
FROM temp_gabungan
order by lev2, lev1, stasiun, kode;


END;