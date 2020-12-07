set search_path to S20201;


 select * from
 (
 select
 tb_table.id,
 (tb_table.field->>'id_menu')::int as id_parent,
 tb_table.field->>'title' as name
 from tb_table
 inner join tb_profile_table on (tb_profile_table.field->>'id_table')::int = tb_table.id
 inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id
 inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id
 where (tb_user_profile.field->>'id_user')::int = 2
 union
 select
 tb_menu.id,
 (field->>'id_parent')::int as id_parent,
 (field->>'name')::text as name
 from tb_menu
 where tb_menu.id in
 (
 select
 (tb_table.field->>'id_menu')::int
 from tb_table
 inner join tb_profile_table on (tb_profile_table.field->>'id_table')::int = tb_table.id
 inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id
 inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id
 where (tb_user_profile.field->>'id_user')::int = 2
 )
 or (tb_menu.field->>'id_parent')::int = 0
 ) tb
 order by id_parent, id

