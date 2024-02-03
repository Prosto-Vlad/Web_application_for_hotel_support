<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $service[0]->name_s ?></title>
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
                <a href="<?= base_url('manager/services') ?>"><img src="/img/back.png" alt="UPD" width="50" height="50"></a>
            </div>
            <div class="navbar-nav d-flex ms-auto align-items-center">
                <img src="/img/logo.png" alt="Logo" width="50" height="50">
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class=" row">
            <div class="col">
                <label for="name" class="form-label ">Назва</label>
                <input type="text" class="form-control" id="name_add" name="name" value="<?= $service[0]->name_s ?>">
            </div>
            <div class="col">
                <label for="cost" class="form-label">Ціна</label>
                <input type="text" class="form-control" id="cost_add" name="cost" value="<?= $service[0]->cost_s ?>">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="details" class="form-label ">Опис</label>
                <input type="text" class="form-control" id="details_add" name="details" value="<?= $service[0]->details ?>">
            </div>
        </div>

        <div class="row mt-4 d-flex">
            <div class="col ms-auto">
                <button id="upd_serv" type="button" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Зберегти</button>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const upd_serv_btn = document.getElementById('upd_serv');

            const id = <?= $service[0]->id ?>;
            const name = document.getElementById('name_add');
            const cost = document.getElementById('cost_add');
            const details = document.getElementById('details_add');

            upd_serv_btn.addEventListener('click', () => {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= base_url('manager/services/update') ?>', true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onload = () => {
                    if (xhr.status == 200) {
                        window.location.href = '<?= base_url('manager/services') ?>';
                    } else {
                        console.error('Server returned an error');
                    }
                };

                xhr.onerror = function() {
                    console.error('Connection error');
                };

                xhr.send(JSON.stringify({
                    'id': id,
                    'name': name_add.value,
                    'cost': cost_add.value,
                    'details': details_add.value,
                }));
            });

        });
    </script>

</body>

</html>