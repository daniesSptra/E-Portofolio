<?php 

include "service/database.php";
session_start();

// Fetch existing profile data
$nim = $_SESSION['nim'];
$stmt = $db->prepare("SELECT * FROM profile WHERE nim = ?");
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

if (isset($_POST["update"])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $no_telepon = mysqli_real_escape_string($db, $_POST['no_telepon']);
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']);
    $asal_sekolah = mysqli_real_escape_string($db, $_POST['asal_sekolah']);
    $ipk = mysqli_real_escape_string($db, $_POST['ipk']);
    
    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $namaFile = $_FILES['photo']['name'];
        $ukuranFile = $_FILES['photo']['size'];
        $tmpFile = $_FILES['photo']['tmp_name'];
        $ekstensiValid = ['jpg', 'jpeg', 'png'];

        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (!in_array($ekstensiGambar, $ekstensiValid)) {
            echo "<script>alert('File tidak sesuai. Hanya jpg, jpeg, dan png yang diperbolehkan.');</script>";
            exit;
        }

        if ($ukuranFile > 5 * 1024 * 1024) {
            echo "<script>alert('Ukuran file terlalu besar. Maksimal 5MB.');</script>";
            exit;
        }

        $namaBaru = uniqid() . '.' . $ekstensiGambar;
        $folderUpload = "upload/";
        if (!is_dir($folderUpload)) {
            mkdir($folderUpload, 0777, true);
        }

        $pathFile = $folderUpload . $namaBaru;
        if (move_uploaded_file($tmpFile, $pathFile)) {
            // Update profile with new photo
            $stmt = $db->prepare("UPDATE profile SET email=?, no_telepon=?, alamat=?, asal_sekolah=?, ipk=?, foto=? WHERE nim=?");
            $stmt->bind_param("sssssss", $email, $no_telepon, $alamat, $asal_sekolah, $ipk, $namaBaru, $nim);
        } else {
            echo "<script>alert('Gagal mengunggah file.');</script>";
            exit;
        }
    } else {
        // Update profile without changing the photo
        $stmt = $db->prepare("UPDATE profile SET email=?, no_telepon=?, alamat=?, asal_sekolah=?, ipk=? WHERE nim=?");
        $stmt->bind_param("ssssss", $email, $no_telepon, $alamat, $asal_sekolah, $ipk, $nim);
    }

    if ($stmt->execute()) {
        // Update Soft Skills
        if (isset($_POST['softskills'])) {
            // Hapus soft skills yang ada
            $stmt = $db->prepare("DELETE FROM softskills WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
            $stmt->bind_param("s", $nim);
            $stmt->execute();

            // Siapkan pernyataan untuk memasukkan soft skills baru
            $stmt = $db->prepare("INSERT INTO softskills (id_profile, skill) VALUES (?, ?)");
            foreach ($_POST['softskills'] as $softskill) {
                if (!empty($softskill)) {
                    $stmt->bind_param("is", $profile['id_profile'], $softskill);
                    $stmt->execute();
                }
            }
            $stmt->close();
        }

        // Update Hard Skills
        if (isset($_POST['hardskills'])) {
            // Hapus hard skills yang ada
            $stmt = $db->prepare("DELETE FROM hardskills WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
            $stmt->bind_param("s", $nim);
            $stmt->execute();

            // Siapkan pernyataan untuk memasukkan hard skills baru
            $stmt = $db->prepare("INSERT INTO hardskills (id_profile, skill) VALUES (?, ?)");
            foreach ($_POST['hardskills'] as $hardSkill) {
                if (!empty($hardSkill)) {
                    $stmt->bind_param("is", $profile['id_profile'], $hardSkill);
                    $stmt->execute();
                }
            }
            $stmt->close();
        }

        // Update Tools
        if (isset($_POST['tools'])) {
            // Hapus tools yang ada
            $stmt = $db->prepare("DELETE FROM tools WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
            $stmt->bind_param("s", $nim);
            $stmt->execute();

            // Siapkan pernyataan untuk memasukkan tools baru
            $stmt = $db->prepare("INSERT INTO tools (id_profile, tool) VALUES (?, ?)");
            foreach ($_POST['tools'] as $tool) {
                if (!empty($tool)) {
                    $stmt->bind_param("is", $profile['id_profile'], $tool);
                    $stmt->execute();
                }
            }
            $stmt->close();
        }

        // Update Programming Languages
        if (isset($_POST['languages'])) {
            // Hapus programming languages yang ada
            $stmt = $db->prepare("DELETE FROM languages WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
            $stmt->bind_param("s", $nim);
            $stmt->execute();

            // Siapkan pernyataan untuk memasukkan programming languages baru
            $stmt = $db->prepare("INSERT INTO languages (id_profile, language_prog) VALUES (?, ?)");
            foreach ($_POST['languages'] as $language) {
                if (!empty($language)) {
                    $stmt->bind_param("is", $profile['id_profile'], $language);
                    $stmt->execute();
                }
            }
            $stmt->close();
        }

        // Update Communication Languages
        if (isset($_POST['communication_languages']) && isset($_POST['communication_levels'])) {
            // Hapus communication languages yang ada
            $stmt = $db->prepare("DELETE FROM communication_languages WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
            $stmt->bind_param("s", $nim);
            $stmt->execute();

            // Siapkan pernyataan untuk memasukkan communication languages baru
            $stmt = $db->prepare("INSERT INTO communication_languages (id_profile, language, level) VALUES (?, ?, ?)");
            foreach ($_POST['communication_languages'] as $index => $language) {
                $level = $_POST['communication_levels'][$index];
                if (!empty($language)) {
                    $stmt->bind_param("iss", $profile['id_profile'], $language, $level);
                    $stmt->execute();
                }
            }
            $stmt->close();
        }

        // Update Experiences
        if (isset($_POST['title-experience']) && isset($_POST['experience'])) {
            // Hapus experiences yang ada
            $stmt = $db->prepare("DELETE FROM experience WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
            $stmt->bind_param("s", $nim);
            $stmt->execute();

            // Siapkan pernyataan untuk memasukkan experiences baru
            $stmt = $db->prepare("INSERT INTO experience (id_profile, lokasi, deskripsi) VALUES (?, ?, ?)");
            foreach ($_POST['title-experience'] as $index => $title) {
                $experience = $_POST['experience'][$index];
                if (!empty($title) && !empty($experience)) {
                    $stmt->bind_param("iss", $profile['id_profile'], $title, $experience);
                    $stmt->execute();
                }
            }
            $stmt->close();
        }

        // Update Projects
        if (isset($_FILES['project_thumbnail']) && isset($_POST['project_title']) && isset($_POST['project_link']) && isset($_POST['project_description'])) {
            // Hapus proyek yang ada
            $stmt = $db->prepare("DELETE FROM projects WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
            $stmt->bind_param("s", $nim);
            $stmt->execute();

            // Siapkan pernyataan untuk memasukkan proyek baru
            $stmt = $db->prepare("INSERT INTO projects (id_profile, project_thumb, project_link, project_name, description) VALUES (?, ?, ?, ?, ?)");
            $projectTitles = $_POST['project_title'];
            $projectLinks = $_POST['project_link'];
            $projectDescriptions = $_POST['project_description'];

            foreach ($_FILES['project_thumbnail']['name'] as $index => $fileName) {
                if ($_FILES['project_thumbnail']['error'][$index] === UPLOAD_ERR_OK) {
                    $namaFile = $_FILES['project_thumbnail']['name'][$index];
                    $ukuranFile = $_FILES['project_thumbnail']['size'][$index];
                    $tmpFile = $_FILES['project_thumbnail']['tmp_name'][$index];
                    $ekstensiValid = ['jpg', 'jpeg', 'png'];

                    $ekstensiGambar = explode('.', $namaFile);
                    $ekstensiGambar = strtolower(end($ekstensiGambar));
                    if (!in_array($ekstensiGambar, $ekstensiValid)) {
                        echo "<script>alert('File tidak sesuai. Hanya jpg, jpeg, dan png yang diperbolehkan.');</script>";
                        exit;
                    }

                    if ($ukuranFile > 5 * 1024 * 1024) {
                        echo "<script>alert('Ukuran file terlalu besar. Maksimal 5MB.');</script>";
                        exit;
                    }

                    $namaBaru = uniqid() . '.' . $ekstensiGambar;
                    $folderUpload = "upload/";
                    if (!is_dir($folderUpload)) {
                        mkdir($folderUpload, 0777, true);
                    }

                    $pathFile = $folderUpload . $namaBaru;
                    if (move_uploaded_file($tmpFile, $pathFile)) {
                        $projectTitle = $projectTitles[$index];
                        $projectLink = $projectLinks[$index];
                        $projectDescription = $projectDescriptions[$index];

                        $stmt->bind_param("issss", $profile['id_profile'], $namaBaru, $projectLink, $projectTitle, $projectDescription);
                        $stmt->execute();
                    } else {
                        echo "<script>alert('Gagal mengunggah file.');</script>";
                        exit;
                    }
                }
            }
            $stmt->close();
        }

        // Update Certificates
        if (isset($_FILES['certificate_thumbnail']) && isset($_POST['certificate_description']) && isset($_POST['certificate_link'])) {
            // Hapus sertifikat yang ada
            $stmt = $db->prepare("DELETE FROM certificates WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
            $stmt->bind_param("s", $nim);
            $stmt->execute();

            // Siapkan pernyataan untuk memasukkan sertifikat baru
            $stmt = $db->prepare("INSERT INTO certificates (id_profile, certificate_thumbnail, certificate_link, certificate_description) VALUES (?, ?, ?, ?)");
            $certificateDescriptions = $_POST['certificate_description'];
            $certificateLinks = $_POST['certificate_link'];

            foreach ($_FILES['certificate_thumbnail']['name'] as $index => $fileName) {
                if ($_FILES['certificate_thumbnail']['error'][$index] === UPLOAD_ERR_OK) {
                    $namaFile = $_FILES['certificate_thumbnail']['name'][$index];
                    $ukuranFile = $_FILES['certificate_thumbnail']['size'][$index];
                    $tmpFile = $_FILES['certificate_thumbnail']['tmp_name'][$index];
                    $ekstensiValid = ['jpg', 'jpeg', 'png'];

                    $ekstensiGambar = explode('.', $namaFile);
                    $ekstensiGambar = strtolower(end($ekstensiGambar));
                    if (!in_array($ekstensiGambar, $ekstensiValid)) {
                        echo "<script>alert('File tidak sesuai. Hanya jpg, jpeg, dan png yang diperbolehkan.');</script>";
                        exit;
                    }

                    if ($ukuranFile > 5 * 1024 * 1024) {
                        echo "<script>alert('Ukuran file terlalu besar. Maksimal 5MB.');</script>";
                        exit;
                    }

                    $namaBaru = uniqid() . '.' . $ekstensiGambar;
                    $folderUpload = "upload/";
                    if (!is_dir($folderUpload)) {
                        mkdir($folderUpload, 0777, true);
                    }

                    $pathFile = $folderUpload . $namaBaru;
                    if (move_uploaded_file($tmpFile, $pathFile)) {
                        $certificateDescription = $certificateDescriptions[$index];
                        $certificateLink = $certificateLinks[$index];

                        $stmt->bind_param("isss", $profile['id_profile'], $namaBaru, $certificateLink, $certificateDescription);
                        $stmt->execute();
                    } else {
                        echo "<script>alert('Gagal mengunggah file.');</script>";
                        exit;
                    }
                }
            }
            $stmt->close();
        }

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data berhasil diperbarui!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profil</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <style>
        textarea {
            resize: vertical;
            min-height: 100px;
            max-height: 300px;
            height: 17px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <h1 class="text-center mt-3">PERBARUI PROFIL</h1>
    <div class="main container p-3 my-5 mx-auto shadow-sm border">
        <form action="" method="POST" enctype="multipart/form-data" class="p-5">
            <h3 class="mb-3">Identitas</h3>
            <div class="row justify-content-md-start align-items-center mb-2">
                <div class="col-lg-2">
                    <div class="preview-container">
                        <img id="imagePreview" src="upload/<?php echo $profile['foto']; ?>" alt="Preview Gambar" class="preview-image" style="width: 100px; ">
                    </div>
                </div>
                <div class="col-lg-auto">
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroup-sizing-default">Upload Foto</span>
                        <input type="file" name="photo" class="form-control" id="photo" accept="image/" aria-describedby="inputGroupFileAddon04">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                        <input type="email" name="email" value="<?php echo $profile['email']; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">Nomor Telepon</span>
                        <input type="tel" name="no_telepon" value="<?php echo $profile['no_telepon']; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">Alamat</span>
                        <textarea class="form-control" name="alamat" placeholder="Tulis Alamat Anda Disini" id="exampleFormControlTextarea1" rows="3"><?php echo $profile['alamat']; ?></textarea>
                    </div>
                </div>
                <br>
            </div>
            <hr>
            <br>
            <h3 class="mb-3">Pendidikan</h3>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">Asal Sekolah</span>
                        <input type="text" name="asal_sekolah" value="<?php echo $profile['asal_sekolah']; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <br>
            </div>

            <div class="row">
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">IPK</span>
                        <input type="number" name="ipk" value="<?php echo $profile['ipk']; ?>" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" min="0" max="4" step="0.01">
                    </div>
                </div>
                <br>
            </div>
            <hr>
            <br>
            <h3 class="mb-3">Kemampuan</h3>
            <div class="row">
                <div class="col">
                    <!-- Softskill -->
                    <div id="softSkillContainer">
                        <?php
                        // Fetch and display existing soft skills
                        $stmt = $db->prepare("SELECT skill FROM softskills WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
                        $stmt->bind_param("s", $nim);
                        $stmt->execute();
                        $softskills = $stmt->get_result();
                        while ($row = $softskills->fetch_assoc()) {
                            echo '<div class="softSkillRow input-group mb-1">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Soft Skill</span>
                                    <input type="text" placeholder="Masukkan Kemampuan Anda" class="form-control" name="softskills[]" value="' . $row['skill'] . '" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                    <button type="button" class="removeSoftSkill btn-outline-secondary">-</button>
                                    <button type="button" id="addSoftSkill" class="text-light bg-primary ms-2 border-0 rounded-end"><i class="fas fa-plus"></i></button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col">
                    <!-- Hardskill -->
                    <div id="hardSkillContainer">
                        <?php
                        // Fetch and display existing hard skills
                        $stmt = $db->prepare("SELECT skill FROM hardskills WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
                        $stmt->bind_param("s", $nim);
                        $stmt->execute();
                        $hardskills = $stmt->get_result();
                        while ($row = $hardskills->fetch_assoc()) {
                            echo '<div class="hardSkillRow input-group mb-1">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Hard Skill</span>
                                    <input type="text" placeholder="Masukkan Kemampuan Anda" class="form-control" name="hardskills[]" value="' . $row['skill'] . '" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                    <button type="button" class="removeHardSkill">-</button>
                                    <button type="button" id="addHardSkill" class="text-light bg-primary ms-2 border-0 rounded-end"><i class="fas fa-plus"></i></button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col">
                    <!-- Tools -->
                    <div id="toolsContainer">
                        <?php
                        // Fetch and display existing tools
                        $stmt = $db->prepare("SELECT tool FROM tools WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
                        $stmt->bind_param("s", $nim);
                        $stmt->execute();
                        $tools = $stmt->get_result();
                        while ($row = $tools->fetch_assoc()) {
                            echo '<div class="toolsRow input-group mb-1">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Tools</span>
                                    <input type="text" placeholder="Tools atau Software yang sering Anda Gunakan" class="form-control" name="tools[]" value="' . $row['tool'] . '" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    <button type="button" class="removeTool">-</button>
                                    <button type="button" id="addTool" class="text-light bg-primary ms-2 border-0 rounded-end"><i class="fas fa-plus"></i></button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <!-- Bahasa Pemrograman-->
                    <div id="languagesContainer">
                        <?php
                        // Fetch and display existing programming languages
                        $stmt = $db->prepare("SELECT language_prog FROM languages WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
                        $stmt->bind_param("s", $nim);
                        $stmt->execute();
                        $languages = $stmt->get_result();
                        while ($row = $languages->fetch_assoc()) {
                            echo '<div class="languagesRow input-group mb-1">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Bahasa Pemrograman</span>
                                    <input type="text" placeholder="Masukkan Bahasa Pemrograman" class="form-control" name="languages[]" value="' . $row['language_prog'] . '" aria-label="Programming language input" aria-describedby="inputGroup-sizing-default">
                                    <button type="button" class="removeLanguage text-light bg-danger border-0 rounded-end ms-2">-</button>
                                    <button type="button" id="addLanguage" class="text-light bg-primary ms-2 border-0 rounded-end"><i class="fas fa-plus"></i></button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col">
                    <div id="languageContainer">
                        <?php
                        // Fetch and display existing communication languages
                        $stmt = $db->prepare("SELECT language, level FROM communication_languages WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
                        $stmt->bind_param("s", $nim);
                        $stmt->execute();
                        $communication_languages = $stmt->get_result();
                        while ($row = $communication_languages->fetch_assoc()) {
                            echo '<div class="languageRow input-group mb-1">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Bahasa</span>
                                    <input type="text" placeholder="Keahlian Bahasa" class="form-control" name="communication_languages[]" value="' . $row['language'] . '" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                                    <select name="communication_levels[]" class="form-select" required>
                                        <option value="" disabled>Pilih Level</option>
                                        <option value="Beginner" ' . ($row['level'] == 'Beginner' ? 'selected' : '') . '>Beginner</option>
                                        <option value="Intermediate" ' . ($row['level'] == 'Intermediate' ? 'selected' : '') . '>Intermediate</option>
                                        <option value="Advanced" ' . ($row['level'] == 'Advanced' ? 'selected' : '') . '>Advanced</option>
                                    </select>
                                    <button type="button" class="removeLanguageCommunication text-light bg-danger border-0 rounded-end ms-2">-</button>
                                    <button type="button" id="addComLanguage" class="text-light bg-primary ms-2 border-0 rounded-end"><i class="fas fa-plus"></i></button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <hr>
            <br>
            <h3 class="mb-3">Pencapaian</h3>
            <div class="row">
                <div class="col">
                    <!-- pengalaman -->
                    <p>Pengalaman Kerja/Magang:</p>
                    <div id="experienceContainer">
                        <?php
                        // Fetch and display existing experiences
                        $stmt = $db->prepare("SELECT lokasi, deskripsi FROM experience WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
                        $stmt->bind_param("s", $nim);
                        $stmt->execute();
                        $experiences = $stmt->get_result();
                        while ($row = $experiences->fetch_assoc()) {
                            echo '<div class="experienceRow input-group mb-1">
                                    <span class="input-group-text">Pengalaman</span>
                                    <input type="text" class="form-control" name="title-experience[]" placeholder="Tempat/Lokasi - Status(Waktu)" value="' . $row['lokasi'] . '">
                                    <input type="text" class="form-control" name="experience[]" placeholder="Deskripsikan Pekerjaan" value="' . $row['deskripsi'] . '">
                                    <button type="button" class="removeExperience bg-danger text-light ms-1 border-0 rounded-end">-</button>
                                    <button type="button" id="addExperience" class="text-light bg-primary ms-2 border-0 rounded-end"><i class="fas fa-plus"></i></button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div id="projectContainer">
                        <p>Proyek yang pernah dikerjakan:</p>
                        <?php
                        // Fetch and display existing projects
                        $stmt = $db->prepare("SELECT project_thumb, project_link, project_name, description FROM projects WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
                        $stmt->bind_param("s", $nim);
                        $stmt->execute();
                        $projects = $stmt->get_result();
                        while ($row = $projects->fetch_assoc()) {
                            echo '<div class="projectRow input-group mb-1">
                                    <input type="file" class="form-control" name="project_thumbnail[]" accept="image/*" aria-label="Thumbnail">
                                    <input type="url" class="form-control" name="project_link[]" value="' . $row['project_link'] . '" placeholder="Tautan" aria-label="Tautan">
                                    <input type="text" class="form-control" name="project_title[]" value="' . $row['project_name'] . '" placeholder="Judul" aria-label="Judul">
                                    <textarea class="form-control" name="project_description[]" placeholder="Deskripsi" aria-label="Deskripsi">' . $row['description'] . '</textarea>
                                    <button type="button" class="removeProject bg-danger text-light ms-1 border-0 rounded-end">-</button>
                                    <button type="button" id="addProject" class="text-light bg-primary ms-2 border-0 rounded-end"><i class="fas fa-plus"></i></button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div id="certificateContainer">
                        <p>Sertifikat yang dimiliki:</p>
                        <?php
                        // Fetch and display existing certificates
                        $stmt = $db->prepare("SELECT certificate_thumbnail, certificate_link, certificate_description FROM certificates WHERE id_profile = (SELECT id_profile FROM profile WHERE nim = ?)");
                        $stmt->bind_param("s", $nim);
                        $stmt->execute();
                        $certificates = $stmt->get_result();
                        while ($row = $certificates->fetch_assoc()) {
                            echo '<div class="certificateRow input-group mb-1">
                                    <input type="file" class="form-control" name="certificate_thumbnail[]" accept="image/*" aria-label="Thumbnail">
                                    <input type="url" class="form-control" name="certificate_link[]" value="' . $row['certificate_link'] . '" placeholder="Tautan" aria-label="Tautan">
                                    <input type="text" class="form-control" name="certificate_description[]" value="' . $row['certificate_description'] . '" placeholder="Judul atau Keterangan" aria-label="Keterangan">
                                    <button type="button" class="removeCertificate bg-danger text-light ms-1 border-0 rounded-end">-</button>
                                    <button type="button" id="addCertificate" class="text-light bg-primary ms-2 border-0 rounded-end"><i class="fas fa-plus"></i></button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-3" onclick="window.location.href='profile.php';">
                            Kembali ke Profil
                        </button>
                        <button type="submit" name="update" class="btn btn-primary">
                            Perbarui Profil
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php include "layout/footer.html" ?>
    <script src="JS/edit.js"></script>
    <script src="JS/softskill.js"></script>
    <script src="JS/hardskill.js"></script>
    <script src="JS/tools.js"></script>
    <script src="JS/bhs_prog.js"></script>
    <script src="JS/bahasa.js"></script>
    <script src="JS/exp.js"></script>
    <script src="JS/proyek.js"></script>
    <script src="JS/sertifikat.js"></script>
</body>

</html>