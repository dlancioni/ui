set search_path to S20201;

select distinct
 tb_user_profile.field->>'id_profile' id_profile,
 tb_action.id,
 tb_action.field->>'name' as name
 from tb_user_profile
 inner join tb_table_action on (tb_table_action.field->>'id_profile')::int = (tb_user_profile.field->>'id_profile')::int
 inner join tb_action on (tb_table_action.field->>'id_action')::int = tb_action.id
 where (tb_table_action.field->>'id_table')::int = 5
 and (tb_user_profile.field->>'id_user')::int = 1
 order by tb_action.id