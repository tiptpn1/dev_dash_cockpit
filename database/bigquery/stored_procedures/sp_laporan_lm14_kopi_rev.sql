CREATE OR REPLACE PROCEDURE `dashboard-cockpit.data_dash.sp_laporan_lm14_kopi_rev`(p_region STRING, p_plant STRING, p_tahun STRING, p_bulan STRING)
BEGIN

DECLARE v_start_tl INT64;
DECLARE v_end_tl INT64;
DECLARE v_start INT64;
DECLARE v_end INT64;
DECLARE v_thn_lalu INT64;

DECLARE luas_areal_tahun_lalu NUMERIC;
DECLARE luas_areal_tahun_ini NUMERIC;

SET v_thn_lalu =  CAST(p_tahun AS INT64) - 1; 
SET v_start = CAST(CONCAT(p_tahun, '001') AS INT64);
SET v_end   = CAST(CONCAT(p_tahun, LPAD(p_bulan, 3, '0')) AS INT64);
SET v_start_tl = CAST(CONCAT(v_thn_lalu, '001') AS INT64); 
SET v_end_tl = CAST(CONCAT(v_thn_lalu, LPAD(p_bulan, 3, '0')) AS INT64);

SET luas_areal_tahun_lalu = (SELECT COALESCE(SUM(ha_planted),0) from `data_dash.cds_lm14_mf` WHERE status='FM' AND tahun_periode=v_end_tl 
   AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
   AND (p_plant IS NULL OR p_plant = '' 
     OR plant=p_plant));
SET luas_areal_tahun_ini = (SELECT COALESCE(SUM(ha_planted),0) from `data_dash.cds_lm14_mf` WHERE status='FM' AND tahun_periode=v_end 
   AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
   AND (p_plant IS NULL OR p_plant = '' 
     OR plant=p_plant));


-- 🔥 PEMEL (TANPA PRE-AGG BB)
CREATE TEMP TABLE agg_pemel AS

WITH a_agg AS (
  SELECT
    jobcode,
    tahun_periode,
    profitcenter,
    region,
    SUM(amount) AS amount
  FROM `data_dash.cds_lm14kp`
  WHERE jobcode <> '9901'
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND (p_plant IS NULL OR p_plant = '' OR profitcenter LIKE CONCAT(p_plant, '%'))
  AND tahun_periode BETWEEN v_start_tl AND v_end
  GROUP BY jobcode, tahun_periode, profitcenter, region
),

b_agg AS (
  SELECT
    jobcode,
    tahun_periode,
    profitcenter,
    SUM(quantity) AS quantity,
    SUM(amount)   AS amount
  FROM `data_dash.cds_lm14kp_bb`
  WHERE tahun_periode BETWEEN v_start_tl AND v_end           
  AND (p_region IS NULL OR p_region = '' OR region = p_region)
  AND (p_plant IS NULL OR p_plant = '' 
       OR profitcenter LIKE CONCAT(p_plant, '%'))            
  GROUP BY jobcode, tahun_periode, profitcenter
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

FROM `a_agg` a
LEFT JOIN `b_agg` b
  ON a.jobcode = b.jobcode
 AND a.tahun_periode = b.tahun_periode
 AND a.profitcenter = b.profitcenter

GROUP BY a.jobcode;

-- 🔥 BIAYA LAIN (DA%)
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

FROM `data_dash.ref_format_report_rev` a
JOIN `data_dash.cds_lm14kp` b
  ON a.gl = b.account

WHERE a.jobcode='9901'
AND (p_region IS NULL OR p_region = '' 
     OR b.region=p_region)
AND (p_plant IS NULL OR p_plant = '' 
     OR b.profitcenter LIKE CONCAT(p_plant, '%'))

GROUP BY a.jobcode, a.gl;

-- 🔥 REPORT
CREATE TEMP TABLE report AS
SELECT
  X.lev2,
  X.lev1,
  X.kode,
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

FROM `data_dash.ref_format_report_rev` X

LEFT JOIN agg_pemel P
  ON X.jobcode = P.jobcode
 AND X.gl is null   -- 🔥 penting

LEFT JOIN agg_lain L
  ON X.jobcode = L.jobcode
 AND X.gl = L.gl

WHERE X.jenis_laporan='LM14_Kopi';


SELECT 
'A. LUAS AREAL' as lev2, 'A.1. LUAS AREAL' as lev1,
'0000' as kode,
'LUAS AREAL' as uraian,
luas_areal_tahun_lalu as qty_tahun_lalu,
0 as barang_bahan_tahun_lalu,
0 as biaya_pemeliharaan_tahun_lalu,
0 as biaya_total_tahun_lalu,
0 as biaya_per_ha_tahun_lalu,
luas_areal_tahun_ini as qty_tahun_ini,
0 as barang_bahan_tahun_ini,
0 as biaya_pemeliharaan_tahun_ini,
0 as biaya_total_tahun_ini,
0 as biaya_per_ha_tahun_ini

UNION ALL

-- 🔥 FINAL
SELECT
lev2,
lev1,
  kode,
  uraian,

  -- TAHUN LALU
  qty_tahun_lalu,
  round(barang_bahan_tahun_lalu*100,0) AS barang_bahan_tahun_lalu,
  round(biaya_pemeliharaan_tahun_lalu*100,0) AS biaya_pemeliharaan_tahun_lalu,
  round(biaya_total_tahun_lalu*100,0) AS biaya_total_tahun_lalu,
  ROUND(
        IFNULL(SAFE_DIVIDE(biaya_total_tahun_lalu * 100, luas_areal_tahun_lalu), 0),
      2) AS biaya_per_ha_tahun_lalu,
  qty_tahun_ini,
  round(barang_bahan_tahun_ini*100,0) barang_bahan_tahun_ini,
  round(biaya_pemeliharaan_tahun_ini*100,0) AS biaya_pemeliharaan_tahun_ini,
  round(biaya_total_tahun_ini*100,0) AS biaya_total_tahun_ini,
  ROUND(
        IFNULL(SAFE_DIVIDE(biaya_total_tahun_ini * 100, luas_areal_tahun_ini), 0),
      2) AS biaya_per_ha_tahun_ini
FROM report
ORDER BY lev2,lev1,kode;

END;