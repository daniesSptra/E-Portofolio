<?php

include "service/database.php";

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
while ($row = $result_speak->fetch_assoc()){
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
while ($row = $result_job->fetch_assoc()){
    $job['pengalaman'][] = [
        'lokasi' => $row['lokasi'],
        'pekerjaan' => $row['deskripsi']
    ];
}

// Query Certificate
$query_cerftificate = "
    SELECT
        *
    FROM
        certificates
    LEFT JOIN profile
    ON
        certificates.id_profile = profile.id_profile
    WHERE profile.nim = ?";
$stmt_ctf = $db->prepare($query_cerftificate);
$stmt_ctf->bind_param("s", $nim);
$stmt_ctf->execute();
$result_ctf = $stmt_ctf->get_result();

$ctf = [];
$ctf['sertifikat'] = [];
while ($row = $result_ctf->fetch_assoc()){
    $ctf['sertifikat'][] = [
        'thumb' => $row['certificate_thumbnail'],
        'link' => $row['certificate_link'],
        'judul' => $row['certificate_description']
    ];
}

// Query project
$query_project = "
    SELECT
        *
    FROM
        projects
    LEFT JOIN profile
    ON
        projects.id_profile = profile.id_profile
    WHERE profile.nim = ?";
$stmt_project = $db->prepare($query_project);
$stmt_project->bind_param("s", $nim);
$stmt_project->execute();
$result_project = $stmt_project->get_result();

$project = [];
$project['hasil'] = [];
while ($row = $result_project->fetch_assoc()){
    $project['hasil'][] = [
        'name' => $row['project_name'],
        'thumb' => $row['project_thumb'],
        'link' => $row['project_link'],
        'job' => $row['description']
    ];
}

// ========================================================

if (isset($_POST["logout"])) {
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
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="css/profile.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include "layout/navigasi.html" ?>
    <div class="box">
        <div class="text-left z-100">
            <div class="profile-card main ms-5 border-0 position-fixed">
                <img src="upload/<?= htmlspecialchars($data_mhs['foto']); ?>" alt="Profile Picture" class="profile-image" />
                <div class="buttons">
                    <button class="btn btn-primary text-start">
                        <a href="template_page.php" style="color: white; text-decoration:none;">
                        <i class="fas fa-laptop-file me-2"></i> Buat
                        Portofolio</button>
                    <button class="btn btn-primary text-start">
                        <a href="template_page_cv.php" style="color: white; text-decoration:none;">
                        <i class="fas fa-file-lines ms-1 me-3"></i>Buat
                        CV</button>
                    <button class="btn btn-success text-start">
                        <a href="edit_profile.php" style="color: white; text-decoration:none;">
                        <i class="fas fa-user-pen ms-1 me-1"></i> Ubah Profil
                        </a></button>
                    <form action="dashboard.php" method="POST">
                        <button type="submit" name="logout" class="btn btn-danger text-start">
                            <i class="fas fa-arrow-right-from-bracket ms-2 me-2"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="main container text-left ps-5 pe-5 me-5 border-0 bg-white position-relative z-n1 width-100"
            style="margin-left: 300px;">
            <div class="data-mhs">
                <h4 class="text-center">IDENTITAS</h4>
                <div class="row pt-1 pb-1">
                    <div class="col-4">Nama</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['nama_lengkap']); ?></div>
                </div>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Nomor Induk Mahasiswa</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['nim']); ?></div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-4">Jenis Kelamin</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['jenis_kelamin']); ?></div>
                </div>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Tanggal Lahir</div>
                    <div class="col-8">:  <?= htmlspecialchars($data_mhs['tanggal_lahir']); ?></div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-4">Email</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['email']); ?></div>
                </div>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Nomor Telepon</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['no_telepon']); ?></div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-4">Alamat</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['alamat']); ?></div>
                </div>
            </div>
            <br>
            <div class="pendidikan-mhs">
                <h4 class="text-center">PENDIDIKAN</h4>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Asal Sekolah</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['asal_sekolah']); ?></div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-4">Universitas</div>
                    <div class="col-8">: Universitas Muhammadiyah Sukabumi</div>
                </div>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Fakultas</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['fakultas']); ?></div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-4">Program Studi</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['program_studi']); ?></div>
                </div>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Status Mahasiswa</div>
                    <div class="col-8">: Aktif</div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-4">IPK</div>
                    <div class="col-8">: <?= htmlspecialchars($data_mhs['ipk']); ?></div>
                </div>
            </div>
            <br>
            <div class="skill_mhs">
                <h4 class="text-center">KEMAMPUAN</h4>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Softskill</div>
                    <div class="col-8">:
                    <?php if(!empty($soft['skill'])):?>
                        <ul class="skills-list">
                        <?php foreach ($soft['skill'] as $sk): ?>
                            <li><?= htmlspecialchars($sk); ?></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else:?>
                        <ul class="skill-list">
                            <p>-</p>
                        </ul>
                    <?php endif;?>
                    </div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-4">Hardskill</div>
                    <div class="col-8">:
                    <?php if(!empty($hard['skill'])):?>
                        <ul class="skills-list">
                            <?php foreach($hard['skill'] as $hk):?>
                                <li><?= htmlspecialchars($hk); ?></li>
                            <?php endforeach?>
                        </ul>
                    <?php else:?>
                        <ul class="skill-list">
                            <p>-</p>
                        </ul>
                    <?php endif;?>
                    </div>
                </div>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Bahasa</div>
                    <div class="col-8">:
                    <?php if(!empty($speak['bahasa'])):?>
                        <ul class="language-list">
                            <?php foreach($speak['bahasa'] as $spk):?>
                                <li>
                                    <?= htmlspecialchars($spk['bahasa']) ?> - 
                                    Level: <?= htmlspecialchars($spk['level']) ?>
                                </li>
                            <?php endforeach?>
                        </ul>
                    <?php else:?>
                        <ul class="skill-list">
                            <p>-</p>
                        </ul>
                    <?php endif;?>
                    </div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-4">Bahasa Pemrograman</div>
                    <div class="col-8">:
                    <?php if(!empty($prog['language_prog'])):?>
                        <ul class="programming-list">
                        <?php foreach ($prog['language_prog'] as $pl): ?>
                            <li><?= htmlspecialchars($pl); ?></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else:?>
                        <ul class="skill-list">
                            <p>-</p>
                        </ul>
                    <?php endif;?>
                    </div>
                </div>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Tools</div>
                    <div class="col-8">:
                    <?php if(!empty($tools['tool'])):?>
                        <ul class="tools-list">
                        <?php foreach ($tools['tool'] as $tools): ?>
                            <li><?= htmlspecialchars($tools); ?></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else:?>
                        <ul class="skill-list">
                            <p>-</p>
                        </ul>
                    <?php endif;?>
                    </div>
                </div>
            </div>
            <br>
            <div class="pencapaian-mhs">
                <h4 class="text-center">PENCAPAIAN</h4>
                <div class="row">
                    <div class="col-4">Pengalaman</div>
                    <div class="col-8">:
                        <ul>
                            <?php foreach($job['pengalaman'] as $exp):?>
                                <li>
                                    <strong><?= htmlspecialchars($exp['lokasi']) ?></strong><br>
                                    - <?= htmlspecialchars($exp['pekerjaan']) ?>
                                </li>
                            <?php endforeach?>
                        </ul>
                    </div>
                </div>
                <div class="row bg-secondary bg-opacity-10 pt-2 pb-2">
                    <div class="col-4">Sertifikat</div>
                    <div class="col-8">:
                        <ul class="sertifikat-list">
                            <?php foreach($ctf['sertifikat'] as $stf):?>
                                <li>
                                    <h5><?= htmlspecialchars($stf['judul']) ?></h5>
                                    <p><?= htmlspecialchars($stf['link']) ?></p>
                                    <img src="upload/<?= htmlspecialchars($stf['thumb']);?>" class="img-thumbnail" alt="" style="width:100px;">
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">Proyek</div>
                    <div class="col-8">:
                        <ul>
                            <?php foreach($project['hasil'] as $hsl):?>
                                <li>
                                    <h5><?= htmlspecialchars($hsl['name']) ?></h5>
                                    <h6><?= htmlspecialchars($hsl['job']) ?></h6>
                                    <p><?= htmlspecialchars($hsl['link']) ?></p>
                                    <img src="upload/<?= htmlspecialchars($hsl['thumb']);?>" class="img-thumbnail" alt="" style="width:100px;">
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <?php include "layout/footer.html" ?>
</body>

</html>