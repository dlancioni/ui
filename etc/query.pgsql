-- select * from information_schema.tables where table_schema = 's20201'
set search_path to S20201;


select distinct
 tb_user_profile.field->>'id_profile' id_profile,
 tb_event.id,
 tb_event.field->>'name' as name,
 tb_event.field->>'code' as code,
 tb_domain.field->>'value' as event
 from tb_user_profile
 inner join tb_module_event on (tb_module_event.field->>'id_profile')::int = (tb_user_profile.field->>'id_profile')::int
 inner join tb_event on (tb_module_event.field->>'id_event')::int = tb_event.id
 inner join tb_domain on (tb_event.field->>'id_event')::int = (tb_domain.field->>'key')::int and (tb_domain.field->>'domain')::text = 'tb_event'
 where (tb_module_event.field->>'id_module')::int = 5
 and (tb_user_profile.field->>'id_user')::int = 1
 and (tb_event.field->>'id_target')::int = 1
 and (tb_event.field->>'name')::text <> ''
 order by tb_event.id