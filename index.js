<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pitcernia</title>
</head>
<body>
    <h1>Pitcernia</h1>
    <script>
    var mysql = require('mysql');

    var con = mysql.createConnection({
      host: "libsql://g-rams8u.turso.io",
      user: "rams8u",
      password: ""
    });
    
    con.connect(function(err) {
      if (err) throw err;
      console.log("Connected!");
    }); 
    </script>
    <marquee>PITCERNIA</marquee>
</body>
</html>
