-- ---------------------------------------------------------------------------------
-- 5 TB_EVENT
-- ---------------------------------------------------------------------------------

-- tb_system
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":3,"id_action":0,"id_event":3,"code":"this.value = formatValue(this.value)"}');
-- tb_table
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":2,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":2,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":2,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":2,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":5,"label":"","id_event":3,"code":"this.value = validateTableName(this.value)"}');
-- tb_field
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":3,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":3,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":3,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":3,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":17,"id_action":0,"id_event":3,"code":"cascade(''id_field_fk'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'')"}');
-- tb_domain
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":4,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":4,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":4,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":4,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":4,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":4,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":4,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_event
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":5,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":5,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":5,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":5,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":24,"id_action":0,"id_event":3,"code":"cascade(''id_field'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'')"}');
-- tb_action
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":6,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":6,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":6,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":6,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":6,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":6,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":6,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_code
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":7,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":7,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":7,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":7,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_action":8,"id_event":2,"code":"eval(field(''code'').value);"}');
-- tb_group
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":8,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":8,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":8,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":8,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":8,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":8,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":8,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_view
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":9,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":9,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":9,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":9,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":9,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":9,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":9,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_view_field
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":10,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":10,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":10,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":10,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":10,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":10,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":10,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_profile
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":11,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":11,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":11,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":11,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":11,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":11,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":11,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_profile_table
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":12,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":12,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":12,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":12,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":12,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":12,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":12,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_table_function
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":13,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":13,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":13,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":13,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":13,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":13,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":13,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_user
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":14,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":14,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":14,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":14,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":14,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":14,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":14,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');
-- tb_user_profile
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":15,"id_field":0,"id_action":1,"id_event":2,"code":"formNew();"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":15,"id_field":0,"id_action":2,"id_event":2,"code":"formEdit()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":15,"id_field":0,"id_action":3,"id_event":2,"code":"formDelete()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":15,"id_field":0,"id_action":4,"id_event":2,"code":"confirm()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":1,"id_table":15,"id_field":0,"id_action":5,"id_event":2,"code":"formFilter()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":15,"id_field":0,"id_action":6,"id_event":2,"code":"formClear()"}');
insert into tb_event (field) values ('{"id_system":1,"id_group":1,"id_target":2,"id_table":15,"id_field":0,"id_action":7,"id_event":2,"code":"reportBack()"}');