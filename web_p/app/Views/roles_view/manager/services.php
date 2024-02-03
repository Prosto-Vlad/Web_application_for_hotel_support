<div class="container mt-4">
    <div class="row">
        <div class="col-3">
            <label for="name" class="form-label">Назва</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
    </div>

    <div class="row d-flex ">
        <div class="col-1 mt-4">
            <button id="search" type="submit" class="btn btn-primary mt-2 " style="background-color: #f48412; border-color:#f48412;">Пошук</button>
        </div>

        <div class="col-2 mt-4 ms-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_serv" style="background-color: #f48412; border-color:#f48412;">
                Додати послугу
            </button>

            <div class="modal fade" id="modal_add_serv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Нова послуга</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="alert_modal" class="alert alert-danger d-none mt-4" role="alert">

                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="form-label ">Назва</label>
                                    <input type="text" class="form-control" id="name_add" name="name">
                                </div>
                                <div class="col">
                                    <label for="cost" class="form-label">Ціна</label>
                                    <input type="text" class="form-control" id="cost_add" name="cost">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="details" class="form-label ">Опис</label>
                                    <input type="text" class="form-control" id="details_add" name="details">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                            <button id="add_serv" type="button" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Додати</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Назва</th>
                        <th scope="col">Ціна</th>
                        <th scope="col">Деталі</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="t_body">

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const t_body = document.getElementById('t_body');
        const modal = new bootstrap.Modal(document.getElementById('modal_add_serv'));

        const add_serv_btn = document.getElementById('add_serv');
        const search_btn = document.getElementById('search');

        const name = document.getElementById('name');

        const name_add = document.getElementById('name_add');
        const cost_add = document.getElementById('cost_add');
        const details_add = document.getElementById('details_add');

        search();

        search_btn.addEventListener('click', search);

        add_serv_btn.addEventListener('click', () => {
            const alert_modal = document.getElementById('alert_modal');
            alert_modal.classList.add('d-none');

            if (name_add.value == '') {
                alert_modal.classList.remove('d-none');
                alert_modal.innerHTML = 'Введіть назву послуги';
                return;
            }
            if (cost_add.value == '') {
                alert_modal.classList.remove('d-none');
                alert_modal.innerHTML = 'Введіть ціну послуги';
                return;
            }
            if (details_add.value == '') {
                alert_modal.classList.remove('d-none');
                alert_modal.innerHTML = 'Введіть опис послуги';
                return;
            }


            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('manager/services/add') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    search();
                    modal.hide();
                } else {
                    console.error('Server returned an error');
                }
            };

            xhr.onerror = function() {
                console.error('Connection error');
            };

            xhr.send(JSON.stringify({
                'name': name_add.value,
                'cost': cost_add.value,
                'details': details_add.value,
            }));

        });

        function search() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('manager/services/search') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    let search_results = JSON.parse(xhr.responseText)['data'];

                    t_body.innerHTML = '';
                    for (let i = 0; i < search_results.length; i++) {
                        let tr = document.createElement('tr');
                        tr.id = search_results[i].id;
                        tr.innerHTML =
                            '<th>' + search_results[i].name_s + '</th>' +
                            '<td>' + search_results[i].cost_s + '</td>' +
                            '<td>' + search_results[i].details + '</td>' +
                            '<td style="width: 10%;"><a style="background-color: #f48412; border-color:#f48412;" class="btn btn-primary" href="' + '<?= base_url('manager/services/update/') ?>' + search_results[i].id + '"><img src="/img/edit.png" alt="UPD" width="25" height="25"></a></td>';
                        t_body.appendChild(tr);
                    }
                } else {
                    console.error('Server returned an error');
                }
            };

            xhr.onerror = function() {
                console.error('Connection error');
            };

            xhr.send(JSON.stringify({
                'name': name.value,
            }));
        }

    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
</body>

</html>