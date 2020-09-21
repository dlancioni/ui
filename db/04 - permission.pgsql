-- -----------------------------------------------------
-- TB_ACTION
-- -----------------------------------------------------
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Novo"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Editar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Apagar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Confirmar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Filtrar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Limpar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Voltar"}');
insert into tb_action (field) values ('{"id_system":1,"id_group":1,"name":"Testar"}');

-- -----------------------------------------------------
-- TB_GROUP
-- -----------------------------------------------------
insert into tb_group (field) values ('{"id_system":1,"id_group":1,"name":"Sistema"}');
insert into tb_group (field) values ('{"id_system":1,"id_group":1,"name":"Público"}');

-- ---------------------------------------------------------------------------------
-- TB_USER
-- ---------------------------------------------------------------------------------
insert into tb_user (field) values ('{"id_system":1,"id_group":1,"fullname":"Administrador","login":"admin","password":"123"}');
insert into tb_user (field) values ('{"id_system":1,"id_group":1,"fullname":"João","login":"joao","password":"123"}');
insert into tb_user (field) values ('{"id_system":1,"id_group":1,"fullname":"Maria","login":"maria","password":"123"}');

-- ---------------------------------------------------------------------------------
-- TB_PROFILE
-- ---------------------------------------------------------------------------------
insert into tb_profile (field) values ('{"id_system":1,"id_group":1,"name":"Administrador"}');
insert into tb_profile (field) values ('{"id_system":1,"id_group":1,"name":"Usuário"}');

-- ---------------------------------------------------------------------------------
-- TB_PROFILE_TRANSACTION
-- ---------------------------------------------------------------------------------
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":1}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":2}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":3}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":4}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":5}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":6}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":7}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":8}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":9}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":10}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":11}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":12}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":13}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":14}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":15}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":16}');
insert into tb_profile_table (field) values ('{"id_system":1,"id_group":1,"id_profile":1,"id_table":17}');

-- ---------------------------------------------------------------------------------
-- TB_USER_PROFILE
-- ---------------------------------------------------------------------------------
insert into tb_user_profile (field) values ('{"id_system":1,"id_user":1,"id_profile":1}');
insert into tb_user_profile (field) values ('{"id_system":1,"id_user":2,"id_profile":2}');
insert into tb_user_profile (field) values ('{"id_system":1,"id_user":3,"id_profile":2}');

-- ---------------------------------------------------------------------------------
-- TB_TRANSACTION_FUNCTION
-- ---------------------------------------------------------------------------------
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":1,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":1,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":1,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":1,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":1,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":1,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":1,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":2,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":2,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":2,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":2,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":2,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":2,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":2,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":3,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":3,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":3,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":3,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":3,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":3,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":3,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":4,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":4,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":4,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":4,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":4,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":4,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":4,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":5,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":5,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":5,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":5,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":5,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":5,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":5,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":6,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":6,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":6,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":6,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":6,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":6,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":6,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":8,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":8,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":8,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":8,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":8,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":8,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":8,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":9,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":9,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":9,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":9,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":9,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":9,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":9,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":10,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":10,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":10,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":10,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":10,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":10,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":10,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":11,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":11,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":11,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":11,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":11,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":11,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":11,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":12,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":12,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":12,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":12,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":12,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":12,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":12,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":13,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":13,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":13,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":13,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":13,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":13,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":13,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":14,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":14,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":14,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":14,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":14,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":14,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":14,"id_function":7}');

insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":15,"id_function":1}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":15,"id_function":2}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":15,"id_function":3}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":15,"id_function":4}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":15,"id_function":5}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":15,"id_function":6}');
insert into tb_table_function (field) values ('{"id_system":1,"id_group":1,"id_table":15,"id_function":7}');