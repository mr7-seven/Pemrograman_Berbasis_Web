<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/icons/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <link href="assets/css/led.css" rel="stylesheet">
    <link href="assets/css/datatables.min.css" rel="stylesheet">
    <link href="assets/dist/leaflet.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/img/favicon-96x96.png">
    <title>PEMROGRAMAN BERBASIS WEB</title>
    <style>
        .card-panel {

            border: none;

            border-radius: 14px;

            background: white;

            box-shadow:
                0 4px 12px rgba(0, 0, 0, 0.06);

        }

        .panel-title {

            font-size: 13px;

            font-weight: 600;

            color: #6b7280;

            letter-spacing: 1px;

        }

        .switch {

            position: relative;

            width: 64px;
            height: 32px;

        }

        .switch input {
            display: none;
        }

        .slider-switch {

            position: absolute;

            inset: 0;

            cursor: pointer;

            background: #d1d5db;

            border-radius: 30px;

            transition: 0.3s;

        }

        .slider-switch::before {

            content: '';

            position: absolute;

            width: 24px;
            height: 24px;

            left: 4px;
            top: 4px;

            border-radius: 50%;

            background: white;

            transition: 0.3s;

        }

        .switch input:checked+.slider-switch {

            background: #16a34a;

        }

        .switch input:checked+.slider-switch::before {

            transform: translateX(32px);

        }

        .status-text {

            font-size: 14px;

            font-weight: 600;

            letter-spacing: 1px;

        }

        textarea {

            resize: none;

            min-height: 120px;

        }

        .btn-industrial {

            height: 44px;

            font-weight: 600;

            letter-spacing: 0.5px;

        }
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar">

        <h4>
            <img src="assets/img/poliban.png" class="rounded" alt="foto mhs" width="50">
            TROM
        </h4>

        <hr>

        <p>
            <span class="badge rounded-pill text-bg-primary"><?= strtoupper($role); ?></span>
        </p>
        <div class="text-center">
            <img src="assets/img/<?= $_SESSION['foto']; ?>" class="rounded mx-auto d-block mb-2" alt="foto mhs" width="100">
            <h5>Nama Anda</h5>
            <p class="mb-1">NIM: 12345678</p>
            <p>Kelas: ...</p>
        </div>

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
        <div id="app1">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3>Dashboard</h3>
                    <div class="status-box">
                        SISTEM PEMANTAUAN DAN KENDALI BERBASIS IOT
                    </div>
                </div>

                <div>
                    <button
                        class="btn btn-success"
                        @click="showMap">

                        <i class="bi bi-geo-alt"></i>
                        Tampil Map

                    </button>

                </div>
            </div>

            <!-- MONITORING KWH METER -->

            <div class="row justify-content-center mb-4">

                <div class="col-md">

                    <div class="card card-panel">

                        <div class="card-header bg-transparent border-0 panel-title">
                            <i class="bi bi-database"></i> DATA KWH METER
                        </div>

                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-3">

                                <span>Status REST API</span>

                                <span
                                    class="badge"
                                    :class="apiStatusClass">
                                    {{ apiStatus }}
                                </span>

                            </div>

                            <div class="row g-3">

                                <div class="col-6">

                                    <div
                                        class="border rounded p-3"
                                        style="cursor:pointer"
                                        @click="showChart('tegangan')">

                                        <div
                                            class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <div class="text-secondary small">
                                                    Tegangan
                                                </div>

                                                <div class="fs-4 fw-semibold">
                                                    {{ meter.tegangan ?? '-' }} V
                                                </div>

                                            </div>

                                            <i class="bi bi-lightning-charge fs-1 text-warning"></i>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div
                                        class="border rounded p-3"
                                        style="cursor:pointer"
                                        @click="showChart('arus')">

                                        <div
                                            class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <div class="text-secondary small">
                                                    Arus
                                                </div>

                                                <div class="fs-4 fw-semibold">
                                                    {{ meter.arus ?? '-' }} A
                                                </div>

                                            </div>

                                            <i class="bi bi-lightning-charge fs-1 text-warning"></i>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div
                                        class="border rounded p-3"
                                        style="cursor:pointer"
                                        @click="showChart('daya')">

                                        <div
                                            class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <div class="text-secondary small">
                                                    Daya
                                                </div>

                                                <div class="fs-4 fw-semibold">
                                                    {{ meter.daya ?? '-' }} W
                                                </div>

                                            </div>

                                            <i class="bi bi-lightning-charge fs-1 text-warning"></i>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div
                                        class="border rounded p-3"
                                        style="cursor:pointer"
                                        @click="showChart('frekuensi')">

                                        <div
                                            class="d-flex justify-content-between align-items-center">

                                            <div>

                                                <div class="text-secondary small">
                                                    Frekuensi
                                                </div>

                                                <div class="fs-4 fw-semibold">
                                                    {{ meter.frekuensi ?? '-' }} Hz
                                                </div>

                                            </div>

                                            <i class="bi bi-lightning-charge fs-1 text-warning"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
            <?php include 'components/modal-plot.php'; ?>
        </div>
        <!-- ADMIN -->
        <?php if ($role == 'admin'): ?>

            <div class="card card-industrial p-4 mb-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>
                        <i class="bi bi-database"></i>
                        Data Sensor
                    </h5>

                    <button class="btn btn-primary" id="btnTambah">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Data
                    </button>
                </div>

                <table class="table align-middle" id="myTable">

                </table>

            </div>

        <?php endif; ?>

        <div id="app2">
            <!-- OPERATOR -->
            <?php if ($role == 'operator'): ?>


                <!-- FORM PESAN -->

                <div class="row justify-content-center mt-4">

                    <div class="col-md">

                        <div class="card card-panel">

                            <div class="card-header bg-transparent border-0 panel-title">
                                <i class="bi bi-chat-left"></i> KIRIM PESAN KE REST API
                            </div>

                            <div class="card-body">

                                <form @submit.prevent="kirimPesan">

                                    <div class="mb-3">

                                        <div class="text-end small text-secondary mb-1">
                                            {{ pesan.length }} / 100
                                        </div>

                                        <textarea class="form-control" maxlength="100" v-model="pesan" required
                                            placeholder="Tulis pesan..."></textarea>

                                    </div>

                                    <button class="btn btn-dark btn-industrial" :disabled="loading">

                                        <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>

                                        <template v-if="loading">

                                            Mengirim...

                                        </template>

                                        <template v-else>

                                            <i class="bi bi-send me-2"></i>

                                            Kirim Pesan

                                        </template>

                                    </button>

                                </form>

                            </div>

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
                    <div class="d-flex justify-content-around align-items-center gap-3 flex-wrap">

                        <!-- PANEL CONTROL -->

                        <div class="row justify-content-center g-3 mt-4">

                            <div class="col-md">

                                <div class="card card-panel">

                                    <div class="card-header bg-transparent border-0 text-center panel-title">
                                        <i class="bi bi-toggle-on"></i> KONTAKTOR 1
                                    </div>

                                    <div class="card-body text-center">

                                        <label class="switch">

                                            <input type="checkbox" v-model="kontaktor1" @change="toggleKontaktor(1, kontaktor1)">

                                            <span class="slider-switch"></span>

                                        </label>

                                        <div class="status-text mt-3" :class="kontaktor1 ? 'text-success' : 'text-secondary'">
                                            {{ kontaktor1 ? 'ON' : 'OFF' }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md">

                                <div class="card card-panel">

                                    <div class="card-header bg-transparent border-0 text-center panel-title">
                                        <i class="bi bi-toggle-on"></i> KONTAKTOR 2
                                    </div>

                                    <div class="card-body text-center">

                                        <label class="switch">

                                            <input type="checkbox" v-model="kontaktor2" @change="toggleKontaktor(2, kontaktor2)">

                                            <span class="slider-switch"></span>

                                        </label>

                                        <div class="status-text mt-3" :class="kontaktor2 ? 'text-success' : 'text-secondary'">
                                            {{ kontaktor2 ? 'ON' : 'OFF' }}
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="col-md">

                                <div class="card card-panel">

                                    <div class="card-header bg-transparent border-0 text-center panel-title">
                                        <i class="bi bi-toggle-on"></i> KONTAKTOR 3
                                    </div>

                                    <div class="card-body text-center">

                                        <label class="switch">

                                            <input type="checkbox" v-model="kontaktor2" @change="toggleKontaktor(3, kontaktor3)">

                                            <span class="slider-switch"></span>

                                        </label>

                                        <div class="status-text mt-3" :class="kontaktor3 ? 'text-success' : 'text-secondary'">
                                            {{ kontaktor3 ? 'ON' : 'OFF' }}
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="col-md">

                                <div class="card card-panel">

                                    <div class="card-header bg-transparent border-0 text-center panel-title">
                                        <i class="bi bi-toggle-on"></i> KONTAKTOR 4
                                    </div>

                                    <div class="card-body text-center">

                                        <label class="switch">

                                            <input type="checkbox" v-model="kontaktor4" @change="toggleKontaktor(4, kontaktor4)">

                                            <span class="slider-switch"></span>

                                        </label>

                                        <div class="status-text mt-3" :class="kontaktor4 ? 'text-success' : 'text-secondary'">
                                            {{ kontaktor4 ? 'ON' : 'OFF' }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>
        </div>
    </div>

    <?php include 'components/modal-data.php'; ?>
    <?php include 'components/modal-map.php'; ?>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sweetalert2.js"></script>
    <script src="assets/js/vue.global.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/plotly-3.4.0.min.js"></script>
    <script src="assets/dist/leaflet.js"></script>


    <script>
        const table = new DataTable('#myTable', {
            processing: true,
            serverSide: true,
            pageLength: 5, // 5 data per halaman
            order: [
                [0, 'desc']
            ], // kolom ID (index 0) descending
            ajax: {
                url: 'get_data_server.php'
            },
            columns: [{
                    title: 'ID',
                    data: 'id'
                },
                {
                    title: 'Tegangan',
                    data: 'tegangan'
                },
                {
                    title: 'Arus',
                    data: 'arus'
                },
                {
                    title: 'Daya',
                    data: 'daya',
                    render: data => {
                        const status = data > 300 ?
                            'text-bg-danger' :
                            'text-bg-success';

                        return `<span class="badge ${status}">${data}</span>`;
                    }
                },
                {
                    title: 'Frekuensi',
                    data: 'frekuensi'
                },
                {
                    title: 'Waktu',
                    data: 'waktu'
                },
                {
                    title: 'Aksi',
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => `
                            <button
                                class="btn btn-warning btn-edit"
                                data-id="${row.id}"
                                data-tegangan="${row.tegangan}"
                                data-arus="${row.arus}"
                                data-frekuensi="${row.frekuensi}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>

                            <button
                                class="btn btn-danger btn-delete"
                                data-id="${row.id}">
                                <i class="bi bi-trash3"></i> Hapus
                            </button>`
                }
            ]
        });
    </script>
    <script>
        const formData = document.getElementById('formData');
        const btnTambah = document.getElementById('btnTambah');
        let currentId = null;
        const idInput =
            document.getElementById('id');

        const teganganInput =
            document.getElementById('tegangan');

        const arusInput =
            document.getElementById('arus');

        const dayaInput =
            document.getElementById('daya');

        const frekuensiInput =
            document.getElementById('frekuensi');

        const hitungDaya = () => {

            const v =
                parseFloat(teganganInput.value) || 0;

            const i =
                parseFloat(arusInput.value) || 0;

            dayaInput.value = (v * i).toFixed(2);
        };
        teganganInput.addEventListener(
            'input',
            hitungDaya
        );

        arusInput.addEventListener(
            'input',
            hitungDaya
        );

        // frekuensiInput.addEventListener('input', () => {
        //     frekuensiInput.value;
        // });

        const modalTitle =
            document.getElementById('modalTitle');

        const modal = new bootstrap.Modal(
            document.getElementById('dataModal')
        );


        btnTambah.addEventListener('click', () => {
            currentId = null;
            idInput.value = '';
            formData.reset();
            id.value = '';
            modal.show();
        });

        document.addEventListener('click', async (e) => {

            const editBtn = e.target.closest('.btn-edit');

            if (editBtn) {

                currentId = editBtn.dataset.id;
                idInput.value = currentId;

                teganganInput.value =
                    editBtn.dataset.tegangan;

                arusInput.value =
                    editBtn.dataset.arus;

                frekuensiInput.value = editBtn.dataset.frekuensi || "";

                hitungDaya();

                modalTitle.textContent =
                    'Edit Data';

                modal.show();

                return;
            }

            const deleteBtn =
                e.target.closest('.btn-delete');

            if (!deleteBtn) return;

            const result = await Swal.fire({
                title: 'Yakin ingin menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: 'Ya'
            });

            if (!result.isConfirmed) return;

            try {

                const response = await fetch(
                    'delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: deleteBtn.dataset.id
                        })
                    }
                );

                const data =
                    await response.json();

                await Swal.fire({
                    icon: 'success',
                    title: data.message
                });

                table.ajax.reload(
                    null,
                    false
                );

            } catch (error) {

                Swal.fire({
                    icon: 'error',
                    title: error.message
                });

            }
        });

        formData.addEventListener('submit', async (e) => {

            e.preventDefault();

            try {

                const payload = {
                    id: currentId,
                    tegangan: parseFloat(teganganInput.value),
                    arus: parseFloat(arusInput.value),
                    frekuensi: parseFloat(frekuensiInput.value)
                };

                const url = currentId ?
                    'update.php' :
                    'insert.php';

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(
                        result.message ||
                        'Gagal menyimpan data'
                    );
                }

                await Swal.fire({
                    icon: 'success',
                    title: result.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                formData.reset();

                currentId = null;

                dayaInput.value = '';

                modal.hide();

                table.ajax.reload(
                    null,
                    false
                );

            } catch (error) {

                Swal.fire({
                    icon: 'error',
                    title: error.message
                });

            }
        });
    </script>

    <script>
        /*  async function getData() {
            try {
                const response = await fetch('data.php');
                const data = await response.json();

                return data;

            } catch (error) {
                console.error("Error:" + error);
                return [];
            }
        }

        async function plot_tegangan() {
            const data = await getData();

            const waktu = data.map(item => item.waktu);
            const tegangan = data.map(item => item.tegangan);

            let trace_tegangan = {
                x: waktu,
                y: tegangan,
                mode: "lines",
                line: {
                    shape: "spline",
                    color: "yellow"
                }
            };

            let layout_tegangan = {
                title: {
                    text: "Tegangan"
                },
                xaxis: {
                    title: {
                        text: 'Waktu (s)'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Tegangan (V)'
                    }
                }
            };
            const grafik_tegangan = document.getElementById('grafik_tegangan');
            Plotly.newPlot(grafik_tegangan, [trace_tegangan], layout_tegangan);
        }
        async function plot_arus() {
            const data = await getData();

            const waktu = data.map(item => item.waktu);
            const arus = data.map(item => item.arus);

            let trace_arus = {
                x: waktu,
                y: arus,
                mode: "lines",
                line: {
                    shape: "spline",
                    color: "red"
                }
            };

            let layout_arus = {
                title: {
                    text: "arus"
                },
                xaxis: {
                    title: {
                        text: 'Waktu (s)'
                    }
                },
                yaxis: {
                    title: {
                        text: 'arus (V)'
                    }
                }
            };
            const grafik_arus = document.getElementById('grafik_arus');
            Plotly.newPlot(grafik_arus, [trace_arus], layout_arus);
        }

        plot_tegangan();
        plot_arus(); */
    </script>
    <script>
        const {
            createApp,
            onMounted
        } = Vue

        const app1 = createApp({

            data() {

                return {
                    meter: {},

                    apiStatus: '-',

                    apiStatusClass: 'text-bg-secondary',

                    kontaktor1: false,
                    kontaktor2: false,
                    kontaktor3: false,
                    kontaktor4: false,

                    pesan: '',

                    loading: false,

                    map: null,
                    modalMap: null,

                    selectedParameter: '',
                    chartModal: null

                }

            },

            methods: {
                initMap() {

                    if (this.map) return

                    this.map = L.map('map').setView(
                        [-3.295708, 114.582116],
                        18
                    )

                    L.tileLayer(
                        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap'
                        }
                    ).addTo(this.map)

                    L.marker(
                            [-3.295708, 114.582116]
                        )
                        .addTo(this.map)
                        .bindPopup('Poliban')
                        .openPopup()
                },

                showMap() {

                    this.modalMap.show()

                },

                async getMeterData() {

                    try {

                        const response = await fetch(
                            'get_data.php'
                        )

                        if (!response.ok) {
                            throw new Error(
                                'Gagal mengambil data'
                            )
                        }

                        const result = await response.json()

                        this.meter = result[0]

                        this.apiStatus = 'Connected'

                        this.apiStatusClass =
                            'text-bg-success'

                    } catch (error) {

                        this.apiStatus = 'Disconnected'

                        this.apiStatusClass =
                            'text-bg-danger'

                    }

                },

                async showChart(parameter) {

                    this.selectedParameter = parameter

                    this.chartModal.show()

                    try {

                        const response =
                            await fetch(
                                `get_plot.php?parameter=${parameter}`
                            )

                        const data =
                            await response.json()

                        Plotly.react(
                            'plotContainer',
                            [{
                                x: data.map(item => item.waktu),
                                y: data.map(item => item.nilai),
                                mode: 'lines+markers',
                                name: parameter
                            }], {
                                title: `Grafik ${parameter}`,
                                responsive: true
                            }
                        )

                    } catch (error) {

                        console.error(error)

                    }

                }

                // async toggleKontaktor(channel, value) {

                //     try {

                //         const response = await fetch(
                //             `https://simultaneously-alpha-morris-prisoners.trycloudflare.com/api/v1/kontaktor/Lampu/${channel}`, {

                //                 method: 'PUT',

                //                 headers: {
                //                     'Content-Type': 'application/json'
                //                 },

                //                 body: JSON.stringify({
                //                     value
                //                 })

                //             }
                //         )

                //         if (!response.ok) {
                //             throw new Error()
                //         }

                //         Swal.fire({

                //             icon: value ?
                //                 'success' : 'warning',

                //             title: value ?
                //                 `Kontaktor ${channel} ON` : `Kontaktor ${channel} OFF`,

                //             text: value ?
                //                 'Kontaktor berhasil diaktifkan' : 'Kontaktor berhasil dimatikan',

                //             timer: 2000,

                //             showConfirmButton: false

                //         })

                //     } catch (error) {

                //         Swal.fire({

                //             icon: 'error',

                //             title: 'Gagal',

                //             text: 'Tidak dapat terhubung ke server'

                //         })

                //     }

                // },

                //     async kirimPesan() {

                //         this.loading = true

                //         try {

                //             const response = await fetch(
                //                 'http://localhost:3000/api/v1/pesan', {

                //                     method: 'POST',

                //                     headers: {
                //                         'Content-Type': 'application/json'
                //                     },

                //                     body: JSON.stringify({

                //                         nim: '<?= $_SESSION["nim"] ?>',

                //                         pesan: this.pesan

                //                     })

                //                 }
                //             )

                //             const result = await response.json()

                //             if (result.status === 'success') {

                //                 Swal.fire({

                //                     icon: 'success',

                //                     title: 'Pesan Berhasil Dikirim',

                //                     html: `

                //   <div class="text-start">

                //     <p>
                //       <b>Nama:</b>
                //       ${result.data.nama}
                //     </p>

                //     <p>
                //       <b>NIM:</b>
                //       ${result.data.nim}
                //     </p>

                //     <p>
                //       <b>Kelas:</b>
                //       ${result.data.kelas}
                //     </p>

                //     <p>
                //       <b>Pesan:</b>
                //       ${result.data.pesan}
                //     </p>

                //   </div>

                // `

                //                 })

                //                 this.pesan = ''

                //             } else {

                //                 Swal.fire({

                //                     icon: 'error',

                //                     title: 'Gagal',

                //                     text: result.message

                //                 })

                //             }

                //         } catch (error) {

                //             Swal.fire({

                //                 icon: 'error',

                //                 title: 'Error',

                //                 text: 'Gagal terhubung ke REST API'

                //             })

                //         } finally {

                //             this.loading = false

                //         }

                //     }

            },

            mounted() {

                this.getMeterData()

                setInterval(() => {

                    this.getMeterData()

                }, 5000)


                const plotModalElement =
                    document.getElementById('plotModal')

                this.chartModal =
                    new bootstrap.Modal(
                        plotModalElement
                    )

                plotModalElement.addEventListener(
                    'shown.bs.modal',
                    () => {

                        Plotly.Plots.resize(
                            document.getElementById(
                                'plotContainer'
                            )
                        )

                    }
                )

                plotModalElement.addEventListener(
                    'hide.bs.modal',
                    () => {

                        document.activeElement?.blur()

                    }
                )

                const modalElement =
                    document.getElementById('mapModal')

                this.modalMap =
                    new bootstrap.Modal(modalElement)

                modalElement.addEventListener(
                    'shown.bs.modal',
                    () => {

                        this.initMap()

                        setTimeout(() => {

                            if (this.map) {
                                this.map.invalidateSize()
                            }

                        }, 100)

                    }
                )

            }

        })

        const app2 = createApp({})

        app1.mount('#app1')
        app2.mount('#app2')
    </script>
</body>

</html>