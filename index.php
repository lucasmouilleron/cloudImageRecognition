<!DOCTYPE html>
<head>

    <title>Cloud image recognition test</title>
    <meta name="description" content="">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/main.css">

</head>
<body>

    <!-- /////////////////////////////////////////////////////////////// -->       
    <div class="container">
        <div class="jumbotron">
            <h1>Cloud image recognition test</h1>
            <p>Using the moodstocks.com cloud service</p>
        </div>
    </div>

    <!-- /////////////////////////////////////////////////////////////// -->       
    <?php require_once __DIR__."/libs/tools.php";

    cleanTmpFiles();

    $error = false;
    $success = false;
    $imageFound = false;
    $imageSearch = false;

    if(@$_GET["action"] == "delete") {
        $refID = $_GET["refID"];
        deleteImage($refID);
        if(@unlink(DATA_REFS_PATH."/".getFileNameFromID($refID))) {
            $success = "File deleted";    
        }
    }

    if(@$_POST["action"] == "add") {
        if($_FILES["jpgFile"]["type"] != "image/jpeg") {
            $error = "Can't send non JPG files";
        }
        else {
            $fileName = uniqid().".jpg";
            copy($_FILES["jpgFile"]["tmp_name"], DATA_REFS_PATH."/".$fileName);
            $result = addImageFromDataFolder($fileName);
            if(!@$result->id) {
                @unlink(DATA_REFS_PATH."/".$fileName);
                $error = "Can't send file : ".var_export($result, true);
            }
            else {
                $success = "File sent";
            }
        }
    }

    if(@$_POST["action"] == "search") {
        if($_FILES["jpgFile"]["type"] != "image/jpeg") {
            $error = "Can't search with non JPG files";
        }
        else {
            $result = searchImage($_FILES["jpgFile"]["tmp_name"]);
            $fileName = uniqid().".jpg";
            copy($_FILES["jpgFile"]["tmp_name"], DATA_TMP_PATH."/".$fileName);
            $searchImage = $fileName;
            if(@$result->found) {
                $success = "Image found";
                $imageFound = $result->id;
            }
            else {
                $error = "Image not found";
            }
        }
    }

    ?>

    <!-- /////////////////////////////////////////////////////////////// -->       
    <?php if($error !== false):?>
        <div class="container"> 
            <div class="alert alert-danger" role="alert"><?php echo $error?></div>
        </div>
    <?php endif;?>
    <?php if($success !== false):?>
        <div class="container"> 
            <div class="alert alert-success" role="alert"><?php echo $success?></div>
            <?php if(@$imageFound || @$searchImage):?>
                <?php if ($imageFound):?>
                    <p>Found reference image <?php echo $imageFound?> : </p>
                    <p><img class="ref-image" src="<?php echo DATA_REFS_URL?>/<?php echo getFileNameFromID($imageFound)?>"/></p>
                <?php else :?>
                    Not found
                <?php endif;?>
                <p>Image used for search : </p>
                <p><img class="ref-image" src="<?php echo DATA_TMP_URL?>/<?php echo $searchImage?>"/></p>
            <?php endif?>
        </div>
    <?php endif;?>

    <!-- /////////////////////////////////////////////////////////////// -->       
    <div class="container"> 
        <h2>Search with an image</h2>
        <p><a href="<?php echo DATA_TEST_URL?>" target="_blank">Test images</a></p>
        <form method="post" class="form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="jpgFile">JPG file</label>
                <input type="file" id="jpgFile" name="jpgFile">
            </div>
            <input type="hidden" name="action" value="search"/>
            <button type="submit" name="add" class="btn btn-primary">Search with this image</button>
        </form>
    </div>

    <!-- /////////////////////////////////////////////////////////////// -->       
    <div class="container"> 
        <h2>Add a reference image</h2>
        <p><a href="<?php echo DATA_TEST_URL?>" target="_blank">Test images</a></p>
        <form method="post" class="form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="jpgFile">JPG file</label>
                <input type="file" id="jpgFile" name="jpgFile">
            </div>
            <input type="hidden" name="action" value="add"/>
            <button type="submit" name="add" class="btn btn-primary">Send the file</button>
        </form>
    </div>

    <!-- /////////////////////////////////////////////////////////////// -->       
    <div class="container"> 
        <h2>References images</h2>

        <?php $refImages = listReferenceImages()->ids;?>
        <?php foreach($refImages as $refImage):?>
            <div class="ref-image">
                <h3><?php echo $refImage?></h3>
                <p><a href="?action=delete&refID=<?php echo $refImage?>" class="btn btn-danger">delete</a></p>
                <img class="ref-image" src="<?php echo DATA_REFS_URL?>/<?php echo getFileNameFromID($refImage)?>"/>
            </div>
        <?php endforeach;?>

    </div>

    <!-- /////////////////////////////////////////////////////////////// -->
    <script data-main="assets/js/scripts.min" src="assets/js/require.js"></script>

</body>
</html>