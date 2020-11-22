set search_path to S20201;

select 
(tb_relationship.field->>'id_group')::int as id_group
, count((tb_relationship.field->>'cost')::float) as cost
, sum((tb_relationship.field->>'cost')::float) as cost
, max((tb_relationship.field->>'cost')::float) as cost
, min((tb_relationship.field->>'cost')::float) as "cost"
, avg((tb_relationship.field->>'cost')::float) as "cost of"
 from tb_relationship
 where (tb_relationship.field->>'id_system')::text = 'S20201'
 group by (tb_relationship.field->>'id_group')::int

 limit 15