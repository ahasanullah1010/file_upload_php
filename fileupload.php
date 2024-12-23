<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_FILES["fln"]["name"];
    $tmploc = $_FILES["fln"]["tmp_name"];
    $uploc = "uploads/"; // Define the upload directory

    // Check if the directory exists, if not create it
    if (!is_dir($uploc)) {
        mkdir($uploc, 0777, true);
    }

    // Ensure the filename is safe
    $safeFileName = basename($fname);
    $destination = $uploc . $safeFileName;

    if (!empty($fname)) {
        if (move_uploaded_file($tmploc, $destination)) {
            echo "File uploaded successfully: $safeFileName";
        } else {
            echo "Failed to upload the file.";
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
