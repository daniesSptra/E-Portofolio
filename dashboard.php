<?php
include "service/database.php";

session_start();
if(!isset($_SESSION["is_login"]) || !isset($_SESSION["nim"])){ 
    header('Location: index.php');
    exit();
}

$nim = $_SESSION["nim"];

$sql = "SELECT nama_lengkap FROM users_mhs WHERE nim = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();
$nama_mhs = $result->fetch_assoc();

if(!$nama_mhs){
    session_destroy();
    header('Location: index.php');
    exit();
}

if(isset($_POST["logout"])){
    session_unset();
    session_destroy(); 
    header('location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard E-Portofolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include"layout/navigasi.html"?>
    <div class="hero">
        <h2>Selamat Datang, <?= htmlspecialchars($nama_mhs["nama_lengkap"] ?: "Pengguna"); ?>!</h2>
        <p>
            Anda sekarang berada di dashboard E-Portofolio. Silakan eksplorasi fitur-fitur kami untuk mengembangkan portofolio Anda.
            <br>
            Pilih "Mulai Sekarang" untuk membangun profil anda.
        </p>
        <div class="start">
            <button onclick="window.location.href='buat_profile.php'">Mulai Sekarang</button>
        </div>
        <form action="dashboard.php" method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
	<?php include"layout/footer.html"; ?>
</body>
</html>

