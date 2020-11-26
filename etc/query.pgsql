set search_path to S20201;

select 
(tb_relationship.field->>'id_group')::int as "id_group"
, count((tb_relationship.field->>'cost')::float) as "Total de Registros"
, sum((tb_relationship.field->>'cost')::float) as "Somatória"
, max((tb_relationship.field->>'cost')::float) as "Máximo"
, min((tb_relationship.field->>'cost')::float) as "Mínimo"
, avg((tb_relationship.field->>'cost')::float) as "Média"
, (tb_relationship.field->>'comment')::text as "Total de Registros"
, (tb_relationship.field->>'id_activity')::int as "ACTIVIDADE"
, (tb_activity_id_activity.field->>'description')::text as "BLABLA"
 from tb_relationship
 left join tb_activity tb_activity_id_activity on (tb_relationship.field->>'id_activity')::text = (tb_activity_id_activity.id)::text
 where (tb_relationship.field->>'id_system')::text = 'S20201'
 group by 
 (tb_relationship.field->>'id_group')::int
, (tb_relationship.field->>'comment')::text
, (tb_relationship.field->>'id_activity')::int