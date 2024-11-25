<?php

require './../config/db.php';

if (isset($_POST['submit'])) {
    global $db_connect;

    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tempImage = $_FILES['image']['tmp_name'];

    
    $randomFilename = time() . '-' . md5(rand()) . '-' . $image;

    $uploadPath = __DIR__ . '/../upload/' . $randomFilename;

    
    if (!is_dir(__DIR__ . '/../upload')) {
        mkdir(__DIR__ . '/../upload', 0777, true);
    }

    
    $upload = move_uploaded_file($tempImage, $uploadPath);

    if ($upload) {
        $query = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '/upload/$randomFilename')";
        mysqli_query($db_connect, $query);
        
    
        header("Location: ../success.php?name=" . urlencode($name));
        exit();
    } else {
        echo "Gagal mengunggah produk. Coba lagi.";
    }
}
