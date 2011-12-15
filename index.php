<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Securitas</title>
  </head>
  <body>
    <h1>Securitas Lime Web Service (obs gör view source)</h1>

    <?php
    include_once 'LimeWService.php';
    $lime = new LimeWService();
    //$response = $lime->databaseschema();
    //$response = $lime->tableschema();
    $response = $lime->office(5);  //funkar
    //$response = $lime->insertIntoOffice();
    var_dump($response);

    ?>
  </body>
</html>
