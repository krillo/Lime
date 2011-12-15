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
    //$response = $lime->office(5);  //funkar
    $response = $lime->insertIntoOffice();
    var_dump($response);
    //$companys = $xmlx->company;
    //foreach ($companys as $company) {
    //  echo $company->attributes()->idcompany . " " . $company->attributes()->name . "\n";
    //}



    // $response = $lime->insertcompanypost($client);

/*
    echo 'Responsen är av typen ' . gettype($response) . " :\n";
    var_dump($response);
    echo "\n";



    echo "\n\nStädad XML:\n";
    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($response);
    $body = trim((string) $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children()->GetXmlQueryDataResponse->GetXmlQueryDataResult);
    echo $body . PHP_EOL . "\n\n";
    $body = str_replace("UTF-16", "UTF-8", $body);  //fuckat!

    $xmlx = simplexml_load_string($body);
    if (!$xmlx) {
      echo "error <br>";
      var_dump(libxml_get_errors());
      echo "<br><br>";
    }

    var_dump($xmlx);
    echo "\n";
    $companys = $xmlx->company;
    foreach ($companys as $company) {
      echo $company->attributes()->idcompany ." " .  $company->attributes()->name . "\n";
    }
*/

    ?>
  </body>
</html>
