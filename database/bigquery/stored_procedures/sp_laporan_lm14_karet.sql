CREATE OR REPLACE PROCEDURE `dashboard-cockpit.data_dash.sp_laporan_lm14_karet`(p_region STRING, p_plant STRING, p_tahun STRING, p_bulan STRING)
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

SET v_thn_lalu =  CAST(p_tahun AS INT64) - 1; 
SET v_start = CAST(CONCAT(p_tahun, '001') AS INT64);
SET v_end   = CAST(CONCAT(p_tahun, LPAD(p_bulan, 3, '0')) AS INT64);
SET v_start_tl = CAST(CONCAT(v_thn_lalu, '001') AS INT64); 
SET v_end_tl = CAST(CONCAT(v_thn_lalu, LPAD(p_bulan, 3, '0')) AS INT64);
SET luas_areal_tahun_lalu = (SELECT COALESCE(SUM(ha_planted),0) from `data_dash.cds_lm14_mf` WHERE status='KM' AND tahun_periode=v_end_tl 
   AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
   AND (p_plant IS NULL OR p_plant = '' 
     OR plant=p_plant));
SET luas_areal_tahun_ini = (SELECT COALESCE(SUM(ha_planted),0) from `data_dash.cds_lm14_mf` WHERE status='KM' AND tahun_periode=v_end 
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
  FROM `data_dash.cds_lm14`
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
  FROM `data_dash.cds_lm14_bb`
  WHERE tahun_periode BETWEEN v_start_tl AND v_end           -- ← filter periode
  AND (p_plant IS NULL OR p_plant = '' 
       OR profitcenter LIKE CONCAT(p_plant, '%'))            -- ← filter plant
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

select 
X.jobcode,
X.gl,
X.uraian, 
  0 AS qty_tahun_lalu,
  0 AS barang_bahan_tahun_lalu, 
(coalesce(X.nilai_tahun_lalu,0) + coalesce(Y.nilai_tahun_lalu,0))  as biaya_pemeliharaan_tahun_lalu,
(coalesce(X.nilai_tahun_lalu,0) + coalesce(Y.nilai_tahun_lalu,0))  as biaya_total_tahun_lalu,
  0 AS qty_tahun_ini,
  0 AS barang_bahan_tahun_ini,
(coalesce(X.nilai_tahun_ini,0) + coalesce(Y.nilai_tahun_ini,0))  as biaya_pemeliharaan_tahun_ini,
(coalesce(X.nilai_tahun_ini,0) + coalesce(Y.nilai_tahun_ini,0))  as biaya_total_tahun_ini

from

(select 
A.jobcode, 
A.gl,
A.uraian, 
sum(if(B.tahun_periode between v_start_tl and v_end_tl, coalesce(B.amount,0), 0)) as nilai_tahun_lalu,
sum(if(B.tahun_periode between v_start and v_end, coalesce(B.amount,0), 0)) as nilai_tahun_ini  
 from `data_dash.m_format_report` as A 
 left join `data_dash.cds_lm14` as B
on A.jobcode=B.jobcode 
 and A.gl=B.account
 and (p_region IS NULL OR p_region = '' 
     OR B.region=p_region)
 and (p_plant IS NULL OR p_plant = '' 
     OR B.profitcenter LIKE CONCAT(p_plant, '%'))
 where A.jenis_laporan='LM14_Karet' 
 and A.jobcode='9901' 
 and A.kode like 'EA%'
 group by A.jobcode, A.gl, A.uraian) as X

left join

(select 
A.uraian_4, 
sum(if(B.tahun_periode between v_start_tl and v_end_tl, coalesce(B.amount,0), 0)) as nilai_tahun_lalu,
sum(if(B.tahun_periode between v_start and v_end, coalesce(B.amount,0), 0)) as nilai_tahun_ini  
from `data_dash.report_hierarchy` as A
left join `data_dash.cds_lm14` as B
on A.key1=B.jobcode 
and A.key2=B.account
and (p_region IS NULL OR p_region = '' 
     OR B.region=p_region)
and (p_plant IS NULL OR p_plant = '' 
     OR B.profitcenter LIKE CONCAT(p_plant, '%'))
where A.jenis_laporan='LM14_Karet' 
and A.key1='-'
group by A.uraian_4) as Y

on X.uraian=Y.uraian_4
order by X.jobcode, X.gl, X.uraian;


-- 🔥 9901 (GAJI + TOTAL)
SET gaji_karpim_tahun_lalu = (
SELECT SUM(amount) FROM `data_dash.cds_lm14`
WHERE tahun_periode BETWEEN v_start_tl AND v_end_tl AND jobcode='9901'
AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
AND (p_plant IS NULL OR p_plant = '' 
     OR profitcenter LIKE CONCAT(p_plant, '%'))
AND account IN ('51101204','90021010','90021020','90021500','90021540')
);

SET gaji_karpim_tahun_ini = (
SELECT SUM(amount) FROM `data_dash.cds_lm14`
WHERE tahun_periode BETWEEN v_start AND v_end AND jobcode='9901'
AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
AND (p_plant IS NULL OR p_plant = '' 
     OR profitcenter LIKE CONCAT(p_plant, '%'))
AND account IN ('51101204','90021010','90021020','90021500','90021540')
);

SET gaji_karpel_tahun_lalu = (
SELECT SUM(amount) FROM `data_dash.cds_lm14`
WHERE tahun_periode BETWEEN v_start_tl AND v_end_tl AND jobcode='9901'
AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
AND (p_plant IS NULL OR p_plant = '' 
     OR profitcenter LIKE CONCAT(p_plant, '%'))
AND account IN ('51100402',
'51100403',
'51100410',
'51100412',
'51100413',
'51100427',
'51100429',
'51100430',
'51100433',
'51100434',
'51100440',
'51100441',
'51100442',
'51100456',
'51100459',
'51100639',
'51100640',
'51101021',
'51101071',
'54000016',
'51100401',
'51101047',
'51101061',
'90021522',
'98000401',
'98000402',
'98000403',
'98000410',
'98000412',
'98000413',
'98000427',
'98000429',
'98000430',
'98000433',
'98000434',
'98000440',
'98000441',
'98000442',
'98000456',
'98000459',
'98000639',
'98000640',
'98001021',
'98001071',
'98043000',
'98043001',
'90021036',
'90021501',
'90021526',
'98001204',
'90021504')
);

SET gaji_karpel_tahun_ini = (
SELECT SUM(amount) FROM `data_dash.cds_lm14`
WHERE tahun_periode BETWEEN v_start AND v_end AND jobcode='9901'
AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
AND (p_plant IS NULL OR p_plant = '' 
     OR profitcenter LIKE CONCAT(p_plant, '%'))
AND account IN ('51100402',
'51100403',
'51100410',
'51100412',
'51100413',
'51100427',
'51100429',
'51100430',
'51100433',
'51100434',
'51100440',
'51100441',
'51100442',
'51100456',
'51100459',
'51100639',
'51100640',
'51101021',
'51101071',
'54000016',
'51100401',
'51101047',
'51101061',
'90021522',
'98000401',
'98000402',
'98000403',
'98000410',
'98000412',
'98000413',
'98000427',
'98000429',
'98000430',
'98000433',
'98000434',
'98000440',
'98000441',
'98000442',
'98000456',
'98000459',
'98000639',
'98000640',
'98001021',
'98001071',
'98043000',
'98043001',
'90021036',
'90021501',
'90021526',
'98001204',
'90021504')
);

SET total_9901_tahun_lalu = (
SELECT SUM(amount) FROM `data_dash.cds_lm14`
WHERE tahun_periode BETWEEN v_start_tl AND v_end_tl AND jobcode='9901'
AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
AND (p_plant IS NULL OR p_plant = '' 
     OR profitcenter LIKE CONCAT(p_plant, '%'))
);

SET total_9901_tahun_ini = (
SELECT SUM(amount) FROM `data_dash.cds_lm14`
WHERE tahun_periode BETWEEN v_start AND v_end AND jobcode='9901'
AND (p_region IS NULL OR p_region = '' 
     OR region=p_region)
AND (p_plant IS NULL OR p_plant = '' 
     OR profitcenter LIKE CONCAT(p_plant, '%'))
);

-- 🔥 REPORT
CREATE TEMP TABLE report AS
SELECT
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

FROM `data_dash.m_format_report` X

LEFT JOIN agg_pemel P
  ON X.jobcode = P.jobcode
 AND X.gl IS NULL   -- 🔥 penting

LEFT JOIN agg_lain L
  ON X.jobcode = L.jobcode
 AND X.gl = L.gl

WHERE X.jenis_laporan='LM14_Karet';

--BUNGKUS
WITH final_with_aa AS (
  SELECT
    kode,
    jobcode,
    uraian,
    -- TAHUN LALU
    qty_tahun_lalu,
    barang_bahan_tahun_lalu,
    CASE 
      WHEN kode='AA01' THEN gaji_karpim_tahun_lalu
      WHEN kode='AA02' THEN gaji_karpel_tahun_lalu
      ELSE biaya_pemeliharaan_tahun_lalu
    END AS biaya_pemeliharaan_tahun_lalu,

    CASE 
      WHEN kode='AA01' THEN gaji_karpim_tahun_lalu
      WHEN kode='AA02' THEN gaji_karpel_tahun_lalu
      ELSE biaya_total_tahun_lalu
    END AS biaya_total_tahun_lalu,

    -- TAHUN INI
    qty_tahun_ini,
    barang_bahan_tahun_ini,
    CASE 
      WHEN kode='AA01' THEN gaji_karpim_tahun_ini
      WHEN kode='AA02' THEN gaji_karpel_tahun_ini
      ELSE biaya_pemeliharaan_tahun_ini
    END AS biaya_pemeliharaan_tahun_ini,

    CASE 
      WHEN kode='AA01' THEN gaji_karpim_tahun_ini
      WHEN kode='AA02' THEN gaji_karpel_tahun_ini
      ELSE biaya_total_tahun_ini
    END AS biaya_total_tahun_ini

  FROM report
)
, pengurang AS (
  SELECT
    SUM(biaya_pemeliharaan_tahun_lalu) AS pengurang_tahun_lalu,
    SUM(biaya_pemeliharaan_tahun_ini) AS pengurang_tahun_ini
  FROM final_with_aa
  WHERE kode LIKE 'EA%' OR kode LIKE 'AA%'
)

SELECT '0000' as kode,
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
  f.kode,
  f.uraian,

  -- TAHUN LALU
  f.qty_tahun_lalu,
  round(f.barang_bahan_tahun_lalu*100,0) barang_bahan_tahun_lalu,

  CASE 
    WHEN f.kode='EB16' THEN round((total_9901_tahun_lalu - p.pengurang_tahun_lalu)*100,0)
    ELSE round(f.biaya_pemeliharaan_tahun_lalu*100,0)
  END AS biaya_pemeliharaan_tahun_lalu,

  CASE 
    WHEN f.kode='EB16' THEN round((total_9901_tahun_lalu - p.pengurang_tahun_lalu)*100,0)
    ELSE round(f.biaya_total_tahun_lalu*100,0)
  END AS biaya_total_tahun_lalu,
  
  CASE 
    WHEN f.kode = 'EB16' THEN 
      ROUND(
        IFNULL(SAFE_DIVIDE((total_9901_tahun_lalu - p.pengurang_tahun_lalu) * 100, luas_areal_tahun_lalu), 0),
      2)

    ELSE 
      ROUND(
        IFNULL(SAFE_DIVIDE(f.biaya_total_tahun_lalu * 100, luas_areal_tahun_lalu), 0),
      2)
  END AS biaya_per_ha_tahun_lalu,

  -- TAHUN INI
  f.qty_tahun_ini,
  round(f.barang_bahan_tahun_ini*100,0) barang_bahan_tahun_ini,

  CASE 
    WHEN f.kode='EB16' THEN round((total_9901_tahun_ini - p.pengurang_tahun_ini)*100,0)
    ELSE round(f.biaya_pemeliharaan_tahun_ini*100,0)
  END AS biaya_pemeliharaan_tahun_ini,

  CASE 
    WHEN f.kode='EB16' THEN round((total_9901_tahun_ini - p.pengurang_tahun_ini)*100,0)
    ELSE round(f.biaya_total_tahun_ini*100,0)
  END AS biaya_total_tahun_ini,

  CASE 
    WHEN f.kode = 'EB16' THEN 
      ROUND(
        IFNULL(SAFE_DIVIDE((total_9901_tahun_ini - p.pengurang_tahun_ini) * 100, luas_areal_tahun_ini), 0),
      2)

    ELSE 
      ROUND(
        IFNULL(SAFE_DIVIDE(f.biaya_total_tahun_ini * 100, luas_areal_tahun_ini), 0),
      2)
  END AS biaya_per_ha_tahun_ini

FROM final_with_aa f
CROSS JOIN pengurang p
ORDER BY kode;

END;