<?php 

include "service/database.php";
session_start();

if (isset($_POST["simpan"])) {
    $nim = $_SESSION['nim']; 

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $no_telepon = mysqli_real_escape_string($db, $_POST['no_telepon']);
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']);
    $asal_sekolah = mysqli_real_escape_string($db, $_POST['asal_sekolah']);
    $ipk = mysqli_real_escape_string($db, $_POST['ipk']);
    
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
            $stmt = $db->prepare("INSERT INTO profile (nim, email, no_telepon, alamat, asal_sekolah, ipk, foto) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nim, $email, $no_telepon, $alamat, $asal_sekolah, $ipk, $namaBaru);
            if ($stmt->execute()) {
                $id_profile = $stmt->insert_id;

                if (isset($_POST['softskills'])) {
                    $stmt = $db->prepare("INSERT INTO softskills (id_profile, skill) VALUES (?, ?)");
                    foreach ($_POST['softskills'] as $softskill) {
                        $stmt->bind_param("is", $id_profile, $softskill);
                        $stmt->execute();
                    }
                    $stmt->close();
                }

                if (isset($_POST['hardskills'])) {
                    $stmt = $db->prepare("INSERT INTO hardskills (id_profile, skill) VALUES (?, ?)");
                    foreach ($_POST['hardskills'] as $hardSkill) {
                        if (!empty($hardSkill)) {
                            $stmt->bind_param("is", $id_profile, $hardSkill);
                            $stmt->execute();
                        }
                    }
                    $stmt->close();
                }

                if (isset($_POST['tools'])) {
                    $stmt = $db->prepare("INSERT INTO tools (id_profile, tool) VALUES (?, ?)");
                    foreach ($_POST['tools'] as $tool) {
                        $stmt->bind_param("is", $id_profile, $tool);
                        $stmt->execute();
                    }
                    $stmt->close();
                }

                if (isset($_POST['languages'])) {
                    $stmt = $db->prepare("INSERT INTO languages (id_profile, language_prog) VALUES (?, ?)");
                    foreach ($_POST['languages'] as $language) {
                        $stmt->bind_param("is", $id_profile, $language);
                        $stmt->execute();
                    }
                    $stmt->close();
                }

                if (isset($_POST['communication_languages']) && isset($_POST['communication_levels'])) {
                    $stmt = $db->prepare("INSERT INTO communication_languages (id_profile, language, level) VALUES (?, ?, ?)");
                    foreach ($_POST['communication_languages'] as $index => $language) {
                        $level = $_POST['communication_levels'][$index];
                        $stmt->bind_param("iss", $id_profile, $language, $level);
                        $stmt->execute();
                    }
                    $stmt->close();
                }

                if (isset($_POST['title-experience']) && isset($_POST['experience'])) {
                    $stmt = $db->prepare("INSERT INTO experience (id_profile, lokasi, deskripsi) VALUES (?, ?, ?)");
                    foreach ($_POST['title-experience'] as $index => $title) {
                        $experience = $_POST['experience'][$index];
                        $stmt->bind_param("iss", $id_profile, $title, $experience);
                        $stmt->execute();
                    }
                    $stmt->close();
                }

                 if (isset($_FILES['project_thumbnail']) && isset($_POST['project_title']) && isset($_POST['project_link']) && isset($_POST['project_description'])) {
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

                                $stmt->bind_param("issss", $id_profile, $namaBaru, $projectLink, $projectTitle, $projectDescription);
                                $stmt->execute();
                            } else {
                                echo "<script>alert('Gagal mengunggah file.');</script>";
                                exit;
                            }
                        }
                    }
                    $stmt->close();
                }

                if (isset($_FILES['certificate_thumbnail']) && isset($_POST['certificate_description']) && isset($_POST['certificate_link'])) {
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

                                $stmt->bind_param("isss", $id_profile, $namaBaru, $certificateLink, $certificateDescription);
                                $stmt->execute();
                            } else {
                                echo "<script>alert('Gagal mengunggah file.');</script>";
                                exit;
                            }
                        }
                    }
                    $stmt->close();
                }

                echo '<div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Data berhasil disimpan!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
              </div>';
        
                echo "<script>
                        // Menampilkan toast Bootstrap
                        var toast = new bootstrap.Toast(document.getElementById('successToast'));
                        toast.show();
                        
                        // Mengalihkan halaman setelah 2 detik
                        setTimeout(function() {
                            alert('Profil berhasil dibuat! Anda akan dialihkan ke halaman profil.');
                            window.location.href = 'profile.php'; // Redirect ke halaman profil
                        }, 2000);
                    </script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "<script>alert('Gagal mengunggah file.');</script>";
        }
    } else {
        echo "<script>alert('Pilih gambar terlebih dahulu.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Profil</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
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
    <h1 class="text-center mt-3">LENGKAPI PROFIL</h1>
    <div class="main container p-3 my-5 mx-auto shadow-sm border">
        <form action="" method="POST" enctype="multipart/form-data" class="p-5">
            <h3 class="mb-3">Identitas</h3>
            <div class="row justify-content-md-start align-items-center mb-2">
                <div class="col-lg-2">
                    <div class="preview-container">
                        <img id="imagePreview" src="https://via.placeholder.com/150" alt="Preview Gambar"
                            class="preview-image">
                    </div>
                </div>
                <div class="col-lg-auto">
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroup-sizing-default">Upload Foto</span>
                        <input type="file" name="photo" class="form-control" id="photo" accept="image/"
                            aria-describedby="inputGroupFileAddon04">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                        <input type="email" name="email" placeholder="Contoh: emailuser123@gmail.com" class="form-control"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">Nomor Telepon</span>
                        <input type="tel" name="no_telepon" placeholder="No.Telepon/WhatsApp" class="form-control"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">Alamat</span>
                        <textarea class="form-control" name="alamat" placeholder="Tulis Alamat Anda Disini"
                            id="exampleFormControlTextarea1" rows="3"></textarea>
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
                        <input type="text" name="asal_sekolah" placeholder="Asal Sekolah SMA/SMK/MA" class="form-control"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <br>
            </div>

            <div class="row">
                <div class="col">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-default">IPK</span>
                        <input type="number" name="ipk" placeholder="Indeks Prestasi Kumulatif" class="form-control"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" min="0"
                            max="4" step="0.01">
                    </div>
                </div <br>
            </div>
            <hr>
            <br>
            <h3 class="mb-3">Kemampuan</h3>
            <div class="row">
                <div class="col">
                    <!-- Softskill -->
                    <div id="softSkillContainer">
                        <div class="softSkillRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Soft Skill</span>
                            <input type="text" placeholder="Masukkan Kemampuan Anda" class="form-control"
                                name="softskills[]" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default" required>
                            <button type="button" class="removeSoftSkill btn-outline-secondary">-</button>
                            <button type="button" id="addSoftSkill"
                                class=" text-light bg-primary ms-2 border-0 rounded-end"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <!-- Hardskill -->
                    <div id="hardSkillContainer">
                        <div class="hardSkillRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Hard Skill</span>
                            <input type="text" placeholder="Masukkan Kemampuan Anda" class="form-control"
                                name="hardskills[]" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default" required>
                            <button type="button" class="removeHardSkill">-</button>
                            <button type="button" id="addHardSkill"
                                class=" text-light bg-primary ms-2 border-0 rounded-end"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <!-- Tools -->
                    <div id="toolsContainer">
                        <div class="toolsRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tools</span>
                            <input type="text" placeholder="Tools atau Software yang sering Anda Gunakan"
                                class="form-control" name="tools[]" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default">
                            <button type="button" class="removeTool">-</button>
                            <button type="button" id="addTool"
                                class=" text-light bg-primary ms-2 border-0 rounded-end"><i
                                    class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <!-- Bahasa Pemrograman-->
                    <div id="languagesContainer">
                        <div class="languagesRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Bahasa Pemrograman</span>
                            <input type="text" placeholder="Masukkan Bahasa Pemrograman" class="form-control"
                                name="languages[]" aria-label="Programming language input"
                                aria-describedby="inputGroup-sizing-default">
                            <button type="button"
                                class="removeLanguage text-light bg-danger border-0 rounded-end ms-2">-</button>
                            <button type="button" id="addLanguage"
                                class="text-light bg-primary ms-2 border-0 rounded-end">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div id="languageContainer">
                        <div class="languageRow input-group mb-1">
                            <span class="input-group-text" id="inputGroup-sizing-default">Bahasa</span>
                            <input type="text" placeholder="Keahlian Bahasa" class="form-control"
                                name="communication_languages[]" aria-label="Sizing example input"
                                aria-describedby="inputGroup-sizing-default" required>
                            <select name="communication_levels[]" class="form-select" required>
                                <option value="" disabled selected>Pilih Level</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                            <button type="button"
                                class="removeLanguageCommunication text-light bg-danger border-0 rounded-end ms-2">-</button>
                            <button type="button" id="addComLanguage"
                                class="text-light bg-primary ms-2 border-0 rounded-end">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
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
                        <div class="experienceRow input-group mb-1">
                            <span class="input-group-text">Pengalaman</span>
                            <input type="text" class="form-control" name="title-experience[]" placeholder="Tempat/Lokasi - Status(Waktu)">
                            <input type="text" class="form-control" name="experience[]" placeholder="Deskripsikan Pekerjaan">
                            <button type="button"
                                class="removeExperience bg-danger text-light ms-1 border-0 rounded-end">-</button>
                            <button type="button" id="addExperience"
                                class="text-light bg-primary ms-2 border-0 rounded-end">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div id="projectContainer">
                        <p>Proyek yang pernah dikerjakan:</p>
                        <div class="projectRow input-group mb-1">
                            <input type="file" class="form-control" name="project_thumbnail[]" accept="image/*"
                                aria-label="Thumbnail">
                            <input type="url" class="form-control" name="project_link[]" placeholder="Tautan"
                                aria-label="Tautan">
                            <input type="text" class="form-control" name="project_title[]" placeholder="Judul"
                                aria-label="Judul">
                            <textarea class="form-control" name="project_description[]" placeholder="Deskripsi"
                                aria-label="Deskripsi"></textarea>
                            <button type="button"
                                class="removeProject bg-danger text-light ms-1 border-0 rounded-end">-</button>
                            <button type="button" id="addProject"
                                class="text-light bg-primary ms-2 border-0 rounded-end">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div id="certificateContainer">
                        <p>Sertifikat yang dimiliki:</p>
                        <div class="certificateRow input-group mb-1">
                            <input type="file" class="form-control" name="certificate_thumbnail[]" accept="image/*"
                                aria-label="Thumbnail">
                            <input type="url" class="form-control" name="certificate_link[]" placeholder="Tautan"
                                aria-label="Tautan">
                            <input type="text" class="form-control" name="certificate_description[]"
                                placeholder="Judul atau Keterangan" aria-label="Keterangan">
                            <button type="button"
                                class="removeCertificate bg-danger text-light ms-1 border-0 rounded-end">-</button>
                            <button type="button" id="addCertificate"
                                class="text-light bg-primary ms-2 border-0 rounded-end">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-secondary me-3"
                            onclick="window.location.href='profile.php';">
                            Kembali ke Profil
                        </button>
                        <button type="submit" name="simpan" class="btn btn-primary">
                            Simpan Perubahan
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