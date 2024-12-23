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

$sql = "SELECT * FROM filesTable";
$result = $conn->query($sql);



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .gallery-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .gallery-item img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .gallery-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="gallery-container">
        <?php while($data = mysqli_fetch_assoc($result)){ ?>
        <div class="gallery-item">
            <img src="images/<?= $data['file'] ?>" alt="Image 1">
            <h3><?= $data['name'] ?></h3>
        </div>
        <?php } ?>
    </div>
</body>
</html>
