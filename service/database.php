<?php

$db = mysqli_connect("localhost", "root", "", "e_portofolio");
if($db->connect_error){
    echo "Koneksi database Gagal";
    die("Error connect to database");
}


?>