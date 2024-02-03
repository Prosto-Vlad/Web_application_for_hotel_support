<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $room[0]->number ?></title>
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
                <a href="<?= base_url('manager/rooms') ?>"><img src="/img/back.png" alt="UPD" width="50" height="50"></a>
            </div>
            <div class="navbar-nav d-flex ms-auto align-items-center">
                <img src="/img/logo.png" alt="Logo" width="50" height="50">
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class=" row">
            <div class="col">
                <label for="number" class="form-label ">Номер</label>
                <input type="number" class="form-control" id="number_add" name="number" value="<?= $room[0]->number ?>">
            </div>
            <div class="col">
                <label for="text" class="form-label">Ціна</label>
                <input type="text" class="form-control" id="cost_add" name="cost" value="<?= $room[0]->cost_r ?>">
            </div>
            <div class="col">
                <label for="number" class="form-label">Кількість спальних місці</label>
                <input type="number" class="form-control" id="sleep_add" name="sleep" value="<?= $room[0]->beds_num ?>">
            </div>
            <div class="col">
                <label for="type" class="form-label">Тип</label>
                <select class="form-select" id="type" name="type">
                    <?php foreach ($room_types as $type) : ?>
                        <option value="<?= $type->id ?>" <?= $type->id == $room[0]->type_id ? 'selected' : '' ?>><?= $type->t_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="details" class="form-label ">Опис</label>
                <input type="text" class="form-control" id="details_add" name="details" value="<?= $room[0]->description ?>">
            </div>
        </div>

        <div id="alert" class="alert alert-danger d-none mt-4" role="alert">

        </div>

        <div class="row mt-4 d-flex">
            <div class="col ms-auto">
                <button id="upd_room" type="button" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Зберегти</button>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const upd_room_btn = document.getElementById('upd_room');

            const id = <?= $room[0]->id ?>;
            const number = document.getElementById('number_add');
            const cost = document.getElementById('cost_add');
            const sleep = document.getElementById('sleep_add');
            const details = document.getElementById('details_add');
            const type = document.getElementById('type');



            upd_room_btn.addEventListener('click', () => {
                const alert = document.getElementById('alert');
                alert.classList.add('d-none');

                if (number.value == '') {
                    alert.innerHTML = 'Введіть номер';
                    alert.classList.remove('d-none');
                    return;
                }

                if (number.value < 0) {
                    alert.innerHTML = 'Номер не може бути від\'ємним';
                    alert.classList.remove('d-none');
                    return;
                }

                if (cost.value == '') {
                    alert.innerHTML = 'Введіть ціну';
                    alert.classList.remove('d-none');
                    return;
                }

                if (sleep.value == '') {
                    alert.innerHTML = 'Введіть кількість спальних місць';
                    alert.classList.remove('d-none');
                    return;
                }



                let xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= base_url('manager/rooms/update') ?>', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onload = () => {
                    if (xhr.status == 200) {
                        window.location.href = '<?= base_url('manager/rooms') ?>';
                    } else {
                        console.error('Server returned an error');
                    }
                };

                xhr.onerror = function() {
                    console.error('Connection error');
                };

                xhr.send(JSON.stringify({
                    'id': id,
                    'number': number.value,
                    'cost_r': cost.value,
                    'beds_num': sleep.value,
                    'description': details.value,
                    'type_id': type.value,
                }));
            });

        });
    </script>

</body>

</html>
</body>

</html>