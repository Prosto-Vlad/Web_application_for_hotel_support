<div class="container mt-4">
    <form>
        <div class="row">
            <div class="col-2">
                <label for="number" class="form-label">Номер телефона</label>
                <input type="number" class="form-control" id="phone_number" name="phone_number">
            </div>

            <div class="col">
                <label for="number" class="form-label">ПІБ</label>
                <div class="input-group">
                    <input type="text" aria-label="Last name" id="last_name" class="form-control" placeholder="Прізвище">
                    <input type="text" aria-label="First name" id="first_name" class="form-control" placeholder="Ім'я">
                    <input type="text" aria-label="Middle name" id="middle_name" class="form-control" placeholder="Патронім">
                </div>
            </div>
        </div>
    </form>

    <div class="row mt-4">
        <div class="d-flex" style="padding: 0;">
            <div class="p-2 ">
                <button id="search" type="submit" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Пошук</button>
            </div>
            <div class="ms-auto p-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_cust" style="background-color: #f48412; border-color:#f48412;">
                    <img src="/img/add.png" width="30" height="30">
                </button>

                <div class="modal fade" id="modal_add_cust" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Новий користувач</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="number" class="form-label">ПІБ</label>
                                <div class="input-group">
                                    <input type="text" aria-label="Last name" id="last_name_add" class="form-control" placeholder="Прізвище">
                                    <input type="text" aria-label="First name" id="first_name_add" class="form-control" placeholder="Ім'я">
                                    <input type="text" aria-label="Middle name" id="middle_name_add" class="form-control" placeholder="Патронім">
                                </div>

                                <label for="number" class="form-label">Номер телефона</label>
                                <input type="number" class="form-control" id="phone_number_add" name="phone_number">

                                <label for="number" class="form-label">Псевдонім</label>
                                <input type="text" class="form-control" id="pseudonym_add" name="pseudonym">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                                <button id="add_cust" type="button" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Додати</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th scope="col">ПІБ</th>
                        <th scope="col">Номер телефона</th>
                        <th scope="col">Псевдонім</th>
                        <th scope="col">Заселення</th>
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
        let t_body = document.getElementById('t_body');
        let modal = new bootstrap.Modal(document.getElementById('modal_add_cust'));

        let first_name = document.getElementById('first_name');
        let middle_name = document.getElementById('middle_name');
        let last_name = document.getElementById('last_name');
        let phone_number = document.getElementById('phone_number');
        let search_btn = document.getElementById('search');

        let first_name_add = document.getElementById('first_name_add');
        let middle_name_add = document.getElementById('middle_name_add');
        let last_name_add = document.getElementById('last_name_add');
        let phone_number_add = document.getElementById('phone_number_add');
        let pseudonym_add = document.getElementById('pseudonym_add');
        let add_cust_btn = document.getElementById('add_cust');

        search();

        search_btn.addEventListener('click', search);

        add_cust_btn.addEventListener('click', () => {
            const alert = document.getElementById('alert');
            let namePattern = /^[a-zA-Zа-яА-ЯЁёїЇіІєЄґҐ]+$/;
            if (!first_name_add.value.trim()) {
                alert.innerHTML = 'Ім\'я обов\'язкове для заповнення';
                alert.classList.remove('d-none');
                return;
            }
            if (!namePattern.test(first_name_add.value)) {
                alert.innerHTML = 'Ім\'я повинно містити тільки літери';
                alert.classList.remove('d-none');
                return;
            }

            if (!namePattern.test(middle_name_add.value)) {
                alert.innerHTML = 'По-батькові повинно містити тільки літери';
                alert.classList.remove('d-none');
                return;
            }

            if (!last_name_add.value.trim()) {
                alert.innerHTML = 'Прізвище обов\'язкове для заповнення';
                alert.classList.remove('d-none');
                return;
            }
            if (!namePattern.test(last_name_add.value)) {
                alert.innerHTML = 'Прізвище повинно містити тільки літери';
                alert.classList.remove('d-none');
                return;
            }

            let phonePattern = /^(\+?38)?0\d{9}$/;
            if (!phonePattern.test(phone_number_add.value)) {
                alert.innerHTML = 'Некоректний номер телефону';
                alert.classList.remove('d-none');
                return;
            }

            if (!namePattern.test(pseudonym_add.value)) {
                alert.innerHTML = 'Псевдонім повинен містити тільки літери';
                alert.classList.remove('d-none');
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/customers/add_customer') ?>', true);
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
                'first_name': first_name_add.value,
                'middle_name': middle_name_add.value,
                'last_name': last_name_add.value,
                'phone_number': phone_number_add.value,
                'pseudonym': pseudonym_add.value,
            }));

        });


        function search() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/customers/search_customer') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    let search_results = JSON.parse(xhr.responseText)['data'];
                    if (search_results.status == 'error') {
                        console.error(search_results.errors);
                        return;
                    } else {
                        t_body.innerHTML = '';
                        for (let i = 0; i < search_results.length; i++) {
                            let tr = document.createElement('tr');
                            tr.innerHTML = '<th>' + search_results[i].last_name + ' ' + search_results[i].first_name + ' ' + search_results[i].middle_name + '</th>' +
                                '<td>' + search_results[i].phone_number + '</td>' +
                                '<td>' + search_results[i].pseudonym + '</td>' +
                                '<td>' + (search_results[i].is_settled == 't' ? search_results[i].room_number : 'Не заселений') + '</td>';
                            t_body.appendChild(tr);
                        }
                    }
                } else {
                    console.error('Server returned an error');
                }
            };

            xhr.onerror = function() {
                console.error('Connection error');
            };

            xhr.send(JSON.stringify({
                'first_name': first_name.value,
                'middle_name': middle_name.value,
                'last_name': last_name.value,
                'phone_number': phone_number.value,
            }));
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>