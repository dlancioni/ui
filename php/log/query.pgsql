select json_agg(t) from (select 
(tb_relationship.field->>'id_group')::int as "id_group"
, (tb_relationship.field->>'id_activity')::int as id_activity
, (tb_activity_id_activity.field->>'description')::text as "activity"
, sum((tb_relationship.field->>'cost')::float) as cost
 from tb_relationship
 left join tb_activity tb_activity_id_activity on (tb_relationship.field->>'id_activity')::text = (tb_activity_id_activity.id)::text
 where (tb_relationship.field->>'id_system')::text = 'S20201'
 group by (tb_relationship.field->>'id_group')::int
, (tb_relationship.field->>'id_activity')::int
, (tb_activity_id_activity.field->>'description')::text

 limit 15
) t