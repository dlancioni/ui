set search_path to S20201;

select 
(tb_customer.field->>'id_group')::int as id_group,
, count((tb_customer.field->>'name')::text) as name
 from tb_customer
 where (tb_customer.field->>'id_system')::text = 'S20201'
 group by (tb_customer.field->>'id_group')::int as id_group
 order by tb_customer.id
 limit 15