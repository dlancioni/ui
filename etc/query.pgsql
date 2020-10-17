select distinct 
tb_table.id
from tb_table 
inner join tb_profile_table on (tb_profile_table.field->>'id_table')::int = tb_table.id 
inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id 
inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id 
where (tb_table.field->>'id_system')::int = 1 
and (tb_user_profile.field->>'id_user')::int = 1 
order by tb_table.id

select * from tb_profile
select * from tb_profile_table
select * from tb_table_function
select * from tb_field
select * from tb_table where id = 14
select * from tb_user_group
select field->'sql' from tb_view

select json_agg(t) from (select count(*) over() as record_count,(tb_user_profile.field->>'id_system')::int as id_system,(tb_user_profile.field->>'id_group')::int as id_group,tb_user_profile.id, (tb_user_profile.field->>'id_user')::int as id_user, (tb_user_profile.field->>'id_profile')::int as id_profile 
from tb_user_profile where (tb_user_profile.field->>'id_system')::int = 1 and (tb_user.field->>'id_system')::int = 1 and (tb_user.field->>'username')::text = 'joao' order by tb_user_profile.id) t

select 
(tb_event.field->>'id_system')::int as id_system,
(tb_event.field->>'id_group')::int as id_group,tb_event.id, 
(tb_event.field->>'id_target')::int as id_target, 
(tb_target_id_target.field->>'value')::text as target, 
(tb_event.field->>'id_table')::int as id_table, (tb_table_id_table.field->>'name')::text as table, (tb_event.field->>'id_field')::int as id_field, (tb_field_id_field.field->>'label')::text as field, (tb_event.field->>'id_function')::int as id_function, (tb_function_id_function.field->>'name')::text as function, (tb_event.field->>'id_event')::int as id_event, (tb_event_id_event.field->>'value')::text as event, (tb_event.field->>'code')::text as code 
from tb_event 
inner join tb_domain tb_target_id_target on (tb_event.field->>'id_target')::text = (tb_target_id_target.field->>'key')::text 
    and (tb_target_id_target.field->>'domain')::text = 'tb_target' 
left join tb_table tb_table_id_table on (tb_event.field->>'id_table')::text = (tb_table_id_table.id)::text 
left join tb_field tb_field_id_field on (tb_event.field->>'id_field')::text = (tb_field_id_field.id)::text 
left join tb_function tb_function_id_function on (tb_event.field->>'id_function')::text = (tb_function_id_function.id)::text 
inner join tb_domain tb_event_id_event on (tb_event.field->>'id_event')::text = (tb_event_id_event.field->>'key')::text 
            and (tb_event_id_event.field->>'domain')::text = 'tb_event' 
where (tb_event.field->>'id_system')::int = 1 
and (tb_event.field->>'id_target')::int = 1 
and (tb_event.field->>'id_table')::int = 3
order by tb_event.id
select * from tb_profile_table
select * from tb_user_profile
select 
(tb_profile_table.field->>'id_system')::int as id_system,
(tb_profile_table.field->>'id_group')::int as id_group,
tb_profile_table.id, (tb_profile_table.field->>'id_profile')::int as id_profile, 
(tb_profile_table.field->>'id_table')::int as id_table 
from tb_profile_table where (tb_profile_table.field->>'id_system')::int = 1 
and (tb_profile_table.field->>'id_system')::int = 1 
and (tb_profile_table.field->>'id_profile')::int = 2 



 select id from tb_field where id = 0


select * from tb_profile
where (tb_profile.field->>'id_group')::int in (1,2)

select field->>'id_group' from tb_user_group where (field->>'id_user')::int = 1


