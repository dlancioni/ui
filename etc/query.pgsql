select count(*) over() as record_count,(tb_user.field->>'id_system')::int as id_system,(tb_user.field->>'id_group')::int as id_group,tb_user.id, (tb_user.field->>'fullname')::text as fullname, (tb_user.field->>'login')::text as login, (tb_user.field->>'password')::text as password from tb_user 
where (tb_user.field->>'id_system')::int = 1 
and (tb_user.field->>'id_system')::int = 1 
and (tb_user.field->>'login')::text = 'joao' 
order by tb_user.id

select * from tb_user