-- -----------------------------------------------------
-- 7 TB_CODE
-- -----------------------------------------------------
insert into tb_code (field) values ('{"id_system": 1, "id_group": 1, "comment": "Obtem o valor numérico de um campo", "id": 1, "code": "function valor(campo) {\r\n\r\n    value = field(campo).value;\r\n\r\n    if (value.trim() == \"\") {\r\n        value = \"0\";\r\n    }\r\n\r\n    if (!isNumeric(value)) {\r\n        value = \"0\";\r\n    }\r\n\r\n    value = value.split(\".\").join(\"\");\r\n    value = value.split(\",\").join(\".\");\r\n    value = parseFloat(value);\r\n\r\n    return value;\r\n}"}');
insert into tb_code (field) values ('{"id_system": 1, "id_group": 1, "comment": "Exemplo de query em banco de dados", "id": 2, "code": "let rs = query(\"select 1*2 as total\");\r\nalert(rs[0].total);"}');


-- -----------------------------------------------------
-- 7 TB_VIEW
-- -----------------------------------------------------
insert into tb_view (field) values ('{"id_system": 1, "id_group": 2, "name": "TransactionByProfileUser", "sql": "select \r\ndistinct\r\ntb_table.id,\r\ntb_table.field->>''id_parent'' as id_parent,\r\ntb_table.field->>''name'' as name,\r\ntb_table.field->>''table_name'' as table_name\r\nfrom tb_table\r\ninner join tb_profile_table on (tb_profile_table.field->>''id_table'')::int = tb_table.id\r\ninner join tb_profile on (tb_profile_table.field->>''id_profile'')::int = tb_profile.id\r\ninner join tb_user_profile on (tb_user_profile.field->>''id_profile'')::int = tb_profile.id\r\nwhere (tb_table.field->>''id_system'')::int = p1\r\nand (tb_user_profile.field->>''id_user'')::int = p1\r\norder by tb_table.field->>''name''"}');