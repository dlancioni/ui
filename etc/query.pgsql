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