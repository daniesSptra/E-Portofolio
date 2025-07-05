<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar File Download</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <?php include "layout/navigasi.html"; ?>
    <div class="container mt-5" style="margin-top: 2rem;">
        <h1 class="text-center mt-5">Daftar File yang Dapat Diunduh</h1>
        <div class="row mt-5 mb-5">
            <div class="col-md-6 offset-md-3">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Standard College - CV</td>
                            <td>
                                <a target="_blank" class="btn btn-primary ms-5"  onclick="printFile()">Download PDF</a>
                                <iframe id="printFrame" style="display:none;" src="template/template-cv.php"></iframe>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include "layout/footer.html"; ?>
    <script>
        function printFile() {
            var iframe = document.getElementById('printFrame');
            iframe.contentWindow.print(); // Call print on iframe's content
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
