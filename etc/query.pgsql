set search_path to S20201;
delete from tb_view_field;

select 
count(*) over() as record_count, -- Paginação
(tb_menu.field->>'id_group')::int as "id_group", -- Controle de acesso
tb_menu.id,
tb_menu.field->>'name' as name
from tb_menu




select 
count(*) over() as record_count,
(tb_table.field->>'id_group')::int as "id_group",
tb_table.id
 from tb_table