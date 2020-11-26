select json_agg(t) from (select 
count(*) over() as record_count,
(tb_file.field->>'id_group')::int as "id_group",
tb_file.id
, (tb_file.field->>'id_client')::int as id_client
, (tb_customer_id_client.field->>'name')::text as "client"
, (tb_file.field->>'file_name')::text as file_name
, (tb_file.field->>'description')::text as description
, (tb_file.field->>'file')::text as file
 from tb_file
 left join tb_customer tb_customer_id_client on (tb_file.field->>'id_client')::text = (tb_customer_id_client.id)::text
 where (tb_file.field->>'id_system')::text = 'S20201'
 order by tb_file.id
 limit 15
) t