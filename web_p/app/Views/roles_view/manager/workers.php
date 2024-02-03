<div class="container mt-4">
    <form>
        <div class="row">
            <div class="col">
                <label for="number" class="form-label">ПІБ</label>
                <div class="input-group">
                    <input type="text" aria-label="Last name" id="last_name" class="form-control" placeholder="Прізвище">
                    <input type="text" aria-label="First name" id="first_name" class="form-control" placeholder="Ім'я">
                    <input type="text" aria-label="Middle name" id="middle_name" class="form-control" placeholder="Патронім">
                </div>
            </div>

            <div class="col-2">
                <label for="text" class="form-label">Посада</label>
                <input type="text" class="form-control" id="position" name="position">
            </div>

            <div class="col-3">
                <label for="type" class="form-label">Роль</label>
                <select id="role" class="form-select" id="type" name="type">
                    <option value=""></option>
                    <option value="1">Менеджер</option>
                    <option value="2">Адміністратор</option>
                    <option value="3">Працівник</option>
                </select>
            </div>
        </div>
    </form>

    <div class="row mt-4">
        <div class="d-flex" style="padding: 0;">
            <div class=" p-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_work" style="background-color: #f48412; border-color:#f48412;">
                    Додати нового працівника
                </button>

                <div class="modal fade" id="modal_add_work" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Новий працівник</h1>
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

                                <label for="number" class="form-label">Зарплатня</label>
                                <input type="number" class="form-control" id="salary_add" name="salary">

                                <label for="number" class="form-label">Посада</label>
                                <select id="position_add" class="form-select" id="type" name="type">
                                    <option value=""></option>
                                    <?php foreach ($positions as $pos) : ?>
                                        <option value="<?= $pos->id ?>"><?= $pos->name_p ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label for="type" class="form-label">Роль</label>
                                <select id="role_add" class="form-select" id="type" name="type">
                                    <option value=""></option>
                                    <option value="1">Менеджер</option>
                                    <option value="2">Адміністратор</option>
                                    <option value="3">Працівник</option>
                                </select>

                                <label for="number" class="form-label">Логін</label>
                                <input type="text" class="form-control" id="login_add" name="login">

                                <label for="number" class="form-label">Пароль</label>
                                <input type="text" class="form-control" id="password_add" name="password">

                                <label for="type" class="form-label">Розклад</label>
                                <select id="schedule_add" class="form-select" id="type" name="type">
                                    <option value=""></option>
                                    <?php foreach ($schedules as $sched) : ?>
                                        <option value="<?= $sched->id ?>"><?= $sched->s_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                                <button id="add_work" type="button" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Додати</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ms-auto p-2 ">
                <button id="search" type="submit" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Пошук</button>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th scope="col">ПІБ</th>
                            <th scope="col">номер телефону</th>
                            <th scope="col">Роль</th>
                            <th scope="col">Посада</th>
                            <th scope="col">Логін</th>
                            <th scope="col">Графік</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="t_body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- TODO: видалення працівників (чистка інформації) -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        let t_body = document.getElementById('t_body');
        let modal = new bootstrap.Modal(document.getElementById('modal_add_work'));

        let first_name = document.getElementById('first_name');
        let middle_name = document.getElementById('middle_name');
        let last_name = document.getElementById('last_name');
        let position = document.getElementById('position');
        let role = document.getElementById('role');

        let first_name_add = document.getElementById('first_name_add');
        let middle_name_add = document.getElementById('middle_name_add');
        let last_name_add = document.getElementById('last_name_add');
        let phone_number_add = document.getElementById('phone_number_add');
        let salary_add = document.getElementById('salary_add');
        let position_add = document.getElementById('position_add');
        let role_add = document.getElementById('role_add');
        let login_add = document.getElementById('login_add');
        let password_add = document.getElementById('password_add');
        let schedule_add = document.getElementById('schedule_add');


        let search_btn = document.getElementById('search');
        let add_work_btn = document.getElementById('add_work');

        search();

        search_btn.addEventListener('click', search);

        add_work_btn.addEventListener('click', () => {
            let alert_model = document.getElementById('alert_modal');

            let namePattern = /^[a-zA-Zа-яА-ЯЁёїЇіІєЄґҐ]+$/;
            if (!first_name_add.value.trim()) {
                alert_model.innerHTML = 'Ім\'я обов\'язкове для заповнення';
                alert_model.classList.remove('d-none');
                return;
            }
            if (!namePattern.test(first_name_add.value)) {
                alert_model.innerHTML = 'Ім\'я повинно містити тільки літери';
                alert_model.classList.remove('d-none');
                return;
            }

            if (!namePattern.test(middle_name_add.value)) {
                alert_model.innerHTML = 'По-батькові повинно містити тільки літери';
                alert_model.classList.remove('d-none');
                return;
            }

            if (!last_name_add.value.trim()) {
                alert_model.innerHTML = 'Прізвище обов\'язкове для заповнення';
                alert_model.classList.remove('d-none');
                return;
            }
            if (!namePattern.test(last_name_add.value)) {
                alert_model.innerHTML = 'Прізвище повинно містити тільки літери';
                alert_model.classList.remove('d-none');
                return;
            }

            let phonePattern = /^(\+?38)?0\d{9}$/;
            if (!phonePattern.test(phone_number_add.value)) {
                alert_model.innerHTML = 'Некоректний номер телефону';
                alert_model.classList.remove('d-none');
                return;
            }

            if (!salary_add.value.trim()) {
                alert_model.innerHTML = 'Зарплатня обов\'язкова для заповнення';
                alert_model.classList.remove('d-none');
                return;
            }

            let salaryPattern = /^[0-9]+$/;
            if (!salaryPattern.test(salary_add.value)) {
                alert_model.innerHTML = 'Зарплатня повинна бути числом';
                alert_model.classList.remove('d-none');
                return;
            }

            if (!position_add.value.trim()) {
                alert_model.innerHTML = 'Посада обов\'язкова для заповнення';
                alert_model.classList.remove('d-none');
                return;
            }

            if (!role_add.value.trim()) {
                alert_model.innerHTML = 'Роль обов\'язкова для заповнення';
                alert_model.classList.remove('d-none');
                return;
            }

            if (!login_add.value.trim()) {
                alert_model.innerHTML = 'Логін обов\'язковий для заповнення';
                alert_model.classList.remove('d-none');
                return;
            }

            if (!password_add.value.trim()) {
                alert_model.innerHTML = 'Пароль обов\'язковий для заповнення';
                alert_model.classList.remove('d-none');
                return;
            }

            if (!schedule_add.value.trim()) {
                alert_model.innerHTML = 'Розклад обов\'язковий для заповнення';
                alert_model.classList.remove('d-none');
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('manager/workers/add') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    let res_data = JSON.parse(xhr.responseText)['data'];
                    for (let key in res_data) {
                        if (key == 'errors') {
                            console.log(res_data[key]);
                            return;
                        }
                    }
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
                'salary': salary_add.value,
                'position': position_add.value,
                'role': role_add.value,
                'login': login_add.value,
                'password': password_add.value,
                'schedule_id': schedule_add.value
            }));

        });

        function search() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('manager/workers/search') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    let search_results = JSON.parse(xhr.responseText)['data'];

                    t_body.innerHTML = '';
                    for (let i = 0; i < search_results.length; i++) {
                        let tr = document.createElement('tr');
                        tr.innerHTML = '<th>' + search_results[i].first_name + ' ' + search_results[i].middle_name + ' ' + search_results[i].last_name + '</th>' +
                            '<td>' + search_results[i].phone_number + '</td>' +
                            '<td>' + search_results[i].name_r + '</td>' +
                            '<td>' + search_results[i].name_p + '</td>' +
                            '<td>' + search_results[i].login_w + '</td>' +
                            '<td>' + search_results[i].s_name + '</td>' +
                            '<td><a style="background-color: #f48412; border-color:#f48412;" class="btn btn-primary" href="' + '<?= base_url('manager/workers/update/') ?>' + search_results[i].id + '"><img src="/img/edit.png" alt="UPD" width="25" height="25" ></a></td>';
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
                'first_name': first_name.value,
                'middle_name': middle_name.value,
                'last_name': last_name.value,
                'position': position.value,
                'role': role.value
            }));
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>