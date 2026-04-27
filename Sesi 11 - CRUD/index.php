<?php
// require 'koneksi.php';

// $stmt = $conn->query('SELECT * FROM perangkat_tb');
// $data = $stmt->fetchAll();

// var_dump($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <title>PDO</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        th,
        td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f5f5f5;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/img/poliban.png" class="rounded" alt="Logo" width="50" height="50"
                    class="d-inline-block align-text-center">
                <span> IMPLEMENTASI CRUD PADA APLIKASI WEB</span>
            </a>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 70px;">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2 bg-body-tertiary border-end vh-100 p-3">

                <div class="text-center">
                    <img src="assets/img/poliban.png" class="rounded mx-auto d-block mb-2" alt="foto mhs" width="100">
                    <h5>Nama Anda</h5>
                    <p class="mb-1">NIM: 12345678</p>
                    <p>Kelas: ...</p>
                </div>

                <hr class="text-secondary">

            </div>

            <!-- CONTENT -->
            <div class="col-md-9 col-lg-10 p-4 bg-body-tertiary">
                <h3 class="mb-4">SISTEM MONITORING KWH METER BERBASIS WEB</h3>


                <!-- ROW 1 -->
                <div class="row g-3 mb-3">
                    <div class="col-md">
                        <div class="card text-center h-100">
                            <div class="card-body d-flex flex-column align-items-center">

                                <p id="status"></p>

                                <form id="formData">
                                    <input type="hidden" id="id">
                                    <label>Tegangan (V):</label><br>
                                    <input type="number" id="tegangan" step="any" required><br><br>

                                    <label>Arus (A):</label><br>
                                    <input type="number" id="arus" step="any" required><br><br>

                                    <label>Daya (W):</label><br>
                                    <input type="number" id="daya" readonly><br><br>

                                    <button type="submit">Simpan</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW 2 -->
                <div class="row g-3 mb-3">
                    <div class="col-md">
                        <div class="card text-center h-100">
                            <div class="card-body d-flex flex-column align-items-center">

                                <table border="1">
                                    <thead>
                                        <tr>
                                            <th>Tegangan</th>
                                            <th>Arus</th>
                                            <th>Daya</th>
                                            <th>Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dataTable"></tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW 3 -->
                <div class="row g-3 mb-3">
                    <div class="col-md">
                        <div class="card text-center h-100">
                            <div class="card-body d-flex flex-column align-items-center">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        const tableBody = document.getElementById("dataTable");

        async function loadData() {
            try {
                const response = await fetch("get_data.php");
                const data = await response.json();

                tableBody.innerHTML = "";

                data.forEach(item => {
                    const row = `
                <tr>
                    <td>${item.tegangan}</td>
                    <td>${item.arus}</td>
                    <td>${item.daya}</td>
                    <td>${item.waktu}</td>
                    <td>
                        <button onclick="editData(${item.id}, ${item.tegangan}, ${item.arus})">
                            Edit
                        </button> |
                        <button onclick="deleteData(${item.id})">Hapus</button>
                    </td>
                </tr>
            `;
                    tableBody.innerHTML += row;
                });

            } catch (error) {
                console.error("Gagal load data:", error);
            }
        }

        // Load saat halaman dibuka
        loadData();
    </script>
    <script>
        const form = document.getElementById("formData");
        const teganganInput = document.getElementById("tegangan");
        const arusInput = document.getElementById("arus");
        const dayaInput = document.getElementById("daya");
        const statusText = document.getElementById("status");

        // Hitung daya otomatis
        function hitungDaya() {
            const v = parseFloat(teganganInput.value) || 0;
            const i = parseFloat(arusInput.value) || 0;

            const daya = v * i;
            dayaInput.value = daya.toFixed(2);
        }

        teganganInput.addEventListener("input", hitungDaya);
        arusInput.addEventListener("input", hitungDaya);

        // Tampilkan status sementara
        function showStatus(message, isError = false) {
            statusText.innerText = message;
            statusText.style.color = isError ? "red" : "green";

            // Hilang setelah 5 detik
            setTimeout(() => {
                statusText.innerText = "";
            }, 5000);
        }

        function editData(id, tegangan, arus) {
            document.getElementById("id").value = id;
            teganganInput.value = tegangan;
            arusInput.value = arus;

            hitungDaya();

            // ubah tombol jadi update
            form.querySelector("button[type=submit]").innerText = "Update";
        }

        // Submit tanpa reload
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const id = document.getElementById("id").value;

            const data = {
                id: id,
                tegangan: parseFloat(teganganInput.value),
                arus: parseFloat(arusInput.value)
            };

            const url = id ? "update.php" : "insert.php";

            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            showStatus(result.message);

            // reset form
            form.reset();
            dayaInput.value = "";
            document.getElementById("id").value = "";

            // balikin tombol
            form.querySelector("button[type=submit]").innerText = "Simpan";

            loadData();
        });

        async function deleteData(id) {
            if (!confirm("Yakin ingin menghapus data ini?")) return;

            try {
                const response = await fetch("delete.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        id
                    })
                });

                const result = await response.json();

                showStatus(result.message);
                loadData();

            } catch (error) {
                showStatus("Gagal menghapus data", true);
            }
        }
    </script>
</body>

</html>