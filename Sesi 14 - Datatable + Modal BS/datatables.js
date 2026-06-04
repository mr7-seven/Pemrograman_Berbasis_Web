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
                                data-arus="${row.arus}">
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