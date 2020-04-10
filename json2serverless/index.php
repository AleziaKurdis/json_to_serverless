<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- 
        //  index.php
        //
        //  Created by Alezia Kurdis on 10 Apr 2020
        //  Copyright 2020 Project Athena contributors.
        //
        //  Distributed under the Apache License, Version 2.0.
        //  See the accompanying file LICENSE or http://www.apache.org/licenses/LICENSE-2.0.html
        -->
        <title>JSON to Serverless Domain Generator</title>
        <link rel="stylesheet" href="generator.css?version=<?php echo(time()); ?>"/>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
        <script>
            function genLink() {
                var href = window.location.href;
                var dir = href.substring(0, href.lastIndexOf('/')) + "/";
                var url = dir + "serverless.php?templateUrl=" + escape(document.generator.templateUrl.value) + "&jsonUrl=" + escape(document.generator.jsonUrl.value) + "&path=" + escape(document.generator.path.value);
                
                var linkContent = "<font class='urlinstructions'><a class='serverlink' href='#' onclick='copyToClipboard(" + '"' + url + '"' + ");'>Copy this url</a> to join directly the serverless domain:<br><font class='urlcopy'>";            
                linkContent += "<br><div class='urlbox'>" + url + "</div>";
                linkContent += "</font><br></font><a download='serverless.json' class='serverlink' href='"  + url + "'>Download as .json file</a>";
                
                document.getElementById("ServerlessLink").innerHTML = linkContent;       
            }

			function copyToClipboard(string) {
				var $temp = $("<input>");
				$("body").append($temp);
				$temp.val(string).select();
				document.execCommand("copy");
				$temp.remove();
			}
            
        </script>
    </head>    
    <body>
        <div class='header'><img src='vircadia-logo-tm.png' style='width:300px;'></div>
        
        <table><tr><td><!-- MAIN FRAME-->
        <div style='width:100%; text-align: center;'><h1>"Entities JSON" to "Serverless Domain" Generator</h1></div><br>
        <form name='generator' method='post' action='genserverless.php'>
        <table>
            <tr>
                <td style="text-align:left">
                    Serverless Domain Template URL:
                </td> 
                <td style="text-align:right"><select name='prefabTemplates'id='prefabTemplates' onchange='document.generator.templateUrl.value = this.value'>
                        <option value = ''>- Preset Templates -</option>
                        <?php 
                            include("templatemenu.php");
                            echo($templateOptions);
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan = '2'>
                    <input type='text' size = '95' name='templateUrl' id='templateUrl'>
                </td>
            </tr>
        </table>
        <br>
        <table style="width:100%;"><tr><td style="width:15%;">&nbsp;</td><td style="width:85%;">
            Landing Path (Optional): <br>
            <input type='text' size = '80' name='path' id='path'><br>
            <font class='instructions'>If set, this value will override the  landing path from the Serverless Domain Template.<br>
            Must be formated like this: "/x,y,z" or "/x,y,z/x,y,z,w" <i>( /location/rotation )</i>.</font>
        </td></tr></table>    
        <br><br>
    <table style="width:100%;"><tr><td style="width:15%;">&nbsp;</td><td class='SubSection' style="width:85%;">   
        
        <h2>Directly using an online .json file</h2>
        <table>
            <tr>
                <td style="text-align:left">
                    Entities .json file URL:<br><input type='text' size = '80' name='jsonUrl' id='jsonUrl'>
                </td>
            </tr>
            <tr>                
                <td style="text-align:right">
                    <input type = 'button' name='generateOnline' id='generateOnline' value='Generate Link' onclick='genLink();'>
                </td>
            </tr>
            <tr>                
                <td>
                    <div id="ServerlessLink"></div>
                </td>
            </tr>            
        </table><br>
        <br><br><hr>
        <h2>Generated locally from a local .json file</h2>
        <table>
            <tr>
                <td style="text-align:left">
                    Entities JSON file: <br>
        
                    <div id="drop_zone">Drop a .json file here</div>
                    <div id="fileErrorMessage">&nbsp;</div>
                    <input type="text" name='fileName' id='fileName' size = '80'>
                    <input type="hidden" name='fileContent' id='fileContent'>
                </td>
            </tr>
            <tr>                
                <td style="text-align:right">
                    <input type = 'submit' name='generateData' id='generateData' value='Generate and Download Serverless Domain'>
                </td>
            </tr>
        </table>                    
    </td></tr></table> 
        
        </form>
        
        </td></tr></table><!-- END MAIN FRAME-->
        
        <script>
            function handleFileSelect(evt) {
                document.getElementById("fileErrorMessage").innerHTML = "&nbsp;";
                document.generator.fileContent.value = "";
                evt.stopPropagation();
                evt.preventDefault();

                var files = evt.dataTransfer.files; // FileList object.
                var f = files[0];
                
                //Extract file content here
                      // Only process image files.
                if (!f.type.match('application/json')) {
                    document.getElementById("fileErrorMessage").innerHTML = "<font class='error'>Sorry, only a .json files are allowed.</font>";
                    document.generator.fileName.value = "";
                    return;
                } else {
                    
                    var reader = new FileReader();
                    reader.onload = function(){
                        var text = reader.result;
                        document.generator.fileContent.value = text;
                    };
                    reader.readAsText(f);
                    
                    
                    document.generator.fileName.value = f.name;
                }
            }

            function handleDragOver(evt) {
                evt.stopPropagation();
                evt.preventDefault();
                evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
            }



            // Setup the dnd listeners.
            var dropZone = document.getElementById('drop_zone');
            dropZone.addEventListener('dragover', handleDragOver, false);
            dropZone.addEventListener('drop', handleFileSelect, false);        
        </script>
    </body>
</html>