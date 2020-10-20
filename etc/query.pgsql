
select * from 
(
    -- Modules    
    select
    tb_table.id, 
    (tb_table.field->>'id_menu')::int as id_parent, 
    tb_table.field->>'name' as name
    from tb_table 
    inner join tb_profile_table on (tb_profile_table.field->>'id_table')::int = tb_table.id 
    inner join tb_profile on (tb_profile_table.field->>'id_profile')::int = tb_profile.id 
    inner join tb_user_profile on (tb_user_profile.field->>'id_profile')::int = tb_profile.id 
    where (tb_table.field->>'id_system')::int = 1 
    and (tb_user_profile.field->>'id_user')::int = 1 
    union
    -- Menus
    select 
    (field->>'id_menu')::int as id,
    (field->>'id_parent')::int as id_parent,
    (field->>'name')::text as name
    from tb_menu
    where (field->>'id_system')::int = 1
    and (field->>'id_menu')::int in 
    (
        select 
        (field->>'id_menu')::int
        from tb_table
        where (field->>'id_system')::int = 1
    )
) tb
order by 1


select json_agg(t) from (select count(*) over() as record_count,(tb_code.field->>'id_system')::int as id_system,(tb_code.field->>'id_group')::int as id_group,tb_code.id, (tb_code.field->>'comment')::text as comment, (tb_code.field->>'code')::text as code from tb_code where (tb_code.field->>'id_system')::int = 1 order by tb_code.id) t
select json_agg(t) from (select count(*) over() as record_count,(tb_code.field->>'id_system')::int as id_system,(tb_code.field->>'id_group')::int as id_group,tb_code.id, (tb_code.field->>'comment')::text as comment, (tb_code.field->>'code')::text as code from tb_code where (tb_code.field->>'id_system')::int = 1 order by tb_code.id) t