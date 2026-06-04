        const {
            createApp,
            onMounted
        } = Vue
        console.log('Leaflet:', typeof L)
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

                    modalMap: null

                }

            },

            methods: {
                initMap() {

                    if (this.map) return

                    this.map = L.map('map').setView(
                        [-3.295708, 114.582116],
                        13
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