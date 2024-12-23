<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_FILES["fln"]["name"];
    $tmploc = $_FILES["fln"]["tmp_name"];
    $uploc = "uploads/"; // Define the upload directory

    $fileType = $_FILES["fln"]["type"];   // file type

    $dotpos = strpos($fname, ".");
    $ext = substr($fname, $dotpos);  // file extension 

    $fileSize = $_FILES["fln"]["size"];   // file size


    echo $fileType." : ";
    echo $ext." : ";
    echo $fileSize." : ";

    // Check if the directory exists, if not create it
    if (!is_dir($uploc)) {
        mkdir($uploc, 0777, true);
    }

    // Ensure the filename is safe
    $safeFileName = basename($fname);
    $destination = $uploc . $safeFileName;

    if (!empty($fname)) {
        if($fileType == "image/jpeg"){     //check only image can be uploaded
            if($ext == ".png" || $ext == ".jpg"){
                if($fileSize < 200000){
                    if (move_uploaded_file($tmploc, $destination)) {
                        echo "File uploaded successfully: $safeFileName";
                    } else {
                        echo "Failed to upload the file.";
                    }
                }else{
                    echo "file size is very large!";
                }
            }else{
                echo "only jpg and png file can be uploaded!";
            }
        }else{
            echo "Only image can be uploaded";
        }
        
    } else {
        echo "No file selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="fln"> <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
