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
            pg_query($cn, "drop table if exists tb_action cascade;");
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
            pg_query($cn, "create table if not exists tb_action (id serial, field jsonb);");
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

        $json = "";
        global $tableName;

        try {

            // Create sysstem
            $tableName = "tb_system";
            execute($cn, '{"id_system":1,"id_group":1,"name":"Forms","expire_date":"31/12/2020","price":"100.00"}');

            // Create tables
            $tableName = "tb_table";
            execute($cn, '{"id_system":1,"id_group":1,"name":"Sistemas","id_type":1,"table_name":"tb_system","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Transações","id_type":1,"table_name":"tb_table","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Campos","id_type":1,"table_name":"tb_field","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Domínios","id_type":1,"table_name":"tb_domain","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Eventos","id_type":1,"table_name":"tb_event","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Ações","id_type":1,"table_name":"tb_action","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Programação","id_type":1,"table_name":"tb_code","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Grupos","id_type":1,"table_name":"tb_group","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Visão","id_type":1,"table_name":"tb_view","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Visão x Campos","id_type":1,"table_name":"tb_view_field","id_parent":16}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Perfil","id_type":1,"table_name":"tb_profile","id_parent":17}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Perfil x Transação","id_type":1,"table_name":"tb_profile_table","id_parent":17}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Transação x Function","id_type":1,"table_name":"tb_table_function","id_parent":17}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Usuários","id_type":1,"table_name":"tb_user","id_parent":17}');
            execute($cn, '{"id_system":1,"id_group":1,"name":"Usuários x Perfil","id_type":1,"table_name":"tb_user_profile","id_parent":17}');
            
            // Create menus
            $tableName = "tb_table";
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

        $json = "";
        global $tableName;

        try {

            // Create sysstem
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
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Ação","name":"id_action","id_type":1,"size":0,"mask":"","id_mandatory":2,"id_unique":1,"id_table_fk":6,"id_field_fk":29,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Evento","name":"id_event","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":4,"id_field_fk":20,"domain":"tb_event"}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":5,"label":"Código","name":"code","id_type":6,"size":10000,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":0,"id_field_fk":0,"domain":""}');
            // tb_action
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
            execute($cn, '{"id_system":1,"id_group":1,"id_table":15,"label":"Usuários","name":"id_user","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":14,"id_field_fk":41,"domain":""}');
            execute($cn, '{"id_system":1,"id_group":1,"id_table":15,"label":"Perfil","name":"id_profile","id_type":1,"size":0,"mask":"","id_mandatory":1,"id_unique":1,"id_table_fk":11,"id_field_fk":36,"domain":""}');            

            // Success
            printl("createField() OK");
            
        } catch (Exception $ex) {
            printl("createField():" . $ex->getMessage());
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