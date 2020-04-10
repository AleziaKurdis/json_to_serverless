<?php
/*
//  genserverless.php
//
//  Created by Alezia Kurdis on 10 Apr 2020
//  Copyright 2020 Project Athena contributors.
//
//  Distributed under the Apache License, Version 2.0.
//  See the accompanying file LICENSE or http://www.apache.org/licenses/LICENSE-2.0.html
*/

include("functions.php");

if ((isset($_POST["templateUrl"])) && (!empty($_POST["templateUrl"]))){
    $templateUrl = $_POST["templateUrl"];
}else{
    $templateUrl = "";
}
 
if ((isset($_POST["fileContent"])) && (!empty($_POST["fileContent"]))){
    $jsonFileContent = $_POST["fileContent"];
}else{
    $jsonFileContent = "";
}
 
if ((isset($_POST["path"])) && (!empty($_POST["path"]))){
    $path = $_POST["path"];
}else{
    $path = "";
}
 
header('Content-type: application/json');
header('Content-Disposition: attachment; filename="serverless.json"');


//Load Template
if ($templateUrl == "") {
    $serverless = json_decode(' {
                        "DataVersion": 3,
                        "Paths": {
                            "/": "/1,1,1/0,1,0,-0.1"
                        },
                        "Entities": [],
                        "Id": "{'.get_guid().'}",
                        "Version": 120
                    }');
} else {
    $serverless = json_decode(GetJSONData($templateUrl));
}


//Load json data
if ($jsonFileContent == "") {
    $jsonData = json_decode('{
                  "DataVersion": 0,
                  "Entities": [],
                  "Id": "{'.get_guid().'}",
                  "Version": 125
                }');

} else {
    $jsonData = json_decode($jsonFileContent);
}




//Override Paths
if ($path != ""){
    $serverless->{"Paths"}->{"/"} = $path;
}

//add json data to serverless
foreach ($jsonData->{"Entities"} as $Entity) {
    array_push($serverless->{"Entities"}, $Entity);
}

//|||||||||| TROUVER UNE FACON D'AFFICHER UN LIEN QUI DOWNLOAD LE FILE !!!!!!!
echo (json_encode($serverless));

?>