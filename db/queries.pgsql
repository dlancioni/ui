
select 
tb_menu.id,
tb_menu.field->>'name' as name,
tb_menu.field->>'id_parent' as id_parent
from tb_menu

/*
select 
id,
field->>'id_menu' as id_menu,
field->>'title' as title 
from tb_table 
where (field->>'id_menu')::int = 2
*/