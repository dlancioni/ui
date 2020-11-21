set search_path to S20201;

select json_agg(t) from (select 
count(*) over() as record_count,
(tb_customer.field->>'id_system')::text as id_system,
(tb_customer.field->>'id_group')::int as id_group,
tb_customer.id
, (tb_customer.field->>'name')::text as name
 from tb_customer
 where (tb_customer.field->>'id_system')::text = 'S20201'
 order by tb_customer.id
 limit 15
) t