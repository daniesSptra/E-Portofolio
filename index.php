<?php 

include "service/database.php";
session_start();

$login_message ="";

if(isset($_SESSION["is_login"])){
    header("Location: dashboard.php");
}

if(isset($_POST['masuk'])){
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    if(empty($nim) || empty($password)){
        $login_message = "<div class='alert alert-warning'>Nim dan Password tidak Boleh Kosong</div>";
    } else {
        $stmt_check_nim = $db->prepare("SELECT * FROM users_mhs WHERE nim = ?");
        $stmt_check_nim->bind_param("s", $nim);
        $stmt_check_nim->execute();
        $result_check_nim = $stmt_check_nim->get_result();

        if ($result_check_nim->num_rows === 0) {
            $login_message = "<div class='alert alert-danger'>Nim belum terdaftar</div>";
        } else {
            $hash_password = hash('sha256', $password);
            $stmt = $db->prepare("SELECT * FROM users_mhs WHERE nim = ? AND password = ?");
            $stmt->bind_param("ss", $nim, $hash_password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $_SESSION["nim"] = $data["nim"];
                $_SESSION["is_login"] = true;

                header("Location: dashboard.php");
                exit;
            } else {
                $login_message = "<div class='alert alert-danger'><i>Nim/Password salah!</i></div>";
            }
            $stmt->close();
        }

        $stmt_check_nim->close();
    }

    $db->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E-Portofolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <?php include"layout/header.html"?>
    <div class="container">
        <div class="login-box m-4" style="width: 25rem;">
            <form action="index.php" METHOD="POST">
                <img src="img/UMMI .png" alt="Logo">
                <h3>Login Mahasiswa</h3>
                <?= $login_message ?>
                <input type="text" placeholder="NIM" name="nim">
                <input type="password" placeholder="Password" name="password">
                <button type="submit" name="masuk">MASUK</button>
                <a href="register.php">Belum punya akun? &rarr;</a>
            </form>
        </div>
    </div>
    <?php include "layout/footer.html"?>
</body>
</html>
