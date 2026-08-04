CREATE OR REPLACE PROCEDURE `dashboard-cockpit.data_dash.sp_laporan_lm34_by_negara`(p_komoditi STRING, p_region STRING, p_plant STRING, p_tahun STRING, p_bulan STRING)
BEGIN

DECLARE v_tahun_ini INT64;
DECLARE v_bulan INT64;
DECLARE v_tahun_lalu INT64;
DECLARE v_komoditi STRING;

SET v_tahun_ini = CAST(p_tahun AS INT64);
SET v_bulan = CAST(p_bulan AS INT64);
SET v_tahun_lalu = v_tahun_ini - 1;
SET v_komoditi=UPPER(p_komoditi);

SELECT 
  country_id, 
  country_name, 
  sum(volume_tahun_lalu) as volume_tahun_lalu,
  sum(nilai_tahun_lalu) / NULLIF(sum(volume_tahun_lalu), 0) as harga_tahun_lalu,
  sum(nilai_tahun_lalu) as nilai_tahun_lalu,
  sum(volume_tahun_ini) as volume_tahun_ini,
  sum(nilai_tahun_ini) / NULLIF(sum(volume_tahun_ini), 0) as harga_tahun_ini,
  sum(nilai_tahun_ini) as nilai_tahun_ini

FROM (
  SELECT 
    plant,
    region, 
    komoditi,
    country_id, 
    country_name,
    COALESCE(SUM(IF(tahun = v_tahun_lalu AND periode BETWEEN 1 AND v_bulan, quantity, 0)), 0) AS volume_tahun_lalu,
    COALESCE(SUM(IF(tahun = v_tahun_lalu AND periode BETWEEN 1 AND v_bulan, amount, 0)), 0) AS nilai_tahun_lalu,
    COALESCE(SUM(IF(tahun = v_tahun_ini AND periode BETWEEN 1 AND v_bulan, quantity, 0)), 0) AS volume_tahun_ini,
    COALESCE(SUM(IF(tahun = v_tahun_ini AND periode BETWEEN 1 AND v_bulan, amount, 0)), 0) AS nilai_tahun_ini
  FROM `data_dash.vw_lm34`
  WHERE komoditi = v_komoditi
  GROUP BY plant, region, komoditi, country_id, country_name
) X

WHERE (p_region IS NULL OR p_region = '' OR region=p_region)
  AND (p_plant IS NULL OR p_plant = '' OR plant=p_plant)
GROUP BY country_id, country_name
ORDER BY country_name;

END;