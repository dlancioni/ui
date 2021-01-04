set search_path to lancioni;

select 
(tb_address.field->>'id_group')::int as "id_group"
, count((tb_address_type_id_address_type.field->>'value')::text) as "Total"
, (tb_address_type_id_address_type.field->>'value')::text as "Endereco"
 from tb_address
 left join tb_domain tb_address_type_id_address_type on (tb_address.field->>'id_address_type')::text = (tb_address_type_id_address_type.field->>'key')::text 
 and (tb_address_type_id_address_type.field->>'domain')::text = 'tb_address_type'
 where 1=1
 group by (tb_address.field->>'id_group')::int
, (tb_address.field->>'id_address_type')::int
, (tb_domain_id_address_type.field->>'value')::text



                            $tableName = $fieldDomain . "_" . $fieldName;
                            $fieldName = "value";
                            $fieldType = $this->TYPE_TEXT;
                            $sql .= $jsonUtil->select($tableName, $fieldName, $fieldType, $fieldAlias, $command) . $lb;