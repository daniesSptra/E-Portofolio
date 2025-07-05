<?php 

include "../service/database.php";

session_start();
if (!isset($_SESSION["is_login"]) || !isset($_SESSION["nim"])) { 
    header('Location: ../index.php');
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data_mhs['nama_lengkap']); ?> - Portofolio</title>
    <link rel="stylesheet" href="style/style1.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

    <!-- Header Section Code -->

    <header class="header">
        <a href="#home" class="logo"><?= htmlspecialchars($data_mhs['nama_lengkap']); ?></a>

        <i class='bx bx-menu' id="menu-icon"></i>

        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#skills">Skills</a>
            <a href="#project">Projects</a>
            <a href="#tools">Tools</a>
        </nav>
    </header>

    <!-- Home Section Code -->

    <section class="home" id="home">
        <div class="home-img">
            <img src="../upload/<?= htmlspecialchars($data_mhs['foto']); ?>" alt="Profile Image">
        </div>

        <div class="home-content">
            <h3>Selamat Datang...</h3>
            <h1>Saya <?= htmlspecialchars($data_mhs['nama_lengkap']); ?></h1>
            <h3>Mahasiswa<span class="multiple-text"> <?= htmlspecialchars($data_mhs['program_studi']); ?></span></h3>
            <p>"Ini adalah portofolio pribadi saya, tempat saya berbagi perjalanan akademik, pengalaman, dan
                keterampilan yang telah saya kembangkan. Terima kasih telah mengunjungi, dan jangan ragu untuk
                mengeksplorasi lebih lanjut!
                "</p>

            <a href="#" class="btn">Download CV</a>
        </div>
    </section>

    <!-- About section home -->
    <section class="about" id="about">
        <div class="about-content">
            <h2 class="heading">Tentang <span>Saya</span></h2>
            <h3>Mahasiswa <span><?= htmlspecialchars($data_mhs['program_studi']); ?></span></h3>
            <p>Halo, saya <?= htmlspecialchars($data_mhs['nama_lengkap']); ?>, mahasiswa aktif di Universitas Muhammadiyah Sukabumi, jurusan <?= htmlspecialchars($data_mhs['program_studi']); ?>,
                dengan IPK terakhir <?= htmlspecialchars($data_mhs['ipk']); ?>. Saya memiliki ketertarikan yang besar di bidang Teknologi Informasi dan selalu bersemangat untuk terus belajar serta
                mengembangkan kemampuan saya.
            </p>
            <p>
            Saya telah menguasai beberapa hardskill, seperti 
            <?php if(!empty($hard['skill'])):?>
                <?php foreach($hard['skill'] as $hk):?>
                    <?= htmlspecialchars($hk); ?>,
                <?php endforeach?>
            <?php else:?>
                <p>-</p>
            <?php endif;?> yang saya
            pelajari melalui proyek akademik, pelatihan, dan pengalaman organisasi. Selain itu, softskill seperti
            <?php if(!empty($soft['skill'])):?>
                <?php foreach ($soft['skill'] as $sk): ?>
                    <?= htmlspecialchars($sk); ?>,
                <?php endforeach; ?>
            <?php else:?> 
                <p>-</p>
            <?php endif;?>     
            juga menjadi bagian penting dari pengembangan diri saya.
            </p>
            <a href="#contact" class="btn">Hubungi Saya</a>
        </div>
        <div class="about-img">
            <img src="../upload/<?= htmlspecialchars($data_mhs['foto']); ?>" alt="">
        </div>
    </section>


    <!-- Skilss Section -->
     <section class="skills" id="skills">
        <h2 class="heading">Skill <span>Saya</span></h2>

        <div class="skills-container">
            <div class="skills-box">
                <i class='bx bx-conversation'></i>
                <h3>Bahasa</h3>
                <?php if(!empty($speak['bahasa'])):?>
                <ul>
                    <?php foreach($speak['bahasa'] as $spk):?>
                        <li>
                            <span><h4><?= htmlspecialchars($spk['bahasa']) ?></h4></span>
                            <small><p><?= htmlspecialchars($spk['level']) ?></p></small>
                        </li><br>
                    <?php endforeach?>
                </ul>
                <?php else:?>
                    <ul class="skill-list">
                        <p>-</p>
                    </ul>
                <?php endif;?>
            </div>

            <div class="skills-box">
                <i class='bx bx-user-check'></i>
                <h3>Soft Skills</h3>
                <?php if(!empty($soft['skill'])):?>
                    <ul>
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

            <div class="skills-box">
                <i class='bx bx-cog'></i>
                <h3>Hard Skills</h3>
                <?php if(!empty($hard['skill'])):?>
                    <ul>
                        <?php foreach($hard['skill'] as $hk):?>
                            <li><?= htmlspecialchars($hk); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else:?>
                    <ul class="skill-list">
                        <p>-</p>
                    </ul>
                <?php endif;?>
            </div>

        </div>
    </section>

     <!-- project section -->
    <section class="project" id="project">
        <div class="project-box">
            <h2 class="heading">Projects</h2>
            <div class="wrapper">
                <?php foreach($project['hasil'] as $hsl):?>
                <div class="card">
                    <img src="../upload/<?= htmlspecialchars($hsl['thumb']);?>" alt="Thumbnail" class="card-img">
                    <div class="card-content">
                        <h3 class="card-title"><?= htmlspecialchars($hsl['name']) ?></h3>
                        <h2>Sebagai - <?= htmlspecialchars($hsl['job']) ?></h2>
                        <a href="<?= htmlspecialchars($hsl['link']) ?>" class="card-link">Lihat Project </a>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <!-- Tools section -->
    <section class="tools" id="tools">
        <h2 class="heading">Tools</h2>
        <p>Beberapa Tools dan Bahasa Pemrograman yang dikuasai</p>
        <div class="tools-content">
            <div class="tools-box">
                <h2>Tools:</h2>
                <?php if(!empty($tools['tool'])):?>
                    <?php foreach ($tools['tool'] as $tools): ?>
                        <i class='bx bxl-<?= htmlspecialchars(strtolower($tools)); ?> ' id="icon"><br>
                            <p><?= htmlspecialchars($tools); ?></p>
                        </i>
                    <?php endforeach; ?>
                <?php else:?>
                    <p>-</p>    
                <?php endif;?>
                <br><br>
                <h2>Bahasa Pemrograman</h2>
                <?php if(!empty($prog['language_prog'])):?>
                    <?php foreach ($prog['language_prog'] as $pl): ?>
                        <i class='bx bxl-<?= htmlspecialchars(strtolower($pl)); ?> ' id="icon"><br>
                            <p><?= htmlspecialchars($pl); ?></p>
                        </i>
                    <?php endforeach; ?>
                <?php else:?>
                    <p>-</p>    
                <?php endif;?>
            </div>
        </div>
        <br>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <h2>Hubungi Saya</h2>
        <p>
            Terima kasih sudah berkunjung. Untuk informasi lebih lanjut, silakan hubungi kami melalui WhatsApp atau email yang tertera di bawah ini.
        </p>
        <div class="social-icons">
            <a href="https://wa.me/<?= htmlspecialchars($data_mhs['no_telepon']); ?>"><i class='bx bxl-whatsapp' ></i></a>
            <a href="mailto:<?= htmlspecialchars($data_mhs['email']); ?>"><i class='bx bxl-gmail' ></i></i></a>
        </div>
        <p>&copy;<?= htmlspecialchars($data_mhs['nama_lengkap']); ?>. All Rights Reserved.</p>
    </footer>
</body>

</html>