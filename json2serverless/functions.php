<?php
/*
//  functions.php
//
//  Created by Alezia Kurdis on 10 Apr 2020
//  Copyright 2020 Alezia Kurdis.
//
//  Distributed under the Apache License, Version 2.0.
//  See the accompanying file LICENSE or http://www.apache.org/licenses/LICENSE-2.0.html
*/

function genServerlessData($templateUrl, $jsonUrl, $path) {
    
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
    if ($jsonUrl == "") {
        $jsonData = json_decode('{
                      "DataVersion": 0,
                      "Entities": [],
                      "Id": "{'.get_guid().'}",
                      "Version": 125
                    }');

    } else {
        $jsonData = json_decode(GetJSONData($jsonUrl));
    }
    
    
    //Override Paths
    if ($path != ""){
        $serverless->{"Paths"}->{"/"} = $path;
    }
    
    //add json data to serverless
    foreach ($jsonData->{"Entities"} as $Entity) {
        array_push($serverless->{"Entities"}, $Entity);
    }
    
    
    return json_encode($serverless);
}


function GetJSONData($url) {
    return file_get_contents($url);
}

function get_guid() {
    $data = PHP_MAJOR_VERSION < 7 ? openssl_random_pseudo_bytes(16) : random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // Set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // Set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


?>