select json_agg(t) from (select 
(tb_relationship.field->>'id_group')::int as "id_group"
, count((tb_relationship.field->>'cost')::float) as "Total de Registros"
, sum((tb_relationship.field->>'cost')::float) as "Somatória"
 from tb_relationship
 where (tb_relationship.field->>'id_system')::text = 'S20201'
 group by (tb_relationship.field->>'id_group')::int

 limit 15
) t