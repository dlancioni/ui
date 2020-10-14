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

        // system id
        $id_system = 1;

        // DB interface
        $db = new Db();       
        $jsonUtil = new JsonUtil();

        // Open connection
        $cn = $db->getConnection();        

        // Create instance
        printl("Starting setup...");

        dropTable($cn);
        createTable($cn);
        createTransaction($cn, $id_system);
        createField($cn, $id_system);
        createDomain($cn, $id_system);
        createEvent($cn, $id_system);
        createFunction($cn, $id_system);
        createGroup($cn, $id_system);
        createUser($cn, $id_system);
        createProfile($cn, $id_system);
        createProfileTable($cn, $id_system);
        createUserProfile($cn, $id_system);
        createTableFunction($cn, $id_system);
        createCode($cn, $id_system);
        createView($cn, $id_system);
        createFieldSetup($cn, $id_system);

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
            pg_query($cn, "drop table if exists tb_field_attribute cascade;");            
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
            pg_query($cn, "create table if not exists tb_field_attribute (id serial, field jsonb);");
            
            printl("createTable() OK");

        } catch (Exception $ex) {
            printl("createTable():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create transactions (menus, tables)
     */
    function createTransaction($cn, $id_system) {

        global $tableName;
        global $total;
        $model = new Model();
        
        try {

            // Define table name
            $tableName = "tb_system";
            execute($cn, $model->addSystem($id_system, "Forms", "31/12/2020", "100.00"));
            
            // Define table name
            $tableName = "tb_table";

            // Transactions
            execute($cn, $model->addTable($id_system, "Sistemas", 1, "tb_system", 17));
            execute($cn, $model->addTable($id_system, "Transações", 1, "tb_table", 17));
            execute($cn, $model->addTable($id_system, "Campos", 1, "tb_field", 17));
            execute($cn, $model->addTable($id_system, "Domínios", 1, "tb_domain", 17));
            execute($cn, $model->addTable($id_system, "Eventos", 1, "tb_event", 17));
            execute($cn, $model->addTable($id_system, "Funções", 1, "tb_function", 17));
            execute($cn, $model->addTable($id_system, "Programação", 1, "tb_code", 17));
            execute($cn, $model->addTable($id_system, "Grupos", 1, "tb_group", 18));
            execute($cn, $model->addTable($id_system, "Visão", 1, "tb_view", 17));
            execute($cn, $model->addTable($id_system, "Visão x Campos", 1, "tb_view_field", 17));
            execute($cn, $model->addTable($id_system, "Perfil", 1, "tb_profile", 18));
            execute($cn, $model->addTable($id_system, "Perfil x Transação", 1, "tb_profile_table", 18));
            execute($cn, $model->addTable($id_system, "Transação x Funcão", 1, "tb_table_function", 18));
            execute($cn, $model->addTable($id_system, "Usuários", 1, "tb_user", 18));
            execute($cn, $model->addTable($id_system, "Usuários x Pefil", 1, "tb_user_profile", 18));
            execute($cn, $model->addTable($id_system, "Atributos de Campos", 1, "tb_field_attribute", 17));

            // Menus
            execute($cn, $model->addTable($id_system, "Administração", 3, "", 0));
            execute($cn, $model->addTable($id_system, "Controle de Acesso", 3, "", 0));
            execute($cn, $model->addTable($id_system, "Cadastros", 3, "", 0));
            
            // Must have total transactions including menus
            $total = 19;

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
    function createField($cn, $id_system) {

        global $tableName;
        $model = new Model();

        try {

            // Datatype
            $int = 1;
            $float = 2;
            $text = 3;
            $date = 4;
            $textarea = 6;

            // Constants
            $yes = 1;
            $no = 2;
            $tableName = "tb_field";

            // tb_system
            execute($cn, $model->addField($id_system, 1, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 1, "Expira em", "expire_date", $date, 0, "dd/mm/yyyy", $yes, $no, 0, 0, ""));
            execute($cn, $model->addField($id_system, 1, "Preço", "price", $float, 0, "1.000,00", $yes, $no, 0, 0, ""));
            
            // tb_table
            execute($cn, $model->addField($id_system, 2, "Sistema", "id_system", $int, 0, "", $yes, $no, 0, 0, ""));
            execute($cn, $model->addField($id_system, 2, "Tipo", "id_type", $int, 0, "", $yes, $no, 4, 20, "tb_table_type"));
            execute($cn, $model->addField($id_system, 2, "Nome", "name", $text, 50, "", $yes, $no, 0, 0, ""));
            execute($cn, $model->addField($id_system, 2, "Tabela", "table_name", $text, 50, "", $no, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 2, "parente", "id_parent", $int, 0, "", $no, $no, 2, 6, ""));

            // tb_field
            execute($cn, $model->addField($id_system, 3, "Tabela", "id_table", $int, 0, "", $yes, $yes, 2, 6, ""));
            execute($cn, $model->addField($id_system, 3, "Rótulo", "label", $text, 50, "", $yes, $no, 0, 0, ""));
            execute($cn, $model->addField($id_system, 3, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 3, "Tipo", "id_type", $int, 0, "", $yes, $no, 4, 20, "tb_field_type"));
            execute($cn, $model->addField($id_system, 3, "Tamanho", "size", $int, 0, "", $yes, $no, 0, 0, ""));
            execute($cn, $model->addField($id_system, 3, "Máscara", "mask", $text, 50, "", $no, $no, 0, 0, ""));
            execute($cn, $model->addField($id_system, 3, "Obrigatório", "id_mandatory", $int, 0, "", $yes, $no, 4, 20, "tb_bool"));
            execute($cn, $model->addField($id_system, 3, "Único", "id_unique", $int, 0, "", $yes, $no, 4, 20, "tb_bool"));
            execute($cn, $model->addField($id_system, 3, "Tabela FK", "id_table_fk", $int, 0, "", $no, $no, 2, 6, ""));
            execute($cn, $model->addField($id_system, 3, "Campo FK", "id_field_fk", $int, 0, "", $no, $no, 3, 10, ""));
            execute($cn, $model->addField($id_system, 3, "Domínio", "domain", $text, 50, "", $no, $no, 0, 0, ""));
            // tb_domain
            execute($cn, $model->addField($id_system, 4, "Chave", "key", $text, 50, "", $yes, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 4, "Valor", "value", $text, 50, "", $yes, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 4, "Domínio", "domain", $text, 50, "", $yes, $yes, 0, 0, ""));
            // tb_event
            execute($cn, $model->addField($id_system, 5, "Tela", "id_target", $int, 0, "", $yes, $yes, 4, 20, "tb_target"));
            execute($cn, $model->addField($id_system, 5, "Tabela", "id_table", $int, 0, "", $yes, $yes, 2, 6, ""));
            execute($cn, $model->addField($id_system, 5, "Campo", "id_field", $int, 0, "", $yes, $yes, 3, 10, ""));
            execute($cn, $model->addField($id_system, 5, "Ação", "id_function", $int, 0, "", $yes, $yes, 6, 29, ""));
            execute($cn, $model->addField($id_system, 5, "Evento", "id_event", $int, 0, "", $yes, $yes, 4, 20, "tb_event"));
            execute($cn, $model->addField($id_system, 5, "Código", "code", $textarea, 10000, "", $yes, $yes, 0, 0, ""));
            // tb_function
            execute($cn, $model->addField($id_system, 6, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
            // tb_code
            execute($cn, $model->addField($id_system, 7, "Comentário", "comment", $text, 50, "", $yes, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 7, "Código", "code", $textarea, 10000, "", $yes, $yes, 0, 0, ""));
            // tb_group
            execute($cn, $model->addField($id_system, 8, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
            // tb_view
            execute($cn, $model->addField($id_system, 9, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 9, "SQL", "sql", $textarea, 10000, "", $yes, $yes, 0, 0, ""));
            // tb_view_field
            execute($cn, $model->addField($id_system, 10, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
            // tb_profile
            execute($cn, $model->addField($id_system, 11, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
            // tb_profile_table
            execute($cn, $model->addField($id_system, 12, "Perfil", "id_profile", $int, 0, "", $yes, $yes, 11, 36, ""));
            execute($cn, $model->addField($id_system, 12, "Transação", "id_table", $int, 0, "", $yes, $yes, 2, 6, ""));
            // tb_table_function
            execute($cn, $model->addField($id_system, 13, "Perfil", "id_profile", $int, 0, "", $yes, $yes, 11, 36, ""));
            execute($cn, $model->addField($id_system, 13, "Transação", "id_table", $int, 0, "", $yes, $yes, 2, 6, ""));
            execute($cn, $model->addField($id_system, 13, "Function", "id_function", $int, 0, "", $yes, $yes, 6, 29, ""));
            // tb_user
            execute($cn, $model->addField($id_system, 14, "Nome", "name", $text, 50, "", $yes, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 14, "Usuário", "username", $text, 50, "", $yes, $yes, 0, 0, ""));
            execute($cn, $model->addField($id_system, 14, "Password", "password", $text, 50, "", $yes, $yes, 0, 0, ""));
            // tb_user_profile
            execute($cn, $model->addField($id_system, 15, "Usuário", "id_user", $int, 0, "", $yes, $yes, 14, 42, ""));
            execute($cn, $model->addField($id_system, 15, "Perfil", "id_profile", $int, 0, "", $yes, $yes, 11, 36, ""));
            // tb_field_attribute
            execute($cn, $model->addField($id_system, 16, "Tabela", "id_table", $int, 0, "", $yes, $yes, 2, 6, ""));
            execute($cn, $model->addField($id_system, 16, "Campo", "id_field", $int, 0, "", $yes, $yes, 3, 10, ""));
            execute($cn, $model->addField($id_system, 16, "Coluna (%)", "column_size", $int, 0, "", $yes, $yes, 3, 10, ""));
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
    function createDomain($cn, $id_system) {

        global $tableName;
        $model = new Model();        

        try {
            
            // Define table name
            $tableName = "tb_domain";

            // tb_table_type
            execute($cn, $model->addDomain($id_system, 1, "Formulário", "tb_table_type"));
            execute($cn, $model->addDomain($id_system, 2, "Relatório", "tb_table_type"));
            execute($cn, $model->addDomain($id_system, 3, "Menu", "tb_table_type"));
            // tb_bool
            execute($cn, $model->addDomain($id_system, 1, "Sim", "tb_bool"));
            execute($cn, $model->addDomain($id_system, 2, "Não", "tb_bool"));
            // tb_field_type
            execute($cn, $model->addDomain($id_system, 1, "Inteiro", "tb_field_type"));
            execute($cn, $model->addDomain($id_system, 2, "Decimal", "tb_field_type"));
            execute($cn, $model->addDomain($id_system, 3, "Texto", "tb_field_type"));
            execute($cn, $model->addDomain($id_system, 4, "Data", "tb_field_type"));
            execute($cn, $model->addDomain($id_system, 5, "Hora", "tb_field_type"));
            execute($cn, $model->addDomain($id_system, 6, "Area", "tb_field_type"));
            execute($cn, $model->addDomain($id_system, 7, "Binário", "tb_field_type"));
            // tb_event
            execute($cn, $model->addDomain($id_system, 1, "onLoad", "tb_event"));
            execute($cn, $model->addDomain($id_system, 2, "onClick", "tb_event"));
            execute($cn, $model->addDomain($id_system, 3, "OnChange", "tb_event"));
            execute($cn, $model->addDomain($id_system, 4, "onFocus", "tb_event"));
            execute($cn, $model->addDomain($id_system, 5, "onBlur", "tb_event"));
            // tb_target
            execute($cn, $model->addDomain($id_system, 1, "Tabela", "tb_target"));
            execute($cn, $model->addDomain($id_system, 2, "Formulário", "tb_target"));
            // tb_message
            execute($cn, $model->addDomain($id_system, "A1", "Campo % é obrigatório", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A2", "Data inválida informada no campo %", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A3", "Numero inválido informada no campo %", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A4", "Os valores para os campos % ja existem na tabela e não podem se repetir", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A5", "Nenhuma mudança identifica no registro, alteração não realizada", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A6", "Registro incluído com sucesso", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A7", "Registro alterado com sucesso", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A8", "Registro excluído com sucesso", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A9", "Campo Tabela FK foi selecionado, entao Campo FK é obrigatório", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A10", "Transação selecionada é do tipo menu, não é permitido adicionar campos", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A11", "Registro pertence ao grupo Sistema, não pode ser modificado ou excluído", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A12", "Não foi possível concluir o upload dos arquivos", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A13", "Transação ainda não possui campos cadastrados", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A14", "Usuário não cadastrado", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A15", "Senha inválida", "tb_message"));
            execute($cn, $model->addDomain($id_system, "A16", "Autenticado com sucesso, seja bem vindo", "tb_message"));
            // tb_cascade
            execute($cn, $model->addDomain($id_system, "tb_field.id_table_fk", "id_field_fk; tb_field; id; label", "tb_cascade"));
            execute($cn, $model->addDomain($id_system, "tb_event.id_table", "id_field; tb_field; id; label", "tb_cascade"));

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
    function createEvent($cn, $id_system) {

        $i = 0;
        global $tableName;
        global $total;
        $jsonUtil = new jsonUtil();
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_event";

            // Create standard events
            for ($i=1; $i<=$total; $i++) {
                execute($cn, $model->addEvent($id_system, 1, $i, 0, 1, 2, "formNew();"));
                execute($cn, $model->addEvent($id_system, 1, $i, 0, 2, 2, "formEdit();"));
                execute($cn, $model->addEvent($id_system, 1, $i, 0, 3, 2, "formDelete();"));
                execute($cn, $model->addEvent($id_system, 2, $i, 0, 4, 2, "confirm();"));
                execute($cn, $model->addEvent($id_system, 1, $i, 0, 5, 2, "formFilter();"));
                execute($cn, $model->addEvent($id_system, 2, $i, 0, 6, 2, "formClear();"));
                execute($cn, $model->addEvent($id_system, 2, $i, 0, 7, 2, "reportBack();"));
            }

            // Custon events
            execute($cn, $model->addEvent($id_system, 2, 1, 3, 0, 3, "this.value = formatValue(this.value);"));
            execute($cn, $model->addEvent($id_system, 2, 2, 5, 0, 3, "this.value = validateTableName(this.value);"));
            execute($cn, $model->addEvent($id_system, 2, 3, 17, 0, 3, "cascade(''id_field_fk'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'');"));
            execute($cn, $model->addEvent($id_system, 2, 5, 24, 0, 3, "cascade(''id_field'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'');"));
            execute($cn, $model->addEvent($id_system, 2, 16, 47, 0, 3, "cascade(''id_field'', ''id_table'', this.value, ''tb_field'', ''id'', ''label'');"));
            execute($cn, $model->addEvent($id_system, 2, 7, 0, 8, 2, "eval(field(''code'').value);"));

            // Success
            printl("createEvent() OK");
            
        } catch (Exception $ex) {
            printl("createEvent():" . $ex->getMessage());
            throw $ex;
        }
    }


    /*
     * Create function
     */
    function createFunction($cn, $id_system) {

        global $tableName;
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_function";

            // Create actions
            execute($cn, $model->addFunctionGroup($id_system, "Novo"));
            execute($cn, $model->addFunctionGroup($id_system, "Editar"));
            execute($cn, $model->addFunctionGroup($id_system, "Apagar"));
            execute($cn, $model->addFunctionGroup($id_system, "Confirmar"));
            execute($cn, $model->addFunctionGroup($id_system, "Filtrar"));
            execute($cn, $model->addFunctionGroup($id_system, "Limpar"));
            execute($cn, $model->addFunctionGroup($id_system, "Voltar"));
            execute($cn, $model->addFunctionGroup($id_system, "Testar"));
            
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
    function createGroup($cn, $id_system) {

        global $tableName;
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_group";

            // Create groups
            execute($cn, $model->addFunctionGroup($id_system, "Sistema"));
            execute($cn, $model->addFunctionGroup($id_system, "Público"));

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
    function createUser($cn, $id_system) {

        global $tableName;
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_user";

            // Create User
            execute($cn, $model->addUser($id_system, "Administrador", "admin", "123"));
            execute($cn, $model->addUser($id_system, "João", "joao", "123"));
            execute($cn, $model->addUser($id_system, "Maria", "maria", "123"));

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
    function createProfile($cn, $id_system) {

        global $tableName;
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_profile";

            // Create Profile
            execute($cn, $model->addProfile($id_system, "Administrador"));
            execute($cn, $model->addProfile($id_system, "Usuário"));

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
    function createUserProfile($cn, $id_system) {

        global $tableName;
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_user_profile";

            // create User Profile
            execute($cn, $model->addUserProfile($id_system, 1, 1));
            execute($cn, $model->addUserProfile($id_system, 2, 2));
            execute($cn, $model->addUserProfile($id_system, 3, 2));

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
    function createProfileTable($cn, $id_system) {

        $i = 0;
        global $tableName;
        global $total;
        $jsonUtil = new jsonUtil();
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_profile_table";

            // Create standard events
            for ($i=1; $i<=$total; $i++) {               
                execute($cn, $model->addProfileTable($id_system, 1, $i));
            }

            // Success
            printl("createProfileTable() OK");
            
        } catch (Exception $ex) {
            printl("createProfileTable():" . $ex->getMessage());
            throw $ex;
        }
    }


    /*
     * Create events
     */
    function createTableFunction($cn, $id_system) {

        $i = 0;
        $j = 0;

        global $tableName;
        global $total;
        $jsonUtil = new jsonUtil();
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_table_function";

            // Create standard permissions
            for ($i=1; $i<=$total; $i++) {
                for ($j=1; $j<=7; $j++) {
                    execute($cn, $model->addTableFunction($id_system, 1, $i, $j));
                }
            }

            // Success
            printl("createTableFunction() OK");
            
        } catch (Exception $ex) {
            printl("createTableFunction():" . $ex->getMessage());
            throw $ex;
        }
    }


    /*
     * Create code
     */
    function createCode($cn, $id_system) {

        global $tableName;
        $model = new Model();
        
        try {

            // Define table name
            $tableName = "tb_code";

            execute($cn, $model->addCode($id_system, "Obtem o valor numérico de um campo", "function valor(campo) {\r\n\r\n    value = field(campo).value;\r\n\r\n    if (value.trim() == \"\") {\r\n        value = \"0\";\r\n    }\r\n\r\n    if (!isNumeric(value)) {\r\n        value = \"0\";\r\n    }\r\n\r\n    value = value.split(\".\").join(\"\");\r\n    value = value.split(\",\").join(\".\");\r\n    value = parseFloat(value);\r\n\r\n    return value;\r\n}"));
            execute($cn, $model->addCode($id_system, "Chamada de pagina customizada", "async function fetchHtmlAsText(url) {\r\n    return await (await fetch(url)).text();\r\n}\r\n\r\nasync function loadExternalPage(url, div) {\r\n    document.getElementById(div).innerHTML = await fetchHtmlAsText(url);\r\n}"));
            execute($cn, $model->addCode($id_system, "Exemplo de query em banco de dados", "function query(campo) {\r\n\r\n    let rs = query(\"select 1*2 as total\");\r\nalert(rs[0].total);\r\n};"));
                        

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
    function createView($cn, $id_system) {

        $json = "";
        global $tableName;
        $jsonUtil = new JsonUtil();
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_view";

            // View to transaction
            execute($cn, $model->addView($id_system, "TransactionByProfileUser", "select distinct tb_table.id, tb_table.field->>''id_parent'' as id_parent, tb_table.field->>''name'' as name, tb_table.field->>''table_name'' as table_name from tb_table inner join tb_profile_table on (tb_profile_table.field->>''id_table'')::int = tb_table.id inner join tb_profile on (tb_profile_table.field->>''id_profile'')::int = tb_profile.id inner join tb_user_profile on (tb_user_profile.field->>''id_profile'')::int = tb_profile.id where (tb_table.field->>''id_system'')::int = p1 and (tb_user_profile.field->>''id_user'')::int = p1 order by tb_table.id"));
            execute($cn, $model->addView($id_system, "FunctionByProfileUser", "select distinct tb_user_profile.field->>''id_profile'' id_profile, tb_function.id, tb_function.field->>''name'' as name from tb_user_profile inner join tb_table_function on (tb_table_function.field->>''id_profile'')::int = (tb_user_profile.field->>''id_profile'')::int inner join tb_function on (tb_table_function.field->>''id_function'')::int = tb_function.id where (tb_table_function.field->>''id_table'')::int = p1 and (tb_user_profile.field->>''id_user'')::int = p2 order by tb_function.id"));

            // Success
            printl("createView() OK");
            
        } catch (Exception $ex) {
            printl("createView():" . $ex->getMessage());
            throw $ex;
        }
    }

    /*
     * Create field setup
     */
    function createFieldSetup($cn, $id_system) {

        global $tableName;
        $model = new Model();

        try {

            // Define table name
            $tableName = "tb_field_attribute";

            // tb_system
            execute($cn, $model->addFieldSetup($id_system, 1, 1, 10));
            execute($cn, $model->addFieldSetup($id_system, 1, 2, 10));
            execute($cn, $model->addFieldSetup($id_system, 1, 3, 75));
            // tb_table
            execute($cn, $model->addFieldSetup($id_system, 2, 1, 5));
            execute($cn, $model->addFieldSetup($id_system, 2, 2, 5));
            execute($cn, $model->addFieldSetup($id_system, 2, 1, 5));
            execute($cn, $model->addFieldSetup($id_system, 2, 2, 5));
            execute($cn, $model->addFieldSetup($id_system, 2, 2, 75));
            // tb_table
            execute($cn, $model->addFieldSetup($id_system, 4, 20, 10));
            execute($cn, $model->addFieldSetup($id_system, 4, 21, 10));
            execute($cn, $model->addFieldSetup($id_system, 4, 22, 75));
            // tb_function
            execute($cn, $model->addFieldSetup($id_system, 6, 29, 95));
            // tb_group
            execute($cn, $model->addFieldSetup($id_system, 8, 32, 95));
            // tb_profile
            execute($cn, $model->addFieldSetup($id_system, 11, 36, 95));
            // tb_profile_transaction
            execute($cn, $model->addFieldSetup($id_system, 12, 37, 10));
            execute($cn, $model->addFieldSetup($id_system, 12, 38, 85));
            // tb_transaction_function
            execute($cn, $model->addFieldSetup($id_system, 13, 39, 10));
            execute($cn, $model->addFieldSetup($id_system, 13, 40, 10));
            execute($cn, $model->addFieldSetup($id_system, 13, 41, 75));
            // tb_user
            execute($cn, $model->addFieldSetup($id_system, 14, 42, 10));
            execute($cn, $model->addFieldSetup($id_system, 14, 43, 10));
            execute($cn, $model->addFieldSetup($id_system, 14, 44, 75));
            // tb_user_profile
            execute($cn, $model->addFieldSetup($id_system, 15, 45, 10));
            execute($cn, $model->addFieldSetup($id_system, 15, 46, 85));            

            // Success
            printl("createFieldSetup() OK");
            
        } catch (Exception $ex) {
            printl("createFieldSetup():" . $ex->getMessage());
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