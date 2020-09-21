-- -----------------------------------------------------
-- 4 TB_DOMAIN
-- -----------------------------------------------------

-- tb_table_type
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"1","value":"Formulário","domain":"tb_table_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"2","value":"Relatório","domain":"tb_table_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"3","value":"Menu","domain":"tb_table_type"}');
-- tb_bool
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"1","value":"Sim","domain":"tb_bool"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"2","value":"Não","domain":"tb_bool"}');
-- tb_field_type
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":1,"value":"Inteiro","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":2,"value":"Decimal","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":3,"value":"Texto","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":4,"value":"Data","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":5,"value":"Hora","domain":"tb_field_type"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":6,"value":"Area","domain":"tb_field_type"}');
-- tb_event
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":1,"value":"onLoad","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":2,"value":"onClick","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":3,"value":"onChange","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":4,"value":"onFocus","domain":"tb_event"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":5,"value":"onBlur","domain":"tb_event"}');
-- tb_target
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":1,"value":"Tabela","domain":"tb_target"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":2,"value":"Formulário","domain":"tb_target"}');
-- tb_message
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A1","value":"Campo % é obrigatório","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A2","value":"Data inválida informada no campo %","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A3","value":"Numero inválido informada no campo %","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A4","value":"Os valores para os campos % ja existem na tabela e não podem se repetir","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A5","value":"Nenhuma mudança identifica no registro, alteração não realizada","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A6","value":"Registro incluído com sucesso","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A7","value":"Registro alterado com sucesso","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A8","value":"Registro excluído com sucesso","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A9","value":"Campo Tabela FK foi selecionado, entao Campo FK é obrigatório","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A10","value":"Transação selecionada é do tipo menu, não é permitido adicionar campos","domain":"tb_message"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"A11","value":"Registro pertence ao grupo Sistema, não pode ser modificado ou excluído","domain":"tb_message"}');
-- tb_cascade
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"tb_field.id_table_fk","value":"id_field_fk; tb_field; id; label","domain":"tb_cascade"}');
insert into tb_domain (field) values ('{"id_system":1,"id_group":1,"key":"tb_event.id_table","value":"id_field; tb_field; id; label","domain":"tb_cascade"}');