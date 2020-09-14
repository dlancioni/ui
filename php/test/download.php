<html>
<head>    
<title>UI</title>
</head>    
<body>

<?php 


  // Connect to the database
  $dbconn = pg_connect("postgres://qqbzxiqr:EmiJvVhFJGxDEKJoV6yK9A6o2G5pkmR9@tuffi.db.elephantsql.com:5432/qqbzxiqr");               
  
  // Read in a binary file
  $data = file_get_contents( '../file/doc.pdf' );
 
  // Escape the binary data
  $escaped = bin2hex( $data );
 
  // Insert it into the database
  pg_query( "INSERT INTO gallery (name, data) VALUES ('Pine trees', decode('{$escaped}' , 'hex'))" );

  // Get the bytea data
  $res = pg_query("SELECT encode(data, 'base64') AS data FROM gallery WHERE name='Pine trees'"); 
  $raw = pg_fetch_result($res, 'data');
 
  file_put_contents('../file/doc1.pdf', base64_decode($raw));



  
  echo '<a href="../file/doc1.pdf">Baixar</a>';


  ?>




</body>
</html>
        
        