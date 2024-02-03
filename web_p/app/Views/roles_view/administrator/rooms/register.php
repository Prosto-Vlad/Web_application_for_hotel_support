<ul class="nav nav-tabs" id="myTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="search-tab" href="<?= base_url('administrator/rooms/search') ?>">Пошук</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="register-tab" href="<?= base_url('administrator/rooms/register') ?>">Реєстрація</a>
    </li>
</ul>

<div class="container mt-4">
    <div class="row">
        <div class="col-2">
            <label for="number" class="form-label">Номер телефону</label>
            <input class="form-control" id="phone_number_search" name="phone_number">
        </div>
        <div class="col">
            <label for="number" class="form-label">ПІБ</label>
            <div class="input-group">
                <input type="text" aria-label="Last name" id="last_name" class="form-control" placeholder="Прізвище" disabled>
                <input type="text" aria-label="First name" id="first_name" class="form-control" placeholder="Ім'я" disabled>
                <input type="text" aria-label="Middle name" id="middle_name" class="form-control" placeholder="Патронім" disabled>
            </div>
        </div>
        <div class="col-3">
            <label for="number" class="form-label">Псевдонім</label>
            <input type="text" class="form-control" id="pseudonym" name="pseudonym" disabled>
        </div>

        <div class="col-1 mt-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_cust" style="background-color: #f48412; border-color:#f48412;">
                <img src="/img/add.png" width="36" height="36">
            </button>

            <div class="modal fade" id="modal_add_cust" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Новий користувач</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: #f48412; border-color:#f48412;"></button>
                        </div>
                        <div class="modal-body">
                            <div id="alert_modal" class="alert alert-danger d-none mt-4" role="alert">

                            </div>

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
    <div class="row">
        <div class="col-2">
            <label for="date_from" class="form-label">Дата з</label>
            <input type="date" class="form-control" id="date_from_reg" name="date_from_reg">
        </div>
        <div class="col-2">
            <label for="date_to" class="form-label">Дата по</label>
            <input type="date" class="form-control" id="date_to_reg" name="date_to_reg">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <textarea class="form-control" id="description_reg" rows="3" placeholder="Опис"></textarea>
        </div>
    </div>

    <div id="alert" class="alert alert-danger d-none mt-4" role="alert">

    </div>

    <hr class="mt-4">

    <div class="row">
        <h2>Пошук вільних номерів</h2>
        <div class="col-2">
            <label for="beds_num" class="form-label">Кількість місць</label>
            <input type="number" class="form-control" id="beds_num" name="beds_num">
        </div>
        <div class="col-2">
            <label for="type" class="form-label">Тип</label>
            <select class="form-select" id="type" name="type">
                <option value="0">Всі</option>
                <?php foreach ($room_types as $type) : ?>
                    <option value="<?= $type->t_name ?>"><?= $type->t_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row mt-4">

        <div class="col-2">
            <label for="cost_r" class="form-label">Мінімальна ціна</label>
            <input type="number" class="form-control" id="cost_r_min" name="cost_r">
        </div>
        <div class="col-2">
            <label for="cost_r" class="form-label">Максимальна ціна</label>
            <input type="number" class="form-control" id="cost_r_max" name="cost_r">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Номер</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Кількість місць</th>
                        <th scope="col">Ціна</th>
                        <th scope="col">Опис</th>
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
        const modal = new bootstrap.Modal(document.getElementById('modal_add_cust'));

        const first_name_add = document.getElementById('first_name_add');
        const middle_name_add = document.getElementById('middle_name_add');
        const last_name_add = document.getElementById('last_name_add');
        const phone_number_add = document.getElementById('phone_number_add');
        const pseudonym_add = document.getElementById('pseudonym_add');
        const add_cust_btn = document.getElementById('add_cust');

        const phone_number = document.getElementById('phone_number_search');
        const first_name = document.getElementById('first_name');
        const middle_name = document.getElementById('middle_name');
        const last_name = document.getElementById('last_name');
        const pseudonym = document.getElementById('pseudonym');

        const number_r = document.getElementById('number_r');
        const type = document.getElementById('type');
        const beds_num = document.getElementById('beds_num');
        const cost_r_min = document.getElementById('cost_r_min');
        const cost_r_max = document.getElementById('cost_r_max');

        const date_from_reg = document.getElementById('date_from_reg');
        const date_to_reg = document.getElementById('date_to_reg');
        const description = document.getElementById('description_reg');
        const reg_btn = document.getElementById('reg');


        load_table();

        type.addEventListener('change', load_table);
        beds_num.addEventListener('input', load_table);
        cost_r_min.addEventListener('input', load_table);
        cost_r_max.addEventListener('input', load_table);
        date_from_reg.addEventListener('input', load_table);
        date_to_reg.addEventListener('input', load_table);

        phone_number.addEventListener('input', search_phone);

        function register(id) {
            var alert = document.getElementById('alert');

            let phonePattern = /^(\+?38)?0\d{9}$/;
            if (!phonePattern.test(phone_number.value)) {
                alert.innerHTML = 'Некоректний номер';
                alert.classList.remove('d-none');
                return;
            }

            if ((date_from_reg.value == '' || date_to_reg.value == '') || (date_from_reg.value > date_to_reg.value)) {
                alert.innerHTML = 'Некоректна дата';
                alert.classList.remove('d-none');
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/rooms/register/add_settlement') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = () => {
                if (xhr.status == 200) {
                    load_table();
                } else {
                    console.error('Server returned an error');
                }
            };
            xhr.onerror = function() {
                console.error('Connection error');
            };
            xhr.send(JSON.stringify({
                'room_id': id,
                'date_from': date_from_reg.value,
                'date_to': date_to_reg.value,
                'description': description.value,
                'phone_number': phone_number.value,
            }));

        }

        function load_table() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/rooms/register/search_room') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    let search_results = JSON.parse(xhr.responseText)['data'];

                    t_body.innerHTML = '';
                    for (let i = 0; i < search_results.length; i++) {
                        let tr = document.createElement('tr');
                        let btn = document.createElement('button');
                        btn.type = 'button';
                        btn.style.backgroundColor = '#f48412';
                        btn.style.borderColor = '#f48412';
                        btn.className = 'btn btn-primary';
                        btn.innerHTML = '<img src="/img/booking.png" alt="Register" width="20" height="20">';
                        btn.dataset.number = search_results[i].number;
                        btn.addEventListener('click', () => register(search_results[i].id));
                        tr.innerHTML = '<th>' + search_results[i].number + '</th>' +
                            '<td>' + search_results[i].t_name + '</td>' +
                            '<td>' + search_results[i].beds_num + '</td>' +
                            '<td>' + search_results[i].cost_r + '</td>' +
                            '<td>' + search_results[i].description + '</td>' +
                            '<td></td>';
                        tr.children[5].appendChild(btn);
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
                'type': type.value,
                'beds_num': beds_num.value,
                'min_price': cost_r_min.value,
                'max_price': cost_r_max.value,
                'booking_from': date_from_reg.value,
                'booking_to': date_to_reg.value,

            }));

        }

        function search_phone() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/rooms/register/phone_search') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    let search_results = JSON.parse(xhr.responseText)['data'];
                    if (search_results.length == 1) {
                        first_name.value = search_results[0]['first_name'];
                        middle_name.value = search_results[0]['middle_name'];
                        last_name.value = search_results[0]['last_name'];
                        pseudonym.value = search_results[0]['pseudonym'];
                    } else {
                        first_name.value = '';
                        middle_name.value = '';
                        last_name.value = '';
                        pseudonym.value = '';
                    }
                } else {
                    console.error('Server returned an error');
                }
            };

            xhr.onerror = function() {
                console.error('Connection error');
            };

            xhr.send(JSON.stringify({
                'phone_number': phone_number.value,
            }));
        }

        add_cust_btn.addEventListener('click', () => {
            const alert_modal = document.getElementById('alert_modal');
            alert_modal.classList.add('d-none');

            let namePattern = /^[a-zA-Zа-яА-ЯЁёїЇіІєЄґҐ]+$/;
            if (!first_name_add.value.trim()) {
                alert_modal.innerHTML = 'Ім\'я обов\'язкове для заповнення';
                alert_modal.classList.remove('d-none');
                return;
            }
            if (!namePattern.test(first_name_add.value)) {
                alert_modal.innerHTML = 'Ім\'я повинно містити тільки літери';
                alert_modal.classList.remove('d-none');
                return;
            }

            if (!namePattern.test(middle_name_add.value)) {
                alert_modal.innerHTML = 'По-батькові повинно містити тільки літери';
                alert_modal.classList.remove('d-none');
                return;
            }

            if (!last_name_add.value.trim()) {
                alert_modal.innerHTML = 'Прізвище обов\'язкове для заповнення';
                alert_modal.classList.remove('d-none');
                return;
            }
            if (!namePattern.test(last_name_add.value)) {
                alert_modal.innerHTML = 'Прізвище повинно містити тільки літери';
                alert_modal.classList.remove('d-none');
                return;
            }

            let phonePattern = /^(\+?38)?0\d{9}$/;
            if (!phonePattern.test(phone_number_add.value)) {
                alert_modal.innerHTML = 'Некоректний номер телефону';
                alert_modal.classList.remove('d-none');
                return;
            }

            if (!namePattern.test(pseudonym_add.value)) {
                alert_modal.innerHTML = 'Псевдонім повинен містити тільки літери';
                alert_modal.classList.remove('d-none');
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/rooms/register/add_customer') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
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
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
</body>

</html>