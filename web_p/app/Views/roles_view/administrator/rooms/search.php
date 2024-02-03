<ul class="nav nav-tabs" id="myTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="search-tab" href="<?= base_url('administrator/rooms/search') ?>">Пошук</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link " id="register-tab" href="<?= base_url('administrator/rooms/register') ?>">Реєстрація</a>
    </li>
</ul>



<div class="container mt-4">
    <form>
        <div class="row">
            <div class="col-3">
                <label for="number" class="form-label">Номер</label>
                <input type="number" class="form-control" id="number_r" name="number">
            </div>
            <div class="col-3">
                <label for="beds_num" class="form-label">Кількість місць</label>
                <input type="number" class="form-control" id="beds_num" name="beds_num">
            </div>
            <div class="col-3">
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
            <div class="col-3">
                <label for="date_from" class="form-label">Дата з</label>
                <input type="date" class="form-control" id="date_from" name="date_from">
            </div>
            <div class="col-3">
                <label for="date_to" class="form-label">Дата по</label>
                <input type="date" class="form-control" id="date_to" name="date_to">
            </div>
            <div class="col-3">
                <label for="type" class="form-label">Статус</label>
                <select id="status" class="form-select" id="type" name="type">
                    <option value=""></option>
                    <option value="free">Вільний</option>
                    <option value="armor">Заброньований</option>
                    <option value="settle">Заселений</option>
                </select>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-3">
                <label for="cost_r" class="form-label">Мінімальна ціна</label>
                <input type="number" class="form-control" id="cost_r_min" name="cost_r">
            </div>
            <div class="col-3">
                <label for="cost_r" class="form-label">Максимальна ціна</label>
                <input type="number" class="form-control" id="cost_r_max" name="cost_r">
            </div>
        </div>
    </form>

    <div class="row mt-4">
        <div class="col-3">
            <button id="submit" type="submit" class="btn btn-primary mt-2" style="background-color: #f48412; border-color:#f48412;">Пошук</button>
        </div>
    </div>

    <!-- Вивід -->
    <div class="row mt-4">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Номер</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Кількість місць</th>
                        <th scope="col">Ціна</th>
                        <th scope="col">Опис</th>
                        <th scope="col">Дата</th>
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
        const number_r = document.getElementById('number_r');
        const type = document.getElementById('type');
        const beds_num = document.getElementById('beds_num');
        const cost_r_min = document.getElementById('cost_r_min');
        const cost_r_max = document.getElementById('cost_r_max');
        const date_from = document.getElementById('date_from');
        const date_to = document.getElementById('date_to');
        const status = document.getElementById('status');
        const t_body = document.getElementById('t_body');

        load_table();

        document.getElementById('submit').addEventListener('click', load_table)

        function load_table() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/rooms/search/search_room') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    reload_table();
                } else {
                    console.error('Server returned an error');
                }
            };

            function reload_table() {
                let search_results = JSON.parse(xhr.responseText)['data'];

                t_body.innerHTML = '';
                for (let i = 0; i < search_results.length; i++) {
                    let tr = document.createElement('tr');
                    tr.innerHTML = '<th>' + search_results[i].number + '</th>';
                    let tmp = '<td>' +
                        '<select id="' + search_results[i].settlement_id + '" class="form-select table-select" name="type">';
                    if (search_results[i].is_settled == "t") {
                        tmp += '<option value="free">Вільний</option>' +
                            '<option value="armor">Заброньований</option>' +
                            '<option value="settle" selected>Заселений</option>';
                    } else if (search_results[i].is_settled == "f") {
                        tmp += '<option value="free">Вільний</option>' +
                            '<option value="armor" selected>Заброньований</option>' +
                            '<option value="settle">Заселений</option>';
                    } else {
                        tmp = '<td> <select id="' + search_results[i].settlement_id + '" class="form-select table-select" name="type" disabled>' +
                            '<option value="free" selected >Вільний</option>' +
                            '<option value="armor">Заброньований</option>' +
                            '<option value="settle">Заселений</option>';
                    }
                    tr.innerHTML += tmp + '</select>' +
                        '</td>' +
                        '<td>' + search_results[i].t_name + '</td>' +
                        '<td>' + search_results[i].beds_num + '</td>' +
                        '<td>' + search_results[i].cost_r + '</td>' +
                        '<td>' + search_results[i].description + '</td>';
                    if (search_results[i].settlement_date != null) {
                        tr.innerHTML += '<td>' + search_results[i].settlement_date + ' - ' + search_results[i].eviction_date + '</td>';
                    } else {
                        tr.innerHTML += '<td></td>';
                    }
                    t_body.appendChild(tr);
                }
                let select = document.getElementsByClassName('table-select');
                for (let i = 0; i < select.length; i++) {
                    select[i].addEventListener('change', () => {
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', '<?= base_url('administrator/rooms/search/update_room_status') ?>', true);
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        xhr.onload = () => {
                            if (xhr.status == 200) {
                                console.log(xhr.responseText);
                                if (Number.isInteger(parseInt(xhr.responseText))) {
                                    document.getElementById(xhr.responseText).disabled = true;
                                }
                            } else {
                                console.error('Server returned an error');
                            }
                        };

                        xhr.onerror = function() {
                            console.error('Connection error');
                        };
                        xhr.send('settlement_id=' + select[i].id + '&status=' + select[i].value);
                    });
                }

            }

            xhr.onerror = function() {
                console.error('Connection error');
            };
            //FIXME: Переробити складання JSON як в customer.php
            xhr.send(JSON.stringify({
                number: document.getElementById('number_r').value,
                type: document.getElementById('type').value,
                beds_num: document.getElementById('beds_num').value,
                min_price: document.getElementById('cost_r_min').value,
                max_price: document.getElementById('cost_r_max').value,
                booking_from: document.getElementById('date_from').value,
                booking_to: document.getElementById('date_to').value,
                status: document.getElementById('status').value
            }));

        }
    });
</script>
</body>

</html>