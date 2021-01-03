set search_path to empresa;

 select 
 field->'id_module' ,
 id
 from tb_field
 order by  
 field->'id_module' ,id