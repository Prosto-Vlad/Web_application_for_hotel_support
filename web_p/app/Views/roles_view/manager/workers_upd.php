<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $worker[0]->first_name . ' ' . $worker[0]->last_name  ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 66px;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: white;
        }
    </style>
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #f48412;">
        <div class="container-fluid">
            <div>
                <a href="<?= base_url('manager/workers') ?>"><img src="/img/back.png" alt="UPD" width="50" height="50"></a>
            </div>
            <div class="navbar-nav d-flex ms-auto align-items-center">
                <img src="/img/logo.png" alt="Logo" width="50" height="50">
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class=" row">
            <label for="number" class="form-label">ПІБ</label>
            <div class="input-group">
                <input type="text" aria-label="Last name" id="last_name_add" class="form-control" placeholder="Прізвище" value="<?= $worker[0]->last_name ?>">
                <input type="text" aria-label="First name" id="first_name_add" class="form-control" placeholder="Ім'я" value="<?= $worker[0]->first_name ?>">
                <input type="text" aria-label="Middle name" id="middle_name_add" class="form-control" placeholder="Патронім" value="<?= $worker[0]->middle_name ?>">
            </div>
        </div>

        <div class=" row">
            <div class="col">
                <label for="number" class="form-label">Номер телефона</label>
                <input type="number" class="form-control" id="phone_number_add" name="phone_number" value="<?= $worker[0]->phone_number ?>">
            </div>
            <div class="col">
                <label for="number" class="form-label">Зарплатня</label>
                <input type="number" class="form-control" id="salary_add" name="salary" value="<?= $worker[0]->salary ?>">
            </div>
        </div>

        <div class=" row">
            <div class="col">
                <label for="number" class="form-label">Логін</label>
                <input type="text" class="form-control" id="login_add" name="login" value="<?= $worker[0]->login_w ?>">
            </div>
            <div class="col">
                <label for="number" class="form-label">Пароль</label>
                <input type="text" class="form-control" id="password_add" name="password">
            </div>
        </div>

        <div class=" row">
            <div class="col">
                <label for="number" class="form-label">Посада</label>
                <select id="position_add" class="form-select" id="type" name="type">
                    <?php foreach ($positions as $pos) : ?>
                        <option value="<?= $pos->id ?>" <?= $pos->id == $worker[0]->position_id ? 'selected' : '' ?>><?= $pos->name_p ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col">
                <label for="type" class="form-label">Роль</label>
                <select id="role_add" class="form-select" id="type" name="type">
                    <option value="1" <?= $worker[0]->role_id == 1 ? 'selected' : '' ?>>Менеджер</option>
                    <option value="2" <?= $worker[0]->role_id == 2 ? 'selected' : '' ?>>Адміністратор</option>
                    <option value="3" <?= $worker[0]->role_id == 3 ? 'selected' : '' ?>>Працівник</option>
                </select>
            </div>
            <div class="col">
                <label for="type" class="form-label">Розклад</label>
                <select id="schedule_add" class="form-select" id="type" name="type">
                    <?php foreach ($schedules as $sched) : ?>
                        <option value="<?= $sched->id ?>" <?= $sched->id == $worker[0]->schedule_id ? 'selected' : '' ?>><?= $sched->s_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="alert" class="alert alert-danger d-none mt-4" role="alert">

            </div>
        </div>

        <div class="row mt-4 d-flex">
            <div class="col ms-auto">
                <button id="upd_work" type="button" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Зберегти</button>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const upd_work_btn = document.getElementById('upd_work');
                let alert = document.getElementById('alert');

                const id = <?= $worker[0]->id ?>;
                const last_name = document.getElementById('last_name_add');
                const first_name = document.getElementById('first_name_add');
                const middle_name = document.getElementById('middle_name_add');
                const phone_number = document.getElementById('phone_number_add');
                const salary = document.getElementById('salary_add');
                const login_w = document.getElementById('login_add');
                const password_w = document.getElementById('password_add');
                const position_id = document.getElementById('position_add');
                const role_id = document.getElementById('role_add');
                const schedule_id = document.getElementById('schedule_add');



                upd_work_btn.addEventListener('click', () => {

                    let namePattern = /^[a-zA-Zа-яА-ЯЁёїЇіІєЄґҐ]+$/;
                    if (!first_name.value.trim()) {
                        alert.innerHTML = 'Ім\'я обов\'язкове для заповнення';
                        alert.classList.remove('d-none');
                        return;
                    }
                    if (!namePattern.test(first_name.value)) {
                        alert.innerHTML = 'Ім\'я повинно містити тільки літери';
                        alert.classList.remove('d-none');
                        return;
                    }

                    if (!namePattern.test(middle_name.value)) {
                        alert.innerHTML = 'По-батькові повинно містити тільки літери';
                        alert.classList.remove('d-none');
                        return;
                    }

                    if (!last_name.value.trim()) {
                        alert.innerHTML = 'Прізвище обов\'язкове для заповнення';
                        alert.classList.remove('d-none');
                        return;
                    }
                    if (!namePattern.test(last_name.value)) {
                        alert.innerHTML = 'Прізвище повинно містити тільки літери';
                        alert.classList.remove('d-none');
                        return;
                    }

                    let phonePattern = /^(\+?38)?0\d{9}$/;
                    if (!phonePattern.test(phone_number.value)) {
                        alert.innerHTML = 'Некоректний номер телефону';
                        alert.classList.remove('d-none');
                        return;
                    }

                    if (!salary.value.trim()) {
                        alert.innerHTML = 'Зарплатня обов\'язкова для заповнення';
                        alert.classList.remove('d-none');
                        return;
                    }

                    let salaryPattern = /^[0-9]+$/;
                    if (!salaryPattern.test(salary.value)) {
                        alert.innerHTML = 'Зарплатня повинна бути числом';
                        alert.classList.remove('d-none');
                        return;
                    }

                    if (!position.value.trim()) {
                        alert.innerHTML = 'Посада обов\'язкова для заповнення';
                        alert.classList.remove('d-none');
                        return;
                    }

                    if (!role.value.trim()) {
                        alert.innerHTML = 'Роль обов\'язкова для заповнення';
                        alert.classList.remove('d-none');
                        return;
                    }

                    if (!login.value.trim()) {
                        alert.innerHTML = 'Логін обов\'язковий для заповнення';
                        alert.classList.remove('d-none');
                        return;
                    }

                    if (!password.value.trim()) {
                        alert.innerHTML = 'Пароль обов\'язковий для заповнення';
                        alert.classList.remove('d-none');
                        return;
                    }

                    if (!schedule.value.trim()) {
                        alert.innerHTML = 'Розклад обов\'язковий для заповнення';
                        alert.classList.remove('d-none');
                        return;
                    }


                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', '<?= base_url('manager/workers/update') ?>', true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.setRequestHeader('Content-Type', 'application/json');

                    xhr.onload = () => {
                        if (xhr.status == 200) {
                            window.location.href = '<?= base_url('manager/workers') ?>';
                        } else {
                            console.error('Server returned an error');
                        }
                    };

                    xhr.onerror = function() {
                        console.error('Connection error');
                    };

                    xhr.send(JSON.stringify({
                        'id': id,
                        'last_name': last_name.value,
                        'first_name': first_name.value,
                        'middle_name': middle_name.value,
                        'phone_number': phone_number.value,
                        'salary': salary.value,
                        'login_w': login_w.value,
                        'password_w': password_w.value,
                        'position_id': position_id.value,
                        'role_id': role_id.value,
                        'schedule_id': schedule_id.value,
                    }));
                });

            });
        </script>

</body>

</html>