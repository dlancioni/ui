select json_agg(t) from (select 
count(*) over() as record_count,
(tb_customer.field->>'id_system')::text as id_system,
(tb_customer.field->>'id_group')::int as id_group,
tb_customer.id
, (tb_customer.field->>'client_type')::text as client_type
, (tb_client_type_client_type.field->>'value')::text as ent_type
 from tb_customer
 left join tb_domain tb_client_type_client_type on (tb_customer.field->>'client_type')::text = (tb_client_type_client_type.field->>'key')::text and (tb_client_type_client_type.field->>'domain')::text = 'tb_client_type'
 where (tb_customer.field->>'id_system')::text = 'S20201'
 order by tb_customer.id
 limit 15
) t