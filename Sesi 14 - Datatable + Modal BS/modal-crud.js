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
                    arus: parseFloat(arusInput.value)
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