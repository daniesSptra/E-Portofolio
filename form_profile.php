<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <style>
        /* styles.css */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-top: 20px;
        }

        form {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        form label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="date"],
        form input[type="file"],
        form textarea,
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        form textarea {
            resize: vertical;
            min-height: 80px;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        form button:hover {
            background-color: #45a049;
        }

        form input[type="file"] {
            border: none;
            padding: 0;
        }

        form input[type="file"]:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Edit Profil</h1>
    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <label for="photo">Foto Profil:</label>
        <input type="file" id="photo" name="photo" accept="image/*"><br>

        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" value="John Doe"><br>

        <label for="dob">Tanggal Lahir:</label>
        <input type="date" id="dob" name="dob" value="1990-01-01"><br>

        <label for="gender">Jenis Kelamin:</label>
        <select id="gender" name="gender">
            <option value="Laki-laki" selected>Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br>

        <label for="address">Alamat:</label>
        <textarea id="address" name="address">Jakarta, Indonesia</textarea><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="john.doe@example.com"><br>

        <label for="phone">Nomor Telepon:</label>
        <input type="text" id="phone" name="phone" value="081234567890"><br>

        <label for="skills">Keterampilan:</label>
        <textarea id="skills" name="skills">Web Development, Data Analysis</textarea><br>

        <label for="experience">Pengalaman:</label>
        <textarea id="experience" name="experience">3 Tahun di bidang IT</textarea><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>

</html>