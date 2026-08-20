CREATE OR REPLACE PROCEDURE `dashboard-cockpit.data_dash.sp_laporan_lm62`(p_komoditi STRING, p_region STRING, p_plant STRING, p_tahun STRING, p_bulan STRING)
BEGIN

DECLARE v_start INT64;
DECLARE v_end INT64;
DECLARE v_thn_lalu INT64;
DECLARE v_start_tl INT64;
DECLARE v_end_tl INT64;
DECLARE v_komoditi STRING;

SET v_komoditi = CASE
    WHEN p_komoditi = 'kr' THEN '20'
    WHEN p_komoditi = 'th' THEN '40'
    WHEN p_komoditi = 'kp' THEN '50'
    WHEN p_komoditi = 'iht' THEN '41'
    ELSE NULL
    END;    
SET v_start = CAST(CONCAT(p_tahun, '001') AS INT64);
SET v_end   = CAST(CONCAT(p_tahun, LPAD(p_bulan, 3, '0')) AS INT64);
SET v_thn_lalu =  CAST(p_tahun AS INT64) - 1; 
SET v_start_tl = CAST(CONCAT(2023, '011') AS INT64);
SET v_end_tl = CAST(CONCAT(v_thn_lalu, '012') AS INT64);


CREATE TEMP TABLE TAHUN_LALU AS
select A.*, B.regional, B.group_id from `dashboard-cockpit.data_dash.cds_LM62` A 
join `dashboard-cockpit.data_dash.ref_plant_group` B on A.plant=B.plant  
where A.tahun_periode between v_start_tl and v_end_tl 
and A.material_type in ('Z001','Z002','Z003')
and (v_komoditi IS NULL OR v_komoditi = '' 
     OR division=v_komoditi)
and (p_region IS NULL OR p_region = '' 
     OR B.regional=p_region)
and (p_plant IS NULL OR p_plant = '' 
     OR B.group_id=p_plant);
-- and (p_material IS NULL OR p_material = '' 
--      OR A.material=p_material);


CREATE TEMP TABLE TAHUN_INI AS
select A.*, B.regional, B.group_id from `dashboard-cockpit.data_dash.cds_LM62` A 
join `dashboard-cockpit.data_dash.ref_plant_group` B on A.plant=B.plant  
where A.tahun_periode between v_start and v_end
and A.material_type in ('Z001','Z002','Z003')
and (v_komoditi IS NULL OR v_komoditi = '' 
     OR A.division=v_komoditi)
and (p_region IS NULL OR p_region = '' 
     OR B.regional=p_region)
and (p_plant IS NULL OR p_plant = '' 
     OR B.group_id=p_plant);
-- and (p_material IS NULL OR p_material = '' 
--      OR A.material=p_material);


WITH FINAL AS
(
SELECT
COALESCE(A.regional, B.regional) AS regional,
COALESCE(A.group_id, B.group_id) AS group_id,
COALESCE(A.plant, B.plant) AS plant,
COALESCE(A.material, B.material) AS material,
COALESCE(A.material_desc, B.material_desc) AS material_desc,
COALESCE(A.material_type_desc, B.material_type_desc) as material_type_desc,
COALESCE(A.uom, B.uom) as uom,
COALESCE(A.SAW, 0) SAW,
COALESCE((B.GR+B.Kor_GR), 0) PENERIMAAN,
COALESCE((B.GI+B.Kor_GI), 0) PENGELUARAN,
COALESCE((B.OW+B.Kor_OW), 0) OVERWEIGHT,
COALESCE((B.LAIN), 0) LAIN
FROM
(
select regional, group_id, plant, material, material_desc, 
case when material_type='Z003' and substring(plant,2,1)='K'  then 'Bahan Baku Kebun' 
when material_type='Z003' and substring(plant,2,1)='P'  then 'Bahan Baku Pabrik'
    else material_type_desc
    end as material_type_desc,

uom, sum(quantity) SAW
from TAHUN_LALU  
group by regional, group_id, plant, material, material_desc, 
case when material_type='Z003' and substring(plant,2,1)='K'  then 'Bahan Baku Kebun' 
when material_type='Z003' and substring(plant,2,1)='P'  then 'Bahan Baku Pabrik'
else material_type_desc end, uom
) A

FULL OUTER JOIN

(
select regional, group_id, plant, material, material_desc, material_type_desc, uom, 
  sum(COALESCE(GR,0)) as GR, 
  sum(COALESCE(Kor_GR,0)) as Kor_GR, 
  sum(COALESCE(GI,0)) as GI, 
  sum(COALESCE(Kor_GI,0)) as Kor_GI, 
  sum(COALESCE(OW,0)) as OW, 
  sum(COALESCE(Kor_OW,0)) as Kor_OW, 
  sum(COALESCE(LAIN,0)) as LAIN 
  FROM
     (
    
    -- BAHAN BAKU KEBUN
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Kebun' as material_type_desc, uom, sum(quantity) as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('101','102','343','657') and material_type='Z003' and substring(plant,2,1)='K' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Kebun' as material_type_desc, uom, 0 as GR, 0 as Kor_GR, sum(quantity) as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('301','302') and material_type='Z003' and substring(plant,2,1)='K' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    -- BAHAN BAKU PABRIK
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, sum(quantity) as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('301','305') and material_type='Z003' and substring(plant,2,1)<>'K' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, 0 as GR, sum(quantity) as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('302','306') and material_type='Z003' and substring(plant,2,1)<>'K' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, 0 as GR, 0 as Kor_GR, sum(quantity) as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('201','261') and material_type='Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, 0 as GR, 0 as Kor_GR, 0 as GI, sum(quantity) as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('202','262') and material_type='Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, 0 as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, sum(quantity) as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type='701' and material_type='Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, 0 as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, sum(quantity) as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type='702' and material_type='Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, sum(quantity) as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('309','310','411','561') and material_type='Z003' and quantity>0 group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, 0 as GR, 0 as Kor_GR, sum(quantity) as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('309','310','411','561') and material_type='Z003' and quantity<0 group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, 'Bahan Baku Pabrik' as material_type_desc, uom, 0 as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, sum(quantity) as LAIN FROM TAHUN_INI 
    where movement_type in ('601','602') and material_type='Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom

    -- SFG & FB
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, sum(quantity) as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('101','343','657') and material_type<>'Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, 0 as GR, sum(quantity) as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type='102' and material_type<>'Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, 0 as GR, 0 as Kor_GR, sum(quantity) as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('201','261') and material_type<>'Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, 0 as GR, 0 as Kor_GR, 0 as GI, sum(quantity) as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('202','262') and material_type<>'Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom 
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, 0 as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, sum(quantity) as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type='701' and material_type<>'Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, 0 as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, sum(quantity) as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type='702' and material_type<>'Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, sum(quantity) as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('309','310','411','561') and material_type<>'Z003' and quantity>=0 group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, sum(quantity) as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('301','302','303','304','305','306','311','312') and material_type<>'Z003' and quantity>=0 group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, 0 as GR, 0 as Kor_GR, sum(quantity) as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('309','310','411','561') and material_type<>'Z003' and quantity<0 group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, 0 as GR, 0 as Kor_GR, sum(quantity) as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, 0 as LAIN FROM TAHUN_INI 
    where movement_type in ('301','302','303','304','305','306','311','312') and material_type<>'Z003' and quantity<0 group by regional, group_id, plant, material, material_desc, material_type_desc, uom
    union all
    SELECT regional, group_id, plant, material, material_desc, material_type_desc, uom, 0 as GR, 0 as Kor_GR, 0 as GI, 0 as Kor_GI, 0 as OW, 0 as Kor_OW, sum(quantity) as LAIN FROM TAHUN_INI 
    where movement_type in ('601','602') and material_type<>'Z003' group by regional, group_id, plant, material, material_desc, material_type_desc, uom

     ) MUT
GROUP BY regional, group_id, plant, material, material_desc, material_type_desc, uom
) B
ON  A.regional = B.regional
AND A.group_id = B.group_id
AND A.plant = B.plant
AND A.material = B.material
AND A.material_type_desc = B.material_type_desc
order by 1,2
)

select regional, group_id, material_type_desc, Material, material_desc, uom, plant,  
ROUND(SAW,0) as SALDO_AWAL, 
ROUND(PENERIMAAN,0) as PENERIMAAN, 
ROUND(PENGELUARAN,0) as PENGELUARAN, 
ROUND(OVERWEIGHT,0) as OVERWEIGHT, 
ROUND(LAIN,0) as PENJUALAN, 
ROUND((SAW+PENERIMAAN+PENGELUARAN+LAIN),0) as SALDO_AKHIR 
from 
FINAL
order by material_type_desc, material, regional, group_id, plant;

END;