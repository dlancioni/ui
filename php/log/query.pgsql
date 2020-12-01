select json_agg(t) from (select 
count(*) over() as record_count,
(tb_user_profile.field->>'id_group')::int as "id_group",
tb_user_profile.id
, (tb_user_profile.field->>'id_user')::int as id_user
, (tb_user_id_user.field->>'name')::text as "user"
, (tb_user_profile.field->>'id_profile')::int as id_profile
, (tb_profile_id_profile.field->>'name')::text as "profile"
 from tb_user_profile
 left join tb_user tb_user_id_user on (tb_user_profile.field->>'id_user')::text = (tb_user_id_user.id)::text
 left join tb_profile tb_profile_id_profile on (tb_user_profile.field->>'id_profile')::text = (tb_profile_id_profile.id)::text
 where (tb_user_profile.field->>'id_system')::text = 'S20201'
 order by tb_user_profile.id
 limit 15
) t