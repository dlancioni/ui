
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


select * from tb_10
update tb_menu set id = (field->>'id_menu')::int


 alter sequence tb_menu_id_seq restart with 100;
ALTER SEQUENCE tb_menu_seq RESTART WITH 300;
pg_get_serial_sequence ("")