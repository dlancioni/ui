<?php

    // Include classes
    include "include.php";

    // General declaration
    $db = "";
    $cn = "";
    $rs = "[]";
    $sql = "";
    $json = "";
    $jsonUtil = "";
    $tableName = "tb_system";
    $total = 0;
    
    // Core code
    try {

        // DB interface
        $db = new Db();       
        $jsonUtil = new JsonUtil();

        // Open connection
        $cn = $db->getConnection();        

        // Create instance
        printl("Starting setup...");

        dropTable($cn);
        createTable($cn);
        createTransaction($cn);
        createField($cn);
        createDomain($cn);
        createEvent($cn);
        createFunction($cn);
        createGroup($cn);
        createUser($cn);
        createProfile($cn);
        createProfileTransaction($cn);
        createUserProfile($cn);
        createTransactionFunction($cn);
        createCode($cn);
        createView($cn);

        // Finished OK
        printl("Success :)");

    } catch (Exception $ex) {        

        // Setup fail
        printl("Fail :/" . $ex->getMessage());

    } finally {

        // Close connection
        if ($cn) {
            pg_close($cn); 
        }
    }

    /*
     * Drop and create tables
     */
    function dropTable($cn) {

        try {

            // Drop table
            pg_query($cn, "drop table if exists tb_system cascade;");
            pg_query($cn, "drop table if exists tb_table cascade;");
            pg_query($cn, "drop table if exists tb_field cascade;");
            pg_query($cn, "drop table if exists tb_domain cascade;");
            pg_query($cn, "drop table if exists tb_event cascade;");
            pg_query($cn, "drop table if exists tb_function cascade;");
            pg_query($cn, "drop table if exists tb_code cascade;");
            pg_query($cn, "drop table if exists tb_group cascade;");
            pg_query($cn, "drop table if exists tb_view cascade;");
            pg_query($cn, "drop table if exists tb_view_field cascade;");
            pg_query($cn, "drop table if exists tb_profile cascade;");
            pg_query($cn, "drop table if exists tb_profile_table cascade;");
            pg_query($cn, "drop table if exists tb_table_function cascade;");
            pg_query($cn, "drop table if exists tb_user cascade;");
            pg_query($cn, "drop table if exists tb_user_profile cascade;");
            printl("dropTable() OK");

        } catch (Exception $ex) {
            printl("dropTable():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create tables
     */
    function createTable($cn) {

        try {
            pg_query($cn, "create table if not exists tb_system (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_table (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_field (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_domain (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_event (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_function (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_code (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_group (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_view (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_view_field (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_profile (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_profile_table (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_table_function (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_user (id serial, field jsonb);");
            pg_query($cn, "create table if not exists tb_user_profile (id serial, field jsonb);");
            printl("createTable() OK");

        } catch (Exception $ex) {
            printl("createTable():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create transactions (menus, tables)
     */
    function createTransaction($cn) {

        global $tableName;
        global $total;

        try {

            // Define table name
            $tableName = "tb_system";
            execute($cn, '{"id_system":1,"id_group":1,"name":"Forms","expire_date":"31/12/2020","price":"100.00"}');

            // Define table name
            $tableName = "tb_table";
            execute($cn, '{"id_system":1,"id_group":1,"name":"Sistemas","id_type":1,"table_name":"tb_system","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Transações","id_type":1,"table_name":"tb_table","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Campos","id_type":1,"table_name":"tb_field","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Domínios","id_type":1,"table_name":"tb_domain","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Eventos","id_type":1,"table_name":"tb_event","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Funções","id_type":1,"table_name":"tb_function","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Programação","id_type":1,"table_name":"tb_code","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Grupos","id_type":1,"table_name":"tb_group","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Visão","id_type":1,"table_name":"tb_view","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Visão x Campos","id_type":1,"table_name":"tb_view_field","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Perfil","id_type":1,"table_name":"tb_profile","id_parent":17}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Perfil x Transação","id_type":1,"table_name":"tb_profile_table","id_parent":17}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Transação x Function","id_type":1,"table_name":"tb_table_function","id_parent":17}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Usuários","id_type":1,"table_name":"tb_user","id_parent":17}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Usuários x Perfil","id_type":1,"table_name":"tb_user_profile","id_parent":17}');
            $total = 17;
            
            // Create menus
            execute($cn, '{"id_system":1,"id_group":1,"name":"Administração","id_type":3,"table_name":"","id_parent":0}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Controle de Acesso","id_type":3,"table_name":"","id_parent":0}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Cadastros","id_type":3,"table_name":"","id_parent":0}');

            // Success
            printl("createTransaction() OK");
            
        } catch (Exception $ex) {
            printl("createTransaction():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create fields
     */
    function createField($cn) {

        global $tableName;

        try {

            // Define table name
            $tableName = "tb_field";

            // tb_system
            execute($cn, '{"id_system":1,"id_group":1,"id_table":1,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":1,"label":"Expira em","name":"expire_date","id_type":4,"size":0,"mask":"dd/mm/yyyy","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":1,"label":"Preço","name":"price","id_type":2,"size":0,"mask":"1.000,00","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_table
            execute($cn, '{"id_system":1,"id_group":1,"id_table":2,"label":"Sistema","name":"id_system","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":1,"id_field_fk":1,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":2,"label":"Tipo","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_table_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":2,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":2,"label":"Tabela","name":"table_name","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":2,"label":"Parente","name":"id_parent","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":2,"id_field_fk":6,"domain":""}');
            // tb_field
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Tabela","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":6,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Rótulo","name":"label","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Tipo","name":"id_type","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_field_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Tamanho","name":"size","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Máscara","name":"mask","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Obrigatório","name":"id_mandatory","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Único","name":"id_unique","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":4,"id_field_fk":20,"domain":"tb_bool"}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Tabela Fk","name":"id_table_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":2,"id_field_fk":6,"domain":""}'); // tb_transaction.name
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Campo Fk","name":"id_field_fk","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":3,"id_field_fk":10,"domain":""}'); // tb_field.label
            execute($cn, '{"id_system":1,"id_group":1,"id_table":3,"label":"Domínio","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":2,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_domain
            execute($cn, '{"id_system":1,"id_group":1,"id_table":4,"label":"Chave","name":"key","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":4,"label":"Valor","name":"value","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":4,"label":"Domínio","name":"domain","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_event
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Tela","name":"id_target","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":4,"id_field_fk":20,"domain":"tb_target"}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Tabela","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":6,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Campo","name":"id_field","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":3,"id_field_fk":10,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Ação","name":"id_function","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":6,"id_field_fk":29,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Evento","name":"id_event","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":4,"id_field_fk":20,"domain":"tb_event"}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Código","name":"code","id_type":6,"size":10000,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_function
            execute($cn, '{"id_system":1,"id_group":1,"id_table":6,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_code
            execute($cn, '{"id_system":1,"id_group":1,"id_table":7,"label":"Comentário","name":"comment","id_type":3,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":7,"label":"Código","name":"code","id_type":6,"size":500,"mask":"","id_mandatory":1,"id_unique":2,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_group
            execute($cn, '{"id_system":1,"id_group":1,"id_table":8,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_view
            execute($cn, '{"id_system":1,"id_group":1,"id_table":9,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":9,"label":"SQL","name":"sql","id_type":6,"size":5000,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_view_field
            execute($cn, '{"id_system":1,"id_group":1,"id_table":10,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_profile
            execute($cn, '{"id_system":1,"id_group":1,"id_table":11,"label":"Nome","name":"name","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_profile_table
            execute($cn, '{"id_system":1,"id_group":1,"id_table":12,"label":"Perfil","name":"id_profile","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":11,"id_field_fk":36,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":12,"label":"Transação","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":6,"domain":""}');
            // tb_table_function
            execute($cn, '{"id_system":1,"id_group":1,"id_table":13,"label":"Perfil","name":"id_profile","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":11,"id_field_fk":36,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":13,"label":"Transação","name":"id_table","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":2,"id_field_fk":6,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":13,"label":"Função","name":"id_function","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":6,"id_field_fk":29,"domain":""}');
            // tb_user
            execute($cn, '{"id_system":1,"id_group":1,"id_table":14,"label":"Nome","name":"fullname","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":14,"label":"Login","name":"login","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":14,"label":"Senha","name":"password","id_type":3,"size":50,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_user_profile
            execute($cn, '{"id_system":1,"id_group":1,"id_table":15,"label":"Usuários","name":"id_user","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":14,"id_field_fk":42,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":15,"label":"Perfil","name":"id_profile","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":11,"id_field_fk":36,"domain":""}');            

            // Success
            printl("createField() OK");
            
        } catch (Exception $ex) {
            printl("createField():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create domain
     */
    function createDomain($cn) {

        global $tableName;

        try {
            
            // Define table name
            $tableName = "tb_domain";

            // tb_table_type
            execute($cn, '{"id_system":1,"id_group":1,"key":"1","value":"Formulário","domain":"tb_table_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"2","value":"Relatório","domain":"tb_table_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"3","value":"Menu","domain":"tb_table_type"}');
            // tb_bool
            execute($cn, '{"id_system":1,"id_group":1,"key":"1","value":"Sim","domain":"tb_bool"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"2","value":"Não","domain":"tb_bool"}');
            // tb_field_type
            execute($cn, '{"id_system":1,"id_group":1,"key":1,"value":"Inteiro","domain":"tb_field_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":2,"value":"Decimal","domain":"tb_field_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":3,"value":"Texto","domain":"tb_field_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":4,"value":"Data","domain":"tb_field_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":5,"value":"Hora","domain":"tb_field_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":6,"value":"Area","domain":"tb_field_type"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":7,"value":"Binário","domain":"tb_field_type"}');
            // tb_event
            execute($cn, '{"id_system":1,"id_group":1,"key":1,"value":"onLoad","domain":"tb_event"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":2,"value":"onClick","domain":"tb_event"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":3,"value":"onChange","domain":"tb_event"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":4,"value":"onFocus","domain":"tb_event"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":5,"value":"onBlur","domain":"tb_event"}');
            // tb_target
            execute($cn, '{"id_system":1,"id_group":1,"key":1,"value":"Tabela","domain":"tb_target"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":2,"value":"Formulário","domain":"tb_target"}');
            // tb_message
            execute($cn, '{"id_system":1,"id_group":1,"key":"A1","value":"Campo % é obrigatório","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A2","value":"Data inválida informada no campo %","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A3","value":"Numero inválido informada no campo %","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A4","value":"Os valores para os campos % ja existem na tabela e não podem se repetir","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A5","value":"Nenhuma mudança identifica no registro, alteração não realizada","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A6","value":"Registro incluído com sucesso","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A7","value":"Registro alterado com sucesso","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A8","value":"Registro excluído com sucesso","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A9","value":"Campo Tabela FK foi selecionado, entao Campo FK é obrigatório","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A10","value":"Transação selecionada é do tipo menu, não é permitido adicionar campos","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A11","value":"Registro pertence ao grupo Sistema, não pode ser modificado ou excluído","domain":"tb_message"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"A12","value":"Não foi possível concluir o upload dos arquivos","domain":"tb_message"}');
            // tb_cascade
            execute($cn, '{"id_system":1,"id_group":1,"key":"tb_field.id_table_fk","value":"id_field_fk; tb_field; id; label","domain":"tb_cascade"}');
            execute($cn, '{"id_system":1,"id_group":1,"key":"tb_event.id_table","value":"id_field; tb_field; id; label","domain":"tb_cascade"}');            

            // Success
            printl("createDomain() OK");
            
        } catch (Exception $ex) {
            printl("createDomain():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create events
     */
    function createEvent($cn) {

        $i = 0;
        $v1 = "";
        $v2 = "";
        $v3 = "";
        $v4 = "";
        $v5 = "";
        $v6 = "";
        $v6 = "";
        global $tableName;
        global $total;
        $jsonUtil = new jsonUtil();

        try {

            // Define table name
            $tableName = "tb_event";

            // Create standard events
            for ($i=1; $i<=$total; $i++) {
                
                $v1 = '{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_function":1,"id_event":2,"code":"formNew();"}';
                $v1 = $jsonUtil->setValue($v1, "id_table", $i);
                execute($cn, $v1);

                $v2 = '{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_function":2,"id_event":2,"code":"formEdit()"}';
                $v2 = $jsonUtil->setValue($v2, "id_table", $i);
                execute($cn, $v2);

                $v3 = '{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_function":3,"id_event":2,"code":"formDelete()"}';
                $v3 = $jsonUtil->setValue($v3, "id_table", $i);
                execute($cn, $v3);

                $v4 = '{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_function":4,"id_event":2,"code":"confirm()"}';
                $v4 = $jsonUtil->setValue($v4, "id_table", $i);
                execute($cn, $v4);

                $v5 = '{"id_system":1,"id_group":1,"id_target":1,"id_table":1,"id_field":0,"id_function":5,"id_event":2,"code":"formFilter()"}';
                $v5 = $jsonUtil->setValue($v5, "id_table", $i);
                execute($cn, $v5);

                $v6 = '{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_function":6,"id_event":2,"code":"formClear()"}';
                $v6 = $jsonUtil->setValue($v6, "id_table", $i);
                execute($cn, $v6);

                $v7 = '{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":0,"id_function":7,"id_event":2,"code":"reportBack()"}';
                $v7 = $jsonUtil->setValue($v7, "id_table", $i);
                execute($cn, $v7);
            }

            // Custon events
            $v1 = '{"id_system":1,"id_group":1,"id_target":2,"id_table":1,"id_field":3,"id_function":0,"id_event":3,"code":"this.value = formatValue(this.value)"}';
            execute($cn, $v1);
            $v1 = '{"id_system":1,"id_group":1,"id_target":2,"id_table":2,"id_field":5,"label":"","id_event":3,"code":"this.value = validateTableName(this.value)"}';
            execute($cn, $v1);
            $v1 = '{"id_system":1,"id_group":1,"id_target":2,"id_table":3,"id_field":17,"id_function":0,"id_event":3,"code":""}';
            $v1 = $jsonUtil->setValue($v1, "code", "cascade(''id_field_fk'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'');");
            execute($cn, $v1);
            $v1 = '{"id_system":1,"id_group":1,"id_target":2,"id_table":5,"id_field":24,"id_function":0,"id_event":3,"code":""}';
            $v1 = $jsonUtil->setValue($v1, "code", "cascade(''id_field'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'');");
            execute($cn, $v1);
            $v1 = '{"id_system":1,"id_group":1,"id_target":2,"id_table":7,"id_field":0,"id_function":8,"id_event":2,"code":""}';
            $v1 = $jsonUtil->setValue($v1, "code", "eval(field(''code'').value);");
            execute($cn, $v1);

            // Success
            printl("createEvent() OK");
            
        } catch (Exception $ex) {
            printl("createEvent():" . $ex->getMessage());
            throw $ex;
        }
    }


    /*
     * Create action
     */
    function createFunction($cn) {

        global $tableName;

        try {

            // Define table name
            $tableName = "tb_function";

            // Create actions
            execute($cn, '{"id_system":1,"id_group":1,"name":"Novo"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Editar"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Apagar"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Confirmar"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Filtrar"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Limpar"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Voltar"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Testar"}');

            // Success
            printl("createFunction() OK");
            
        } catch (Exception $ex) {
            printl("createFunction():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create group
     */
    function createGroup($cn) {

        global $tableName;

        try {

            // Define table name
            $tableName = "tb_group";

            // Create groups
            execute($cn, '{"id_system":1,"id_group":1,"name":"Sistema"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Público"}');

            // Success
            printl("createGroup() OK");
            
        } catch (Exception $ex) {
            printl("createGroup():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create User
     */
    function createUser($cn) {

        global $tableName;

        try {

            // Define table name
            $tableName = "tb_user";

            // Create User
            execute($cn, '{"id_system":1,"id_group":1,"fullname":"Administrador","login":"admin","password":"123"}');
            execute($cn, '{"id_system":1,"id_group":1,"fullname":"João","login":"joao","password":"123"}');
            execute($cn, '{"id_system":1,"id_group":1,"fullname":"Maria","login":"maria","password":"123"}');

            // Success
            printl("createUser() OK");
            
        } catch (Exception $ex) {
            printl("createUser():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create Profile
     */
    function createProfile($cn) {

        global $tableName;

        try {

            // Define table name
            $tableName = "tb_profile";

            // Create Profile
            execute($cn, '{"id_system":1,"id_group":1,"name":"Administrador"}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Usuário"}');

            // Success
            printl("createProfile() OK");
            
        } catch (Exception $ex) {
            printl("createProfile():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create User x Profile
     */
    function createUserProfile($cn) {

        global $tableName;

        try {

            // Define table name
            $tableName = "tb_user_profile";

            // create User Profile
            execute($cn, '{"id_system":1,"id_user":1,"id_profile":1}');
            execute($cn, '{"id_system":1,"id_user":2,"id_profile":2}');
            execute($cn, '{"id_system":1,"id_user":3,"id_profile":2}');            

            // Success
            printl("createUserProfile() OK");
            
        } catch (Exception $ex) {
            printl("createUserProfile():" . $ex->getMessage());
            throw $ex;
        }
    }


    /*
     * Create Profile x Transaction
     */
    function createProfileTransaction($cn) {

        $i = 0;
        $v1 = "";
        global $tableName;
        global $total;
        $jsonUtil = new jsonUtil();

        try {

            // Define table name
            $tableName = "tb_profile_table";

            // Create standard events
            for ($i=1; $i<=$total; $i++) {               
                $v1 = '{"id_system":1,"id_group":1,"id_profile":1,"id_table":1}';
                $v1 = $jsonUtil->setValue($v1, "id_table", $i);
                execute($cn, $v1);
            }

            // Success
            printl("createProfileTransaction() OK");
            
        } catch (Exception $ex) {
            printl("createProfileTransaction():" . $ex->getMessage());
            throw $ex;
        }
    }


    /*
     * Create events
     */
    function createTransactionFunction($cn) {

        $i = 0;
        $j = 0;
        $v1 = "";

        global $tableName;
        global $total;
        $jsonUtil = new jsonUtil();

        try {

            // Define table name
            $tableName = "tb_table_function";

            // Create standard permissions
            for ($i=1; $i<=$total; $i++) {
          
                // Set table id
                $v1 = '{"id_system":1,"id_group":1,"id_profile":1,"id_table":1,"id_function":1}';
                $v1 = $jsonUtil->setValue($v1, "id_table", $i);

                // Create each permission
                for ($j=1; $j<=7; $j++) {
                    $v1 = $jsonUtil->setValue($v1, "id_function", $j);
                    execute($cn, $v1);                    
                }
            }

            // Success
            printl("createTransactionFunction() OK");
            
        } catch (Exception $ex) {
            printl("createTransactionFunction():" . $ex->getMessage());
            throw $ex;
        }
    }


    /*
     * Create code
     */
    function createCode($cn) {

        global $tableName;

        try {

            // Define table name
            $tableName = "tb_code";

            // Create groups
            execute($cn, '{"id_system": 1, "id_group": 1, "comment": "Obtem o valor numérico de um campo", "id": 1, "code": "function valor(campo) {\r\n\r\n    value = field(campo).value;\r\n\r\n    if (value.trim() == \"\") {\r\n        value = \"0\";\r\n    }\r\n\r\n    if (!isNumeric(value)) {\r\n        value = \"0\";\r\n    }\r\n\r\n    value = value.split(\".\").join(\"\");\r\n    value = value.split(\",\").join(\".\");\r\n    value = parseFloat(value);\r\n\r\n    return value;\r\n}"}');
            //execute($cn, '{"id_system": 1, "id_group": 1, "comment": "Exemplo de query em banco de dados", "id": 2, "code": "let rs = query(\"select 1*2 as total\");\r\nalert(rs[0].total);"}');

            // Success
            printl("createCode() OK");
            
        } catch (Exception $ex) {
            printl("createCode():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create view
     */
    function createView($cn) {

        $json = "";
        global $tableName;
        $jsonUtil = new JsonUtil();

        try {

            // Define table name
            $tableName = "tb_view";

            // View to transaction
            $json = '{"id_system": 1, "id_group": 2, "name": "TransactionByProfileUser", "sql": ""}';            
            $json = $jsonUtil->setValue($json, "sql", "select distinct tb_table.id, tb_table.field->>''id_parent'' as id_parent, tb_table.field->>''name'' as name, tb_table.field->>''table_name'' as table_name from tb_table inner join tb_profile_table on (tb_profile_table.field->>''id_table'')::int = tb_table.id inner join tb_profile on (tb_profile_table.field->>''id_profile'')::int = tb_profile.id inner join tb_user_profile on (tb_user_profile.field->>''id_profile'')::int = tb_profile.id where (tb_table.field->>''id_system'')::int = p1 and (tb_user_profile.field->>''id_user'')::int = p1 order by tb_table.id");
            execute($cn, $json);

            // View to function
            $json = '{"id_system": 1, "id_group": 2, "name": "FunctionByProfileUser", "sql": ""}';            
            $json = $jsonUtil->setValue($json, "sql", "select distinct tb_user_profile.field->>''id_profile'' id_profile, tb_function.id, tb_function.field->>''name'' as name from tb_user_profile inner join tb_table_function on (tb_table_function.field->>''id_profile'')::int = (tb_user_profile.field->>''id_profile'')::int inner join tb_function on (tb_table_function.field->>''id_function'')::int = tb_function.id where (tb_table_function.field->>''id_table'')::int = p1 and (tb_user_profile.field->>''id_user'')::int = p2 order by tb_function.id");
            execute($cn, $json);            

            // Success
            printl("createView() OK");
            
        } catch (Exception $ex) {
            printl("createView():" . $ex->getMessage());
            throw $ex;
        }
    }    











    function execute($cn, $json) {

        global $tableName;

        try {
            pg_query($cn, "insert into " . $tableName . " (field) values ('" . $json . "')");
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function printl($msg) {
        echo $msg . "<br>";
    }

?>