select json_agg(t) from (select 
count(*) over() as record_count,
(tb_menu.field->>'id_group')::int as "id_group",
tb_menu.id
, (tb_menu.field->>'name')::text as name
, (tb_menu.field->>'id_parent')::int as id_parent
, (tb_menu_id_parent.field->>'name')::text as "parent"
 from tb_menu
 left join tb_menu tb_menu_id_parent on (tb_menu.field->>'id_parent')::text = (tb_menu_id_parent.id)::text
 where (tb_menu.field->>'id_system')::text = 'S20201'
 order by tb_menu.id
 limit 15
) t