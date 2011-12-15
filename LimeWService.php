<?php

/**
 *
 */
class LimeWService {
  const debug = true;
  public $client = null;

  public function __construct() {
    ini_set('soap.wsdl_cache', WSDL_CACHE_NONE);
    $options = array(
        'trace' => 1,
        'exceptions' => true,
        'encoding' => 'UTF-8',
        'features' => SOAP_WAIT_ONE_WAY_CALLS,
        'style' => SOAP_DOCUMENT,
        'use' => SOAP_LITERAL,
        'soap_version' => SOAP_1_1,
        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP
    );
    $this->client = new SoapClient('https://limehosting.se:5797/meta', $options);
    print_r($this->client);
  }

  public function tableschema() {
    $client = $this->client;
    $params = array(
        'table' => 'company'
    );
    try {
      $response = $client->GetTableSchema($params);
    } catch (exception $e) {
      echo "exception tableschema<br>"; // $e->getmessage();
      die($e->getmessage());
    }
    return $response;
  }

  /**
   * Get the databaseschema
   * @return <type>
   */
  public function databaseschema() {
    $params = array();
    try {
      $response = $this->client->GetDatabaseSchema($params);
      $this->saveToFile("lime.log", $this->client->__getLastResponse(), 'INFO');
      $response = $this->client->__getLastResponse();
      $xml = $this->responseToSimpleXML($response);
      return $xml;
    } catch (exception $e) {
      echo "Exception databasschema<br>"; // $e->getmessage();
      die($e->getmessage());
    }

    return $response;
  }

  public function insertIntoOffice() {
    $params = array('query' =>
           '<data>
              <office city="Helsingborg" phone="042-18181818" www="boyhappy.se" address1="Gatan 1" address2="Gatan 2" misc="Tjoho" />
            </data>'
    );
    try {
      if (self::debug) {
        $this->saveToFile("lime.log", print_r($params, true), 'DEBUG');
      }
      $response = $this->client->GetXmlQueryData($params);
      $this->saveToFile("lime.log", $this->client->__getLastResponse(), 'INFO');
      $response = $this->client->__getLastResponse();
      $xml = $this->responseToSimpleXML($response);
      return $xml;
    } catch (exception $e) {
      echo "Exception in office()<br>";
      die($e->getmessage());
    }
  }

  /*   old stuff
    function insertcompanypost($client){
    $params = array('query' =>
    '<data>
    <person idperson="-1" company="4379001" name="Karl Pedal2"  />
    </data>'
    );
    try{
    $response  = $client->UpdateData($params);
    }
    catch (exception $e)
    {
    echo "exception<br>";// $e->getmessage();
    die($e->getmessage());
    }
    return $response;
    }
   */

  /**
   * Get office
   * @param <type> $count
   * @return <type>
   */
  public function office($count = 1) {
    /*
      $params = array('query' =>
      ' <query distinct="0"  top="2">
      <tables>
      <table>office</table>
      </tables>
      <fields>
      <field sortorder="asc" sortindex="1">name</field>
      <field>city</field>
      <field>phone</field>
      <field>fax</field>
      <field>www</field>
      <field>address1</field>
      <field>address2</field>
      <field>registrationno</field>
      <field>vatno</field>
      <field>bg</field>
      <field>pg</field>
      <field>misc</field>
      <!-- field>coworker</field>
      <field>marknadsmatriel</field -->
      </fields>
      <conditions>
      </conditions>
      </query> '
      );
     */

    /*
      $params = array('query' =>
      ' <query distinct="0"  top="2">
      <tables>
      <table>GetDatabaseSchema</table>
      </tables>
      <fields>
      </fields>
      <conditions>
      </conditions>
      </query> ' );
     */


    $params = array('query' =>
        '<query distinct="0" top="' . $count . '">
         <tables>
            <table>office</table>
         </tables>
         <fields>
            <field sortorder="asc" sortindex="1">name</field>
            <field>city</field>
            <field>phone</field>
            <field>fax</field>
            <field>www</field>
            <field>address1</field>
            <field>address2</field>
            <field>registrationno</field>
            <field>vatno</field>
            <field>bg</field>
            <field>pg</field>
            <field>misc</field>
            <field>coworker</field>
         </fields>
         <conditions>
        </conditions>
		  </query>');



    /*
      $params = array('query' =>
      ' <query distinct="0"  top="'. $count .'">
      <tables>
      <table>company</table>
      </tables>
      <fields>
      <!-- field>customerno</field -->
      <field sortorder="asc" sortindex="1">name</field>
      </fields>
      <conditions>
      <!--condition operator="LIKE">
      <exp type="field">name</exp>
      <exp type="string">ABB AB</exp>
      </condition-->
      </conditions>
      </query> '
      );
      /*

      /*
      $params = array('query' =>
      ' <query distinct="0">
      <tables>
      <table>company</table>
      </tables>
      <fields>
      <field>idcompany</field>
      <field sortorder="asc" sortindex="1">name</field>
      <field>responsible.name</field>
      <field>city</field>
      <field>category</field>
      </fields>
      <conditions>
      <condition operator="=">
      <exp type="field">city</exp>
      <exp type="string">Lund</exp>
      </condition>
      <condition operator="in" or="0">
      <exp type="field">category</exp>
      <exp type="string">Customer;Prospect</exp>
      </condition>
      </conditions>
      </query>
      '
      );
     */
    try {
      if (self::debug) {
        $this->saveToFile("lime.log", print_r($params, true), 'DEBUG');
      }
      $response = $this->client->GetXmlQueryData($params);
      $this->saveToFile("lime.log", $this->client->__getLastResponse(), 'INFO');
      $response = $this->client->__getLastResponse();
      $xml = $this->responseToSimpleXML($response);
      return $xml;
    } catch (exception $e) {
      echo "Exception in office()<br>";
      die($e->getmessage());
    }
  }

  /**
   * Convert the response to simpleXML object
   * @param <type> $response
   */
  private function responseToSimpleXML($response) {
    $returnXml = '';
    try {
      if (self::debug) {
        $s = 'The response is of type ' . gettype($response);
        $this->saveToFile("lime.log", $s, 'DEBUG');
      }
      libxml_use_internal_errors(true);
      $xml = simplexml_load_string($response);
      $body = trim((string) $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children()->GetXmlQueryDataResponse->GetXmlQueryDataResult);
      //$body = trim((string) $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->children()->GetDatabaseSchemaResponse->GetDatabaseSchemaResult);

      $body = str_replace("UTF-16", "UTF-8", $body);  //fucked! but this must be done!

      $cleanXml = simplexml_load_string($body);
      if (!$cleanXml) {
        $this->saveToFile("lime.log", libxml_get_errors(), 'ERROR');
      }
      $returnXml = $cleanXml;
    } catch (Exception $e) {
      $this->saveToFile("lime.log", 'Exception in responseToSimpleXML() ' . $e->getmessage() . "\n" . $e->getTraceAsString(), 'ERROR');
      die($e->getmessage());
    }
    return $cleanXml;
  }

  /**
   * Appends data to logfile
   * @param <type> $data
   */
  public function saveToFile($filename, $data, $type = 'INFO') {
    $fh = fopen($filename, 'a') or die("can't open file");
    fwrite($fh, "\n" . date('Y-m-d H:m:s') . ' [' . $type . '] ');
    fwrite($fh, $data);
    fclose($fh);
  }

  public function insertcompanypost($client) {
    $params = array(
        'query' =>
        '<data>
      <person idperson="-1" company="4379001" name="Karl Pedal2"  />
		</data>'
    );
    try {
      $response = $client->UpdateData($params);
    } catch (exception $e) {
      echo "exception<br>"; // $e->getmessage();
      die($e->getmessage());
    }
    return $response;
  }

  public function debug() {
    $client = $this->client;
    echo "REQUEST HEADERS:" . $client->__getLastRequestHeaders() . "<br />";
    echo "REQUEST:" . $client->__getLastRequest() . "<br />";
    echo "RESPONSE HEADERS:" . $client->__getLastResponseHeaders() . "<br />";
    echo "RESPONSE :" . $client->__getLastResponse() . "<br />";
  }


}
