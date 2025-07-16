<?php 

include "service/database.php";
session_start();

$register_message = "";

if(isset($_SESSION["is_login"])){ 
    header("location: dashboard.php");
}

if (isset($_POST['daftar'])) {
    $nim = $_POST['nim'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $fakultas = $_POST['fakultas'];
    $jurusan = $_POST['jurusan'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $register_message = "";

    if ($password !== $confirm_password) {
        $register_message = "<div class='alert alert-danger'>Password tidak cocok, silakan ulangi.</div>";
    } else {
        $hash_password = hash("sha256", $password);

        $check_nim_query = $db->prepare("SELECT nim FROM users_mhs WHERE nim = ?");
        $check_nim_query->bind_param("s", $nim);
        $check_nim_query->execute();
        $check_nim_query->store_result();

        if ($check_nim_query->num_rows > 0) {
            $register_message = "<div class='alert alert-danger'>NIM sudah ada, silakan gunakan yang lain.</div>";
        } else {
            $stmt = $db->prepare("INSERT INTO users_mhs (id, nim, nama_lengkap, tanggal_lahir, jenis_kelamin, fakultas, program_studi, password) 
                                  VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nim, $nama_lengkap, $tgl_lahir, $jenis_kelamin, $fakultas, $jurusan, $hash_password);

            if ($stmt->execute()) {
                $default = 'Belum ada';
                $stmt_profile = $db->prepare("INSERT INTO profile (nim) VALUES (?)");
                $stmt_profile->bind_param("s", $nim);
                $stmt_profile->execute();

                $id_profile = $db->insert_id;

                $stmt_profile->close();

                // Insert softskill
                $stmt = $db->prepare("INSERT INTO softskills (id_profile, skill) VALUES (?, ?)");
                $stmt->bind_param("is", $id_profile, $default);
                $stmt->execute();

                // Hardskill
                $stmt = $db->prepare("INSERT INTO hardskills (id_profile, skill) VALUES (?, ?)");
                $stmt->bind_param("is", $id_profile, $default);
                $stmt->execute();

                // Tools
                $stmt = $db->prepare("INSERT INTO tools (id_profile, tool) VALUES (?, ?)");
                $stmt->bind_param("is", $id_profile, $default);
                $stmt->execute();

                // Languages (Pemrograman)
                $stmt = $db->prepare("INSERT INTO languages (id_profile, language_prog) VALUES (?, ?)");
                $stmt->bind_param("is", $id_profile, $default);
                $stmt->execute();
                
                // Communication Languages
                $stmt = $db->prepare("INSERT INTO communication_languages (id_profile, language, level) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id_profile, $default, $level);
                $stmt->execute();

                // Experience
                $stmt = $db->prepare("INSERT INTO experience (id_profile, lokasi, deskripsi) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id_profile, $default, $default);
                $stmt->execute();

                // Project
                $stmt = $db->prepare("INSERT INTO projects (id_profile, project_thumb, project_link, project_name, description) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $id_profile, $imgDefault, $linkDefault, $default, $default);
                $stmt->execute();

                // Certificate
                $stmt = $db->prepare("INSERT INTO certificates (id_profile, certificate_thumbnail, certificate_link, certificate_description) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isss", $id_profile, $imgDefault, $linkDefault, $default);
                $stmt->execute();

                echo "<script>
                    alert('Pendaftaran berhasil! Anda akan dialihkan ke halaman login.');
                    window.location.href = 'index.php'; // Redirect ke halaman login
                </script>";
                exit;
            } else {
                $register_message = "<div class='alert alert-danger'>Daftar akun gagal: " . $db->error . "</div>";
            }
            $stmt->close();
        }
        $check_nim_query->close();
    }
    $db->close();
}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi E-Portofolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/register.css">
    
</head>
<body>
    <?php include "layout/header.html"?>
    <div class="form-container">
        <img src="img/UMMI .png" alt="Logo">
        <h2>Registrasi Mahasiswa</h2>
        <form action="register.php" method="POST" class="p-2">
            <?= $register_message ?? '' ?>
            <div class="form-grid">
                <input type="text" placeholder="NIM" required name="nim">
                <input type="text" placeholder="Nama Lengkap" required name="nama_lengkap">
                <input type="date" placeholder="Tanggal Lahir" required name= "tgl_lahir">
                <select required name="jenis_kelamin">
                    <option value="" disabled selected>Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <select id="fakultas" required onchange="updateJurusan()" name="fakultas">
                    <option value="" disabled selected>Pilih Fakultas</option>
                    <option value="Sains dan Teknologi">Sains dan Teknologi</option>
                    <option value="Ekonomi">Ekonomi</option>
                    <option value="Keguruan dan Ilmu Pendidikan">Keguruan dan Ilmu Pendidikan</option>
                    <option value="Ilmu Sosial">Ilmu Sosial</option>
                    <option value="Pertanian">Pertanian</option>
                    <option value="Hukum">Hukum</option>
                    <option value="Kesehatan">Kesehatan</option>
                </select>
                
                <select id="jurusan" required name="jurusan">
                    <option value="" disabled selected>Pilih Program Studi</option>
                </select>
            </div>
            
            <input type="password" placeholder="Password" required name="password">
            <input type="password" placeholder="Ketik Ulang Password" required name="confirm_password">
            <button type="submit" name="daftar">Daftar</button>
        </form>
        <div class="footer">
            <a href="index.php">Ke Halaman Login &rarr;</a>
        </div>
    </div>
    <?php include "layout/footer.html"?>
    <script src="JS/main.js"></script>
</body>
</html>
