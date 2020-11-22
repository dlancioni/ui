select json_agg(t) from (select 
(tb_customer.field->>'id_group')::int as id_group
, count((tb_customer.field->>'name')::text) as name
 from tb_customer
 where (tb_customer.field->>'id_system')::text = 'S20201'
 group by (tb_customer.field->>'id_group')::int

 limit 15
) t