set search_path to S20201;



 select distinct
 tb_user_profile.field->>'id_profile' id_profile,
 tb_action.id,
 tb_action.field->>'name' as name
 from tb_user_profile
 inner join tb_module_action on (tb_module_action.field->>'id_profile')::int = (tb_user_profile.field->>'id_profile')::int
 inner join tb_action on (tb_module_action.field->>'id_action')::int = tb_action.id
 where (tb_module_action.field->>'id_module')::int = 15
 and (tb_user_profile.field->>'id_user')::int = 1
 order by tb_action.id