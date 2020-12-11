set search_path to S20201;
select * from tb_view


select 
tb_menu.id,
tb_menu.field->>'name' as name
from tb_menu




select 
count(*) over() as record_count,
(tb_table.field->>'id_group')::int as "id_group",
tb_table.id
 from tb_table