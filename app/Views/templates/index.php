<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NQHome</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url('plugins/fontawesome-free/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="<?= base_url('kalender/app.css'); ?>">

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?= $this->include('templates/navbar'); ?>
        <!-- End navbar -->

        <!-- Sidebar -->
        <?= $this->include('templates/sidebar'); ?>
        <!-- End sidebar -->

        <?= $this->renderSection('page-content'); ?>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; <?= date('Y'); ?> <a href="<?= base_url(''); ?>">NQHome</a></strong>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>


    <script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
    <script src="<?= base_url('plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('dist/js/adminlte.min.js'); ?>"></script>
    <!-- <script src="<?= base_url('dist/js/demo.js'); ?>"></script> -->
    <script src="<?= base_url('plugins/chart.js/Chart.min.js'); ?>"></script>
    <script src="<?= base_url('plugins/flot/jquery.flot.js'); ?>"></script>
    <script src="<?= base_url('kalender/app.js'); ?>"></script>

    <script>
        function startScanning() {
            const codeReader = new ZXing.BrowserMultiFormatReader();

            const videoElement = document.getElementById('previewKamera');

            const hasilScanElement = document.getElementById('hasilscan');

            const pilihKameraElement = document.getElementById('pilihKamera');

            codeReader.listVideoInputDevices()
                .then((videoInputDevices) => {
                    videoInputDevices.forEach((device, index) => {
                        const option = document.createElement('option');
                        option.value = device.deviceId;
                        option.text = device.label;
                        pilihKameraElement.appendChild(option);
                    });

                    if (videoInputDevices.length > 0) {
                        const selectedDeviceId = pilihKameraElement.value;

                        codeReader.decodeFromVideoDevice(selectedDeviceId, videoElement, (result, err) => {
                            if (result) {
                                hasilScanElement.value = result.text;
                                window.location.href = hasilScanElement.value;
                            }
                            if (err && !(err instanceof ZXing.NotFoundException)) {
                                console.error('Error saat mengakses kamera: ', err);
                            }
                        });
                    } else {
                        alert('Tidak ada perangkat kamera yang tersedia.');
                    }
                })
                .catch((err) => {
                    console.error('Error saat mengakses perangkat kamera: ', err);
                });
        }

        $(document).ready(() => {
            setTimeout(() => {
                startScanning();
            }, 3000);
        });
    </script>

    <script>
        $('.custom-file-input').on('change', function() {
            let filename = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(filename);
        });

        $('.form-check-input').on('click', function() {
            const menuId = $(this).data('group_id');
            const roleId = $(this).data('permission_id');

            $.ajax({
                url: "<?= base_url('admin/changeaccess'); ?>",
                type: 'post',
                data: {
                    groupId: roleId,
                    permissionId: menuId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
                }
            });
        });
    </script>

    <script>
        var jenjangSelect = document.getElementById('tingkat');
        var kelasSelect = document.getElementById('kls');

        jenjangSelect.addEventListener('change', function() {
            var selectedJenjang = jenjangSelect.value;
            updateKelasOptions(selectedJenjang);
        });

        function updateKelasOptions(selectedJenjang) {
            kelasSelect.innerHTML = '';

            if (selectedJenjang === "SD") {
                var sdKelas = ['1', '2', '3', '4', '5', '6'];
                sdKelas.forEach(function(kelas) {
                    var option = document.createElement('option');
                    option.value = kelas;
                    option.text = 'Kelas ' + kelas;
                    kelasSelect.appendChild(option);
                });
            } else if (selectedJenjang === "SMP") {
                var smpKelas = ['7', '8', '9'];
                smpKelas.forEach(function(kelas) {
                    var option = document.createElement('option');
                    option.value = kelas;
                    option.text = 'Kelas ' + kelas;
                    kelasSelect.appendChild(option);
                });
            } else if (selectedJenjang === "SMA") {
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
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordInput = document.getElementById("password");
            var toggleButton = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = "password";
                toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var resetMp = document.getElementById("resetMp");
            var resetButton = resetMp.querySelector(".reset-button");

            resetButton.addEventListener("click", function(event) {
                event.preventDefault();
                resetMp.reset();
            });
        });
    </script>

    <script>
        function priviewImg() {
            const image = document.querySelector('#image');
            const label = document.querySelector('.custom-file-label');
            const imgPriview = document.querySelector('.img-priview');

            image.textContent = image.files[0].name;

            const fileImage = new FileReader();
            fileImage.readAsDataURL(image.files[0]);

            fileImage.onload = function(e) {
                imgPriview.src = e.target.result;
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('filterSelect');
            const dataBody = document.getElementById('dataBody');

            filterSelect.addEventListener('change', function() {
                const selectedValue = filterSelect.value;
                fetchData(selectedValue);
            });

            function fetchData(selectedValue) {
                fetch(`url_to_your_controller?action=filter&value=${selectedValue}`)
                    .then(response => response.json())
                    .then(data => {
                        updateTable(data);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }

            function updateTable(data) {
                dataBody.innerHTML = ''; // Menghapus data yang ada sebelumnya
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${item.id}</td>
                <td>${item.tahun_ajaran}</td>
                <td>${item.semester}</td>
                <!-- Tambahkan kolom lainnya sesuai kebutuhan -->
            `;
                    dataBody.appendChild(row);
                });
            }
        });
    </script>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            var role = this.value;
            if (role === 'guru') {
                document.getElementById('santriInput').style.display = 'none';
                document.getElementById('guruInput').style.display = 'block';
            } else if (role === 'santri') {
                document.getElementById('guruInput').style.display = 'none';
                document.getElementById('santriInput').style.display = 'block';
            } else {
                document.getElementById('santriInput').style.display = 'none';
                document.getElementById('guruInput').style.display = 'none';
            }
        });
    </script>

    <!-- <script>
        const saveButton = document.getElementById("save-button-guru");

        saveButton.addEventListener("click", function() {
            const year = document.getElementById("year").textContent;
            const month = document.getElementById("month-picker").textContent;

            const calendarDays = document.querySelectorAll(".calendar-days div");

            const datesToDisplay = [];

            calendarDays.forEach(function(day, index) {
                const dayNumber = index + 1;
                const isDateValid = validateDate(year, month, dayNumber);

                if (isDateValid) {
                    const date = `${year}-${padNumber(monthToNumber(month))}-${padNumber(dayNumber)}`;
                    datesToDisplay.push(date);
                }
            });

            document.getElementById("dates-input").value = JSON.stringify(datesToDisplay);
        });

        function monthToNumber(monthName) {
            const months = [
                "Januari", 'Februari', "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            return months.indexOf(monthName) + 1;
        }

        function padNumber(number) {
            return number < 10 ? `0${number}` : number;
        }

        function validateDate(year, month, day) {
            const daysInMonth = new Date(year, monthToNumber(month), 0).getDate();

            return Number.isInteger(day) && day >= 1 && day <= daysInMonth;
        }
    </script> -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saveButtonGuru = document.getElementById("save-button-guru");

            saveButtonGuru.addEventListener("click", function(event) {
                event.preventDefault();

                const year = document.getElementById("year").textContent;
                const month = document.getElementById("month-picker").textContent;

                const calendarDays = document.querySelectorAll(".calendar-days div");

                const datesToDisplay = [];

                calendarDays.forEach(function(day, index) {
                    const dayNumber = index + 1;
                    const isDateValid = validateDate(year, month, dayNumber);

                    if (isDateValid) {
                        const date = `${year}-${padNumber(monthToNumber(month))}-${padNumber(dayNumber)}`;
                        datesToDisplay.push(date);
                    }
                });

                const datesInput = document.getElementById("dates-input-guru");
                datesInput.value = JSON.stringify(datesToDisplay);

                const guruForm = document.getElementById("guru-form");
                guruForm.submit();
            });

            function monthToNumber(monthName) {
                const months = [
                    "Januari", 'Februari', "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                return months.indexOf(monthName) + 1;
            }

            function padNumber(number) {
                return number < 10 ? `0${number}` : number;
            }

            function validateDate(year, month, day) {
                const daysInMonth = new Date(year, monthToNumber(month), 0).getDate();

                return Number.isInteger(day) && day >= 1 && day <= daysInMonth;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saveButtonSantri = document.getElementById("save-button-santri");

            saveButtonSantri.addEventListener("click", function(event) {
                event.preventDefault();

                const year = document.getElementById("year").textContent;
                const month = document.getElementById("month-picker").textContent;

                const calendarDays = document.querySelectorAll(".calendar-days div");

                const datesToDisplay = [];

                calendarDays.forEach(function(day, index) {
                    const dayNumber = index + 1;
                    const isDateValid = validateDate(year, month, dayNumber);

                    if (isDateValid) {
                        const date = `${year}-${padNumber(monthToNumber(month))}-${padNumber(dayNumber)}`;
                        datesToDisplay.push(date);
                    }
                });

                const datesInput = document.getElementById("dates-input-santri");
                datesInput.value = JSON.stringify(datesToDisplay);

                const santriForm = document.getElementById("santri-form");
                santriForm.submit();
            });

            function monthToNumber(monthName) {
                const months = [
                    "Januari", 'Februari', "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                return months.indexOf(monthName) + 1;
            }

            function padNumber(number) {
                return number < 10 ? `0${number}` : number;
            }

            function validateDate(year, month, day) {
                const daysInMonth = new Date(year, monthToNumber(month), 0).getDate();

                return Number.isInteger(day) && day >= 1 && day <= daysInMonth;
            }
        });
    </script>
</body>

</html>