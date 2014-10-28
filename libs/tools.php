<?php

////////////////////////////////////////////////////////////////////
define("MS_API_KEY","zmy5fhr433zul4xbyxwg");
define("MS_API_SECRET","V6cqRjDuOX0sfSuT");
define("MS_API_URL","http://api.moodstocks.com/v2");
define("DATA_PATH",__DIR__."/../data");

////////////////////////////////////////////////////////////////////
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/RequestsAuthDigest.php";

////////////////////////////////////////////////////////////////////
function cleanTmpFiles() {
    $files = glob(DATA_PATH."/tmp/*");
    foreach($files as $file)
    { 
        if(is_file($file) && (time()-filemtime($file) > 200)) {
            unlink($file);
        }
    }
}

////////////////////////////////////////////////////////////////////
function getFileNameFromID($refID) {
    return base64_decode($refID);
}

////////////////////////////////////////////////////////////////////
function listReferenceImages() {
    $command = "curl --digest -u ".MS_API_KEY.":".MS_API_SECRET." \"".MS_API_URL."/stats/refs\"";
    return json_decode(exec($command));
}

////////////////////////////////////////////////////////////////////
function addImageFromDataFolder($imageName) {
    $id = rtrim(base64_encode($imageName),"=");
    $command = "curl --digest -u ".MS_API_KEY.":".MS_API_SECRET." \"".MS_API_URL."/ref/".$id."\" --form image_file=@\"".DATA_PATH."/".$imageName."\" -X PUT";
    return json_decode(exec($command));
}

////////////////////////////////////////////////////////////////////
function deleteImage($imageID) {
    $command = "curl --digest -u ".MS_API_KEY.":".MS_API_SECRET." \"".MS_API_URL."/ref/".$imageID."\" -X DELETE";
    return json_decode(exec($command));
}

////////////////////////////////////////////////////////////////////
function searchImage($imagePath) {
    $command = "curl --digest -u ".MS_API_KEY.":".MS_API_SECRET." \"".MS_API_URL."/search\" --form image_file=@\"".$imagePath."\"";
    return json_decode(exec($command));
}

?>