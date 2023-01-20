<?php

/*
//  serverless.php
//
//  Created by Alezia Kurdis on 10 Apr 2020
//  Copyright 2020 Alezia Kurdis.
//
//  Distributed under the Apache License, Version 2.0.
//  See the accompanying file LICENSE or http://www.apache.org/licenses/LICENSE-2.0.html
*/

include("functions.php");

if ((isset($_GET["templateUrl"])) && (!empty($_GET["templateUrl"]))){
    $templateUrl = $_GET["templateUrl"];
}else{
    $templateUrl = "";
}
 
if ((isset($_GET["jsonUrl"])) && (!empty($_GET["jsonUrl"]))){
    $jsonUrl = $_GET["jsonUrl"];
}else{
    $jsonUrl = "";
}
 
if ((isset($_GET["path"])) && (!empty($_GET["path"]))){
    $path = $_GET["path"];
}else{
    $path = "";
}
 
header('Content-type: application/json');

echo(genServerlessData($templateUrl, $jsonUrl, $path));


?>