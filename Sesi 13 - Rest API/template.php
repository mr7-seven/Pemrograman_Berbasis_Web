<?php

session_start();

$_SESSION['nim'] = 'C060425003';

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <title>SCADA Panel</title>

  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/icons/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    body {
      background: #f4f6f9;
    }

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

  <div id="app">

    <div class="container py-5">

      <!-- MONITORING KWH METER -->

      <div class="row justify-content-center mt-4">

        <div class="col-lg-6">

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

                  <div class="border rounded p-3">

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

                  <div class="border rounded p-3">

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

                  <div class="border rounded p-3">

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

                  <div class="border rounded p-3">

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

      <!-- PANEL CONTROL -->

      <div class="row justify-content-center g-3 mt-4">

        <div class="col-md-3">

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

        <div class="col-md-3">

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

      </div>

      <!-- FORM PESAN -->

      <div class="row justify-content-center mt-4">

        <div class="col-lg-6">

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

                <button class="btn btn-dark w-100 btn-industrial" :disabled="loading">

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

    </div>

  </div>

  <script src="assets/js/vue.global.js"></script>
  <script src="assets/js/sweetalert2.js"></script>

  <script>
    const {
      createApp
    } = Vue

    createApp({

      data() {

        return {
          meter: {},

          apiStatus: '-',

          apiStatusClass: 'text-bg-secondary',

          kontaktor1: false,
          kontaktor2: false,

          pesan: '',

          loading: false

        }

      },

      methods: {

        async getMeterData() {

          try {

            const response = await fetch(
              'http://localhost:3000/api/v1/kwh'
            )

            if (!response.ok) {
              throw new Error(
                'Gagal mengambil data'
              )
            }

            const result = await response.json()

            this.meter = result

            this.apiStatus = 'Connected'

            this.apiStatusClass =
              'text-bg-success'

          } catch (error) {

            this.apiStatus = 'Disconnected'

            this.apiStatusClass =
              'text-bg-danger'

          }

        },

        async toggleKontaktor(channel, value) {

          try {

            const response = await fetch(
              `http://localhost:3000/api/v1/kontaktor/Lampu/${channel}`, {

                method: 'PUT',

                headers: {
                  'Content-Type': 'application/json'
                },

                body: JSON.stringify({
                  value
                })

              }
            )

            if (!response.ok) {
              throw new Error()
            }

            Swal.fire({

              icon: value ?
                'success' : 'warning',

              title: value ?
                `Kontaktor ${channel} ON` : `Kontaktor ${channel} OFF`,

              text: value ?
                'Kontaktor berhasil diaktifkan' : 'Kontaktor berhasil dimatikan',

              timer: 2000,

              showConfirmButton: false

            })

          } catch (error) {

            Swal.fire({

              icon: 'error',

              title: 'Gagal',

              text: 'Tidak dapat terhubung ke server'

            })

          }

        },

        async kirimPesan() {

          this.loading = true

          try {

            const response = await fetch(
              'http://localhost:3000/api/v1/pesan', {

                method: 'POST',

                headers: {
                  'Content-Type': 'application/json'
                },

                body: JSON.stringify({

                  nim: '<?= $_SESSION["nim"] ?>',

                  pesan: this.pesan

                })

              }
            )

            const result = await response.json()

            if (result.status === 'success') {

              Swal.fire({

                icon: 'success',

                title: 'Pesan Berhasil Dikirim',

                html: `

              <div class="text-start">

                <p>
                  <b>Nama:</b>
                  ${result.data.nama}
                </p>

                <p>
                  <b>NIM:</b>
                  ${result.data.nim}
                </p>

                <p>
                  <b>Kelas:</b>
                  ${result.data.kelas}
                </p>

                <p>
                  <b>Pesan:</b>
                  ${result.data.pesan}
                </p>

              </div>

            `

              })

              this.pesan = ''

            } else {

              Swal.fire({

                icon: 'error',

                title: 'Gagal',

                text: result.message

              })

            }

          } catch (error) {

            Swal.fire({

              icon: 'error',

              title: 'Error',

              text: 'Gagal terhubung ke REST API'

            })

          } finally {

            this.loading = false

          }

        }

      },

      mounted() {

        this.getMeterData()

        setInterval(() => {

          this.getMeterData()

        }, 5000)

      }

    }).mount('#app')
  </script>

</body>

</html>