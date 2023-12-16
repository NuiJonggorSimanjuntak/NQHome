<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NQHome</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="hold-transition login-page">

    <?= $this->renderSection('content'); ?>

    <script src="<?= base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="<?= base_url(); ?>/dist/js/demo.js"></script> -->
    <!-- <script src="<?= base_url(); ?>/plugins/chart.js/Chart.min.js"></script> -->
    <script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>

    <script>
        var jenjangSelect = document.getElementById('id_kelas');
        var kelasSelect = document.getElementById('kelas');

        jenjangSelect.addEventListener('change', function() {
            var selectedJenjang = jenjangSelect.value;
            updateKelasOptions(selectedJenjang);
        });

        function updateKelasOptions(selectedJenjang) {
            kelasSelect.innerHTML = '';

            if (selectedJenjang === "1") {
                var sdKelas = ['1', '2', '3', '4', '5', '6'];
                sdKelas.forEach(function(kelas) {
                    var option = document.createElement('option');
                    option.value = kelas;
                    option.text = 'Kelas ' + kelas;
                    kelasSelect.appendChild(option);
                });
            } else if (selectedJenjang === "2") {
                var smpKelas = ['7', '8', '9'];
                smpKelas.forEach(function(kelas) {
                    var option = document.createElement('option');
                    option.value = kelas;
                    option.text = 'Kelas ' + kelas;
                    kelasSelect.appendChild(option);
                });
            } else if (selectedJenjang === "3") {
                var smaKelas = ['10', '11', '12'];
                smaKelas.forEach(function(kelas) {
                    var option = document.createElement('option');
                    option.value = kelas;
                    option.text = 'Kelas ' + kelas;
                    kelasSelect.appendChild(option);
                });
            }
        }
    </script>

    <script>
        function priviewImg() {
            const image = document.querySelector('#image');
            const label = document.querySelector('.custom-file-label');
            const imgPriview = document.querySelector('.img-priview');

            label.textContent = image.files[0].name; // Mengatur teks dalam label

            const fileImage = new FileReader();
            fileImage.readAsDataURL(image.files[0]);

            fileImage.onload = function(e) {
                imgPriview.src = e.target.result;
            }
        }
    </script>
</body>

</html>