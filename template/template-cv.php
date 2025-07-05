<?php


$db = mysqli_connect("localhost", "root", "", "e_portofolio");
if($db->connect_error){
    echo "Koneksi database Gagal";
    die("Error connect to database");
}


session_start();
if (!isset($_SESSION["is_login"]) || !isset($_SESSION["nim"])) {
    header('Location: index.php');
    exit();
}

// Ambil nim dari sesi
$nim = $_SESSION['nim'];

// Query utama untuk profil pengguna
$query = "
    SELECT 
        users_mhs.*,
        profile.*
    FROM 
        users_mhs 
    LEFT JOIN 
        profile 
    ON 
        users_mhs.nim = profile.nim
    WHERE 
        users_mhs.nim = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();
$data_mhs = $result->fetch_assoc();

if (!$data_mhs) {
    echo "Data tidak ditemukan.";
    exit();
}


// Query softskills
$query_soft = "
    SELECT skill 
    FROM softskills 
    LEFT JOIN profile 
    ON softskills.id_profile = profile.id_profile 
    WHERE profile.nim = ?";
$stmt_soft = $db->prepare($query_soft);
$stmt_soft->bind_param("s", $nim);
$stmt_soft->execute();
$result_soft = $stmt_soft->get_result();

$soft = [];
while ($row = $result_soft->fetch_assoc()) {
    $soft['skill'][] = $row['skill'];
}

// Query hardskills
$query_hard = "
    SELECT skill 
    FROM hardskills 
    LEFT JOIN profile 
    ON hardskills.id_profile = profile.id_profile 
    WHERE profile.nim = ?";
$stmt_hard = $db->prepare($query_hard);
$stmt_hard->bind_param("s", $nim);
$stmt_hard->execute();
$result_hard = $stmt_hard->get_result();

$hard = [];
while ($row = $result_hard->fetch_assoc()) {
    $hard['skill'][] = $row['skill'];
}

// Query Berbahasa
$query_speak = "
    SELECT
        communication_languages.language AS bahasa, 
        communication_languages.level AS level
    FROM
        communication_languages
    LEFT JOIN profile
    ON
        communication_languages.id_profile = profile.id_profile
    WHERE profile.nim = ?";
$stmt_speak = $db->prepare($query_speak);
$stmt_speak->bind_param("s", $nim);
$stmt_speak->execute();
$result_speak = $stmt_speak->get_result();

$speak = [];
$speak['bahasa'] = [];
while ($row = $result_speak->fetch_assoc()) {
    $speak['bahasa'][] = [
        'bahasa' => $row['bahasa'],
        'level' => $row['level']
    ];
}

// Query bahasa pemrograman
$query_prog = "
    SELECT * 
    FROM languages 
    LEFT JOIN profile 
    ON languages.id_profile = profile.id_profile 
    WHERE profile.nim = ?";
$stmt_prog = $db->prepare($query_prog);
$stmt_prog->bind_param("s", $nim);
$stmt_prog->execute();
$result_prog = $stmt_prog->get_result();

$prog = [];
while ($row = $result_prog->fetch_assoc()) {
    $prog['language_prog'][] = $row['language_prog'];
}

// Query Tools
$query_tools = "
    SELECT * 
    FROM tools 
    LEFT JOIN profile 
    ON tools.id_profile = profile.id_profile 
    WHERE profile.nim = ?";
$stmt_tools = $db->prepare($query_tools);
$stmt_tools->bind_param("s", $nim);
$stmt_tools->execute();
$result_tools = $stmt_tools->get_result();

$tools = [];
while ($row = $result_tools->fetch_assoc()) {
    $tools['tool'][] = $row['tool'];
}

// Query Experience
$query_job = "
    SELECT
        *
    FROM
        experience
    LEFT JOIN profile
    ON
        experience.id_profile = profile.id_profile
    WHERE profile.nim = ?";
$stmt_job = $db->prepare($query_job);
$stmt_job->bind_param("s", $nim);
$stmt_job->execute();
$result_job = $stmt_job->get_result();

$job = [];
$job['pengalaman'] = [];
while ($row = $result_job->fetch_assoc()) {
    $job['pengalaman'][] = [
        'lokasi' => $row['lokasi'],
        'pekerjaan' => $row['deskripsi']
    ];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV-Template</title>
    <link rel="stylesheet" href="style/cv1.css">
    <style>
        /* style/cv1.css */

        /* Gaya umum untuk tampilan di layar */
        .resume {
            display: flex;
            /* Gaya lainnya */
        }

        /* Gaya untuk media cetak */
        @media print {
            @page {
                size: A4;
                /* Atur ukuran halaman ke A4 */
                margin: 10mm;
                /* Atur margin sesuai kebutuhan */
            }

            body {
                -webkit-print-color-adjust: exact;
                /* Pastikan warna dicetak dengan benar */
                color-adjust: exact;
            }

            .sidebar {
                width: 30%;
                /* Atur lebar sidebar */
                float: left;
                /* Mengapungkan sidebar ke kiri */
            }

            .main-content {
                width: 80%;
                /* Atur lebar konten utama */
                float: right;
                /* Mengapungkan konten utama ke kanan */
            }

            /* Sembunyikan elemen yang tidak perlu saat mencetak */
            .no-print {
                display: none;
                /* Sembunyikan elemen dengan kelas ini */
            }

            /* Atur font dan ukuran teks jika diperlukan */
            h1,
            h2,
            h3,
            h4,
            p {
                margin: 0;
                /* Hapus margin untuk menghemat ruang */
                page-break-inside: avoid;
                /* Hindari pemisahan halaman di dalam elemen ini */
            }

            /* Atur elemen lain sesuai kebutuhan */
        }
    </style>
</head>

<body>
    <div class="resume">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile">
                <img src="../upload/<?= htmlspecialchars($data_mhs['foto']); ?>" alt="Profile Picture">
                <h1><?= htmlspecialchars($data_mhs['nama_lengkap']); ?></h1>
            </div>
            <div class="contact">
                <h2>Kontak</h2>
                <p>Phone: <?= htmlspecialchars($data_mhs['no_telepon']); ?></p>
                <p>Email: <?= htmlspecialchars($data_mhs['email']); ?></p>
                <p>Alamat: <?= htmlspecialchars($data_mhs['alamat']); ?></p>
            </div>
            <div class="language">
                <h2>Kemampuan Bahasa</h2>
                <?php if (!empty($speak['bahasa'])): ?>
                    <?php foreach ($speak['bahasa'] as $spk): ?>
                        <p>
                            <i></i><?= htmlspecialchars($spk['bahasa']) ?><br>
                            Level: <?= htmlspecialchars($spk['level']) ?>
                        </p>
                    <?php endforeach ?>
                <?php else: ?>
                    <p>-</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <section class="about">
                <h2>Tentang Saya</h2>
                <p>
                    Halo, saya <?= htmlspecialchars($data_mhs['nama_lengkap']); ?>, berasal dari Universitas
                    Muhammadiyah Sukabumi, Program Studi <?= htmlspecialchars($data_mhs['program_studi']); ?>,
                    dengan IPK terakhir <?= htmlspecialchars($data_mhs['ipk']); ?>. Saya memiliki ketertarikan yang
                    besar di bidang Komputer, Informasi Teknologi dan selalu bersemangat untuk terus belajar serta
                    mengembangkan kemampuan saya
                </p>
            </section>
            <section class="pendidikan">
                <h2>Pendidikan</h2>
                <ul>
                    <li>
                        <div class="universitas">
                            <p>Universitas Muhammadiyah Sukabumi</p>
                            <P>Program Studi: <?= htmlspecialchars($data_mhs['program_studi']); ?></p>
                            <p>IPK: <?= htmlspecialchars($data_mhs['ipk']); ?></p>
                        </div>
                    </li>
                    <li>
                        <div class="asal-sekolah">
                            <p>Asal Sekolah:</p>
                            <p><?= htmlspecialchars($data_mhs['asal_sekolah']); ?></< /p>
                        </div>
                    </li>
                </ul>
            </section>
            <section class="skills">
                <h2>Kemampuan</h2>
                <div class="skills-box">
                    <div class="softskill">
                        <h4>Softskill</h4>
                        <?php if (!empty($soft['skill'])): ?>
                            <ul class="skills-list">
                                <?php foreach ($soft['skill'] as $sk): ?>
                                    <li><?= htmlspecialchars($sk); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <ul class="skill-list">
                                <p>-</p>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="hardskill">
                        <h4>Hardskills</h4>
                        <?php if (!empty($hard['skill'])): ?>
                            <ul class="skills-list">
                                <?php foreach ($hard['skill'] as $hk): ?>
                                    <li><?= htmlspecialchars($hk); ?></li>
                                <?php endforeach ?>
                            </ul>
                        <?php else: ?>
                            <ul class="skill-list">
                                <p>-</p>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="box-toolLanguageP">
                    <div class="tools">
                        <h4>Aplikasi/Tools</h4>
                        <?php if (!empty($tools['tool'])): ?>
                            <ul class="tools-list">
                                <?php foreach ($tools['tool'] as $tools): ?>
                                    <li><?= htmlspecialchars($tools); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <ul class="skill-list">
                                <p>-</p>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="languageP">
                        <h4>Bahasa Pemrograman</h4>
                        <?php if (!empty($prog['language_prog'])): ?>
                            <ul class="programming-list">
                                <?php foreach ($prog['language_prog'] as $pl): ?>
                                    <li><?= htmlspecialchars($pl); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <ul class="skill-list">
                                <p>-</p>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <section class="work-experience">
                <h2>Pengalaman</h2>
                <ul>
                    <?php foreach ($job['pengalaman'] as $exp): ?>
                        <li>
                            <h4><?= htmlspecialchars($exp['lokasi']) ?></h4>
                            <?= htmlspecialchars($exp['pekerjaan']) ?>
                        </li><br>
                    <?php endforeach ?>
                </ul>
            </section>
        </div>
    </div>
</body>

</html>