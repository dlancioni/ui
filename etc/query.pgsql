set search_path to demo;

select tb_address.field->>'id_province' from tb_address

select 
count(*) over() as record_count,
(tb_address.field->>'id_group')::int as "id_group",
tb_address.id
, (tb_address.field->>'id_entity')::int as id_entity
, (tb_entity_id_entity.field->>'name')::text as "entity"
, (tb_address.field->>'id_address_type')::int as id_address_type
, (tb_address_type_id_address_type.field->>'value')::text as "address_type"
, (tb_address.field->>'street')::text as street
, (tb_address.field->>'number')::text as number
, (tb_address.field->>'compl')::text as compl
, (tb_address.field->>'city')::text as city
, (tb_address.field->>'id_state')::int as id_state
, (tb_state_id_state.field->>'value')::text as "estado"
, (tb_address.field->>'zipcode')::text as zipcode
, (tb_address.field->>'attached')::text as attached
 from tb_address
 left join tb_entity tb_entity_id_entity on (tb_address.field->>'id_entity')::text = (tb_entity_id_entity.id)::text
 left join tb_domain tb_address_type_id_address_type on (tb_address.field->>'id_address_type')::text = (tb_address_type_id_address_type.field->>'key')::text and (tb_address_type_id_address_type.field->>'domain')::text = 'tb_address_type'
 left join tb_domain tb_state_id_state on (tb_address.field->>'id_state')::text = (tb_state_id_state.field->>'key')::text and (tb_state_id_state.field->>'domain')::text = 'tb_state'
 where 1=1
 order by id limit 15
