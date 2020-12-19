-- select * from information_schema.tables where table_schema = 's20201'
set search_path to S20201;

 select * from
 (
 select
 tb_module.id,
 (tb_module.field->>'id_menu')::int as id_parent,
 tb_module.field->>'title' as name,
 tb_module.field->>'id_style' as id_style
 from tb_module
 inner join tb_profile_table on (tb_profile_table.field->>'id_module')::int = tb_module.id
 inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id
 inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id
 where (tb_user_profile.field->>'id_user')::int = 1
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
 inner join tb_profile_table on (tb_profile_table.field->>'id_module')::int = tb_module.id
 inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id
 inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id
 where (tb_user_profile.field->>'id_user')::int = 1
 )
 or (tb_menu.field->>'id_parent')::int = 0
 ) tb
 order by id_parent, id
