<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $customer[0]->first_name . ' ' . $customer[0]->last_name; ?></title>
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
                <a href="<?= base_url('manager/customers') ?>"><img src="/img/back.png" alt="UPD" width="50" height="50"></a>
            </div>
            <div class="navbar-nav d-flex ms-auto align-items-center">
                <img src="/img/logo.png" alt="Logo" width="50" height="50">
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class=" row">
            <div class="col">
                <label for="number" class="form-label">ПІБ</label>
                <div class="input-group">
                    <input type="text" aria-label="Last name" id="last_name_upd" class="form-control" placeholder="Прізвище" value="<?= $customer[0]->last_name ?>">
                    <input type="text" aria-label="First name" id="first_name_upd" class="form-control" placeholder="Ім'я" value="<?= $customer[0]->first_name ?>">
                    <input type="text" aria-label="Middle name" id="middle_name_upd" class="form-control" placeholder="Патронім" value="<?= $customer[0]->middle_name ?>">
                </div>
            </div>
            <div class="col">
                <label for="number" class="form-label">Псевдонім</label>
                <input type="text" class="form-control" id="pseudonym_upd" name="pseudonym" value="<?= $customer[0]->pseudonym ?>">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <label for="number" class="form-label">Номер телефона</label>
                <input type="number" class="form-control" id="phone_number_upd" name="phone_number" value="<?= $customer[0]->phone_number ?>">
            </div>
        </div>
        <div id="alert" class="alert alert-danger d-none mt-4" role="alert">

        </div>
        <div class=" row mt-4 d-flex">
            <div class="col ms-auto">
                <button id="upd_cust" type="button" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Зберегти</button>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const upd_cust_btn = document.getElementById('upd_cust');

            const id = <?= $customer[0]->id ?>;
            const last_name = document.getElementById('last_name_upd');
            const first_name = document.getElementById('first_name_upd');
            const middle_name = document.getElementById('middle_name_upd');

            const pseudonym = document.getElementById('pseudonym_upd');
            const phone_number = document.getElementById('phone_number_upd');


            upd_cust_btn.addEventListener('click', () => {
                const alert = document.getElementById('alert');
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

                if (!namePattern.test(pseudonym.value)) {
                    alert.innerHTML = 'Псевдонім повинен містити тільки літери';
                    alert.classList.remove('d-none');
                    return;
                }

                let xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= base_url('manager/customers/update') ?>', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onload = () => {
                    if (xhr.status == 200) {
                        window.location.href = '<?= base_url('manager/customers') ?>';
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
                    'pseudonym': pseudonym.value,
                    'phone_number': phone_number.value,
                }));
            });

        });
    </script>

</body>

</html>
</body>

</html>