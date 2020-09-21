select
    tb_profile.id,
    tb_profile.field->>'name' as profile_name,
    tb_table.id,
    tb_table.field->>'id_parent' as id_parent,
    tb_table.field->>'name' as name,
    tb_table.field->>'table_name' as table_name
from
    tb_table
left join tb_profile_table on
    (tb_profile_table.field->>'id_table')::int = tb_table.id
left join tb_profile on
    (tb_profile_table.field->>'id_profile')::int = tb_profile.id
where (tb_table.field->>'id_system')::int = 1


