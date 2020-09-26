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
     * Drop and create tables
     */
    function createTransaction($cn) {

        $sql = "";

        try {

            // Create sysstem
            pg_query($cn, "insert into tb_system (field) values ('{"name":"Forms","expire_date":"31/12/2020","price":"100.00"}')");



            printl("createTransaction() OK");
            
        } catch (Exception $ex) {
            printl("createTransaction():" . $ex->getMessage());
            throw $ex;
        }
    }



    function printl($msg) {
        echo $msg . "<br>";
    }

?>