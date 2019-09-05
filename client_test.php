#!/usr/bin/env php
<?php
$client = new SoapClient("http://localhost:8080/hello/wsdl");

$functions = $client->__getFunctions();
error_log(var_export($functions, true));

$result = $client->greet("world");
error_log(var_export($result, true));
