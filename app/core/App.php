<?php

/**
 * Description of App
 *
 * @author Twist
 */
require_once 'Controller.php';

class App {

    protected $controller;
    protected $method;
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();
        $url[0] = ucfirst($url[0]);
        if (file_exists('../app/controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = $url[0] . 'Controller';
            unset($url[0]);
        } else {
            exit(1);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        } else {
            exit(1);
        }
        call_user_func([$this->controller, $this->method]);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL));
        }
    }

    public function makeRequest() {
        $methodName = "FahrenheitToCelsius";
        $propertyName = "Fahrenheit";
        $val = "98.6";
        $nameSpace = "http://www.w3schools.com/xml/";
        $enevelop = '<?xml version="1.0" encoding="utf-8"?>
                            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                              <soap:Body>
                                <GetItemPrice xmlns="http://connecting.website.com/WSDL_Service"> 
                                  <PRICE>' . '</PRICE>  
                                </GetItemPrice >
                              </soap:Body>
                            </soap:Envelope>';
        echo $enevelop;
        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: http://www.w3schools.com/xml/FahrenheitToCelsius",
            "Content-length: " . strlen($enevelop),
        ); //SOAPAction: your op URL

        $con = curl_init();
        curl_setopt($con, CURLOPT_URL, "http://www.w3schools.com/xml/tempconvert.asmx");
        curl_setopt($con, CURLOPT_HEADER, $headers);
        curl_setopt($con, CURLOPT_POST, true);
        curl_setopt($con, CURLOPT_POSTFIELDS, $enevelop);
        $response = curl_exec($con);
        //echo $response;
    }

}
