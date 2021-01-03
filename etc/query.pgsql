set search_path to empresa;

 select * from tb_module_event
 (
 select
 tb_module.id,
 (tb_module.field->>'id_menu')::int as id_parent,
 tb_module.field->>'title' as name,
 tb_module.field->>'id_style' as id_style
 from tb_module
 inner join tb_module_event on (tb_module_event.field->>'id_module')::int = tb_module.id
 inner join tb_profile on (tb_module_event.field->>'id_profile')::int = tb_profile.id
 inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id
 where (tb_user_profile.field->>'id_user')::int = 3
 union
 select
 tb_menu.id,
 (field->>'id_parent')::int as id_parent,
 (field->>'name')::text as name,
 '0' as id_style
 from tb_menu
 where tb_menu.id in
 (
 select
 (tb_module.field->>'id_menu')::int
 from tb_module
 inner join tb_module_event on (tb_module_event.field->>'id_module')::int = tb_module.id
 inner join tb_profile on (tb_module_event.field->>'id_profile')::int = tb_profile.id
 inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id
 where (tb_user_profile.field->>'id_user')::int = 3
 )
 or (tb_menu.field->>'id_parent')::int = 0
 ) tb
 order by id_parent, id

