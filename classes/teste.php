<?php

	  // Create (connect to) SQLite database in file
        $conexao = new PDO('sqlite:db.sqlite');
        // Set errormode to exceptions
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        var_dump($conexao);
 
	    

?>