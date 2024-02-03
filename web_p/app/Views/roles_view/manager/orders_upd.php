<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $order->id . ' ' . $order->number; ?></title>
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
                <a href="<?= base_url('manager/orders') ?>"><img src="/img/back.png" alt="UPD" width="50" height="50"></a>
            </div>
            <div class="navbar-nav d-flex ms-auto align-items-center">
                <img src="/img/logo.png" alt="Logo" width="50" height="50">
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-4">
                <label for="number" class="form-label mt-3">Номер</label>
                <input type="number" class="form-control" id="number_r" name="number" disabled value="<?= $order->number ?>">
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-4">
                <label class="form-label mt-3">ПІБ виконався</label>
                <div class="input-group">
                    <input type="text" aria-label="Last name" id="work_last_name_upd" class="form-control" placeholder="Прізвище" disabled value="<?= $order->worker_last_name ?>">
                    <input type="text" aria-label="First name" id="work_first_name_upd" class="form-control" placeholder="Ім'я" disabled value="<?= $order->worker_first_name ?>">
                    <input type="text" aria-label="Middle name" id="work_middle_name_upd" class="form-control" placeholder="Патронім" disabled value="<?= $order->worker_middle_name ?>">
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-4">
                <label class="form-label mt-3">ПІБ клієнта</label>
                <div class="input-group">
                    <input type="text" aria-label="Last name" id="cust_last_name_upd" class="form-control" placeholder="Прізвище" disabled value="<?= $order->cust_last_name ?>">
                    <input type="text" aria-label="First name" id="cust_first_name_upd" class="form-control" placeholder="Ім'я" disabled value="<?= $order->cust_first_name ?>">
                    <input type="text" aria-label="Middle name" id="work_middle_name_upd" class="form-control" placeholder="Патронім" disabled value="<?= $order->cust_middle_name ?>">
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-4">
                <label for="number" class="form-label mt-3">Дата створення</label>
                <input type="date" class="form-control" id="create_date" disabled name="create_date" value="<?= $order->create_date ?>">
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-4">
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="paymentCheck" <?= $order->is_payed == 'f' ? '' : 'checked' ?>>
                    <label class="form-check-label" for="paymentCheck">
                        Оплачено
                    </label>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Послуга</th>
                            <th scope="col">Коментар</th>
                            <th scope="col">Ціна</th>
                            <th scope="col">Виконання</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="t_body">
                        <?php foreach ($tasks as $task) : ?>
                            <tr>
                                <td><?= $task->name_s ?></td>
                                <td><?= $task->notes ?></td>
                                <td><?= $task->cost_s ?></td>
                                <td><input type="checkbox" <?= $task->is_finish == 'f' ? '' : 'checked' ?> disabled></td>
                                <td>
                                    <button type="button" style="background-color: #F41812; border-color:#F41812;" class="btn btn-danger" onclick="window.delete_task(<?= $task->id ?>)"><img src="/img/trash.png" alt="Register" width="20" height="20"></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const paymentCheck = document.getElementById('paymentCheck');
            const number = document.getElementById('number_r');
            const create_date = document.getElementById('create_date');

            const worker_id = <?= $order->worker_id ?>;
            const room_id = <?= $order->room_id ?>;
            const is_finish_str = '<?= $order->is_finish ?>';

            if (is_finish_str == 'f') {
                is_finish = false;
            } else {
                is_finish = true;
            }

            paymentCheck.addEventListener('change', () => {
                let xhr = new XMLHttpRequest();

                let data = {
                    id: <?= $order->id ?>,
                    is_payed: paymentCheck.checked,
                    is_finish: is_finish,
                    number: number.value,
                    create_date: create_date.value,
                    worker_id: worker_id,
                    room_id: room_id,
                };

                xhr.open('POST', '/manager/orders/update', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send(JSON.stringify(data));
            });

            window.delete_task = function(id) {
                let xhr = new XMLHttpRequest();

                let data = {
                    id: id,
                    order_id: <?= $order->id ?>
                };

                xhr.open('POST', '/manager/orders/delete_task', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        let res = JSON.parse(xhr.responseText);
                        if (res.status == 'success_end') {
                            window.location.href = '/administrator/orders/view';
                        } else if (res.status == 'success') {
                            location.reload();
                        }
                    } else {
                        alert('Помилка');
                    }
                }
                xhr.send(JSON.stringify(data));
            }
        });
    </script>
</body>

</html>