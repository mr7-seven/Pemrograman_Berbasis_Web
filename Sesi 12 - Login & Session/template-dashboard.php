<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <link href="assets/css/led.css" rel="stylesheet">
    <link href="assets/icons/bootstrap-icons.min.css" rel="stylesheet">
    <title>DASHBOARD</title>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h4>
            <i class="bi bi-cpu"></i>
            TROM
        </h4>

        <hr>

        <p>
            <strong><?= $username; ?></strong><br>
            <small><?= strtoupper($role); ?></small>
        </p>

        <a href="#">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <?php if ($role == 'admin'): ?>

            <a href="#">
                <i class="bi bi-database"></i>
                CRUD Sensor
            </a>

            <a href="#">
                <i class="bi bi-people"></i>
                Manajemen User
            </a>

        <?php endif; ?>

        <?php if ($role == 'operator'): ?>

            <a href="#">
                <i class="bi bi-activity"></i>
                Monitoring Sistem
            </a>

        <?php endif; ?>

        <?php if ($role == 'teknisi'): ?>

            <a href="#">
                <i class="bi bi-tools"></i>
                Maintenance
            </a>

            <a href="#">
                <i class="bi bi-toggle-on"></i>
                Kontrol Device
            </a>

        <?php endif; ?>

        <hr>

        <a href="logout.php">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </a>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3>Dashboard</h3>
                <div class="status-box">
                    Sistem Pemantauan
                </div>
            </div>

            <div>
                <span class="badge text-bg-success px-3 py-2">
                    System Online
                </span>
            </div>
        </div>

        <!-- SENSOR CARD -->
        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card card-industrial p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="status-box">Tegangan</div>
                            <div class="sensor-value">220 V</div>
                        </div>

                        <i class="bi bi-lightning-charge fs-1 text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-industrial p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="status-box">Arus</div>
                            <div class="sensor-value">1.2 A</div>
                        </div>

                        <i class="bi bi-activity fs-1 text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-industrial p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="status-box">Daya</div>
                            <div class="sensor-value">264 W</div>
                        </div>

                        <i class="bi bi-cpu fs-1 text-success"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- ADMIN -->
        <?php if ($role == 'admin'): ?>

            <div class="card card-industrial p-4 mb-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>
                        <i class="bi bi-database"></i>
                        Data Sensor
                    </h5>

                    <button class="btn btn-dark btn-sm">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Data
                    </button>
                </div>

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tegangan</th>
                            <th>Arus</th>
                            <th>Daya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>220</td>
                            <td>1.2</td>
                            <td>264</td>
                            <td>
                                <button class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        <?php endif; ?>

        <!-- OPERATOR -->
        <?php if ($role == 'operator'): ?>

            <div class="card card-industrial p-4 mb-4">

                <h5>
                    <i class="bi bi-broadcast"></i>
                    Monitoring Sistem
                </h5>

                <hr>

                <div class="row text-center">

                    <div class="col-md-4">
                        <h6>Status Mesin</h6>
                        <span class="badge text-bg-success">RUNNING</span>
                    </div>

                    <div class="col-md-4">
                        <h6>Suhu Panel</h6>
                        <div class="sensor-value">35°C</div>
                    </div>

                    <div class="col-md-4">
                        <h6>Koneksi Jaringan</h6>
                        <span class="badge text-bg-success">CONNECTED</span>
                    </div>

                </div>

            </div>

        <?php endif; ?>


        <!-- TEKNISI -->
        <?php if ($role == 'teknisi'): ?>
            <!-- STATUS PERANGKAT -->
            <div class="card card-industrial p-4 mb-4">

                <h5 class="mb-4">
                    <i class="bi bi-cpu"></i>
                    Status Perangkat
                </h5>

                <div class="row g-4">

                    <!-- MOTOR -->
                    <div class="col-md-4">

                        <div class="border rounded-4 p-3 bg-light">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <h6 class="mb-1">Motor Conveyor</h6>
                                    <small class="text-muted">
                                        Status Motor Utama
                                    </small>
                                </div>

                                <div class="led led-green"></div>

                            </div>

                        </div>

                    </div>

                    <!-- POMPA -->
                    <div class="col-md-4">

                        <div class="border rounded-4 p-3 bg-light">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <h6 class="mb-1">Pompa 1</h6>
                                    <small class="text-muted">
                                        Status Pompa
                                    </small>
                                </div>

                                <div class="led led-red"></div>

                            </div>

                        </div>

                    </div>

                    <!-- MQTT -->
                    <div class="col-md-4">

                        <div class="border rounded-4 p-3 bg-light">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <h6 class="mb-1">Pompa 2</h6>
                                    <small class="text-muted">
                                        Status Pompa
                                    </small>
                                </div>

                                <div class="led led-green"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card card-industrial p-4 mb-4">

                <div class="d-flex justify-content-between align-items-center">

                    <h5>
                        <i class="bi bi-tools"></i>
                        Kontrol Perangkat
                    </h5>

                    <!-- PANEL STATUS -->
                    <div class="d-flex align-items-center gap-3 flex-wrap">

                        <div class="d-flex align-items-center gap-2">
                            <div class="led led-green"></div>
                            <small>Machine RUNNING</small>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <div class="led led-yellow"></div>
                            <small>Maintenance</small>
                        </div>

                    </div>

                </div>

                <hr>

                <!-- CONTROL BUTTON -->
                <div class="d-flex gap-3 flex-wrap">

                    <button class="btn btn-success device-btn">
                        <i class="bi bi-toggle-on"></i>
                        Device ON
                    </button>

                    <button class="btn btn-danger device-btn">
                        <i class="bi bi-toggle-off"></i>
                        Device OFF
                    </button>

                    <button class="btn btn-warning device-btn">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </button>

                </div>

            </div>

        <?php endif; ?>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>