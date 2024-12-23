<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "file_upload";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection Failed : ". $conn->connect_error);
}
else{
    echo "Database connect successfully!";
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['filename'];
    $fname = $_FILES["fln"]["name"];
    $tmploc = $_FILES["fln"]["tmp_name"];
    $uploc = "images/"; // Define the upload directory

    $fileType = $_FILES["fln"]["type"];   // file type

    $dotpos = strrpos($fname, ".");
    echo ". position : $dotpos";
    $ext = substr($fname, $dotpos);  // file extension 

    $fnamewithoutext = substr($fname,0, $dotpos); // for generate new name of the file

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
                if($fileSize < 5000000){
                    if(file_exists($uploc.''.$fname)){
                        $newfname = $fnamewithoutext.time().$ext;
                        $newfloc = $uploc . $newfname;
                        if (move_uploaded_file($tmploc, $newfloc)) {
                            echo "File uploaded successfully: $newfname";
                            $sql = "INSERT INTO filesTable (name, file) VALUES ('$name', '$newfname')";
                            $query = $conn->query($sql);
                            if($query){
                                echo "Data inserted successfully!";
                            }
                        } else {
                            echo "Failed to upload the file.";
                        }
                    }else{
                        if (move_uploaded_file($tmploc, $destination)) {
                            echo "File uploaded successfully: $safeFileName";
                            $sql = "INSERT INTO filesTable (name, file) VALUES ('$name', '$safeFileName')";
                            $query = $conn->query($sql);
                            if($query){
                                echo "Data inserted successfully!";
                            }
                        } else {
                            echo "Failed to upload the file.";
                        }
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-actions {
            text-align: center;
        }

        .form-actions button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-actions button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Upload File</h1>
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="filename">File Name</label>
                <input type="text" id="filename" name="filename" placeholder="Enter file name" required>
            </div>
            <div class="form-group">
                <label for="file">Choose File</label>
                <input type="file" id="fln" name="fln" required>
            </div>
            <div class="form-actions">
                <button type="submit">Upload</button>
            </div>
        </form>
    </div>
</body>
</html>

