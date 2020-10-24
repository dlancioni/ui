<?php
                try {
		    $cn = pg_connect("postgres://form1db:d4a1v21i@form1db.postgresql.dbaas.com.br/form1db");
		    echo "conectado";
	
                } catch (PDOException  $e) {
                   print $e->getMessage();
                }
?>