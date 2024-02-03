<ul class="nav nav-tabs" id="myTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="search-tab" href="<?= base_url('administrator/orders/view') ?>" role="tab">Перегляд</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="register-tab" href="<?= base_url('administrator/orders/create') ?>" role="tab">Створення</a>
    </li>
</ul>

<div class="container mt-4">
    <div class="row align-items-end">
        <div class="col-12 col-md-2">
            <label for="number" class="form-label mb-3">Номер</label>
            <input list="number_list" type="number" class="form-control mt-1" id="number_r" name="number">

            <datalist id="number_list">
                <?php foreach ($rooms as $room) : ?>
                    <option id="<?= $room->id ?>" value="<?= $room->number ?>"></option>
                <?php endforeach; ?>
            </datalist>
        </div>

        <div class="col-12 col-md-2">
            <label for="worker_datalist" class="form-label mb-3">Виконавець</label>
            <input list="worker_list" id="worker_datalist" class="form-control mt-1" name="worker_datalist" />

            <datalist id="worker_list">
                <?php foreach ($workers as $work) : ?>
                    <option id="<?= $work->id ?>" value="<?= $work->last_name . ' ' . $work->first_name . ' ' . $work->middle_name  ?>"></option>
                <?php endforeach; ?>
            </datalist>
        </div>

        <div class="col-12 col-md-8 d-flex justify-content-end">
            <button id="create_order" type="submit" class="btn btn-primary mt-3" style="background-color: #f48412; border-color:#f48412;">Створити замовлення</button>
        </div>
    </div>

    <div id="alert" class="row alert alert-danger d-none mt-4" role="alert">
    </div>

    <hr class="mt-4">

    <div class="d-flex align-items-center justify-content-between mt-4">
        <div>
            <label for="serv_datalist">Послуга</label>
            <input list="serv_list" id="serv_datalist" class="form-control mt-3" name="serv_datalist" />

            <datalist id="serv_list">
                <?php foreach ($services as $serv) : ?>
                    <option id="<?= $serv->id ?>" value="<?= $serv->name_s ?>"></option>
                <?php endforeach; ?>
            </datalist>
        </div>

        <button id="add_service" type="submit" class="btn btn-primary mt-4" style="background-color: #f48412; border-color:#f48412;">Додати</button>
    </div>

    <div class="row mt-4">
        <div class="col">
            <textarea id="coment" class="form-control" placeholder="Коментар"></textarea>
        </div>
    </div>

    <div id="alert_serv" class="row alert alert-danger d-none mt-4" role="alert">
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Послуга</th>
                        <th scope="col">Ціна</th>
                        <th scope="col">Коментар</th>
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
        let serv_datalist = document.getElementById('serv_datalist');
        let worker_datalist = document.getElementById('worker_datalist');
        let number_datalist = document.getElementById('number_datalist');

        const alert = document.getElementById('alert');
        const alert_serv = document.getElementById('alert_serv');
        const serv_list = document.getElementById('serv_list');
        const worker_list = document.getElementById('worker_list');
        const number_list = document.getElementById('number_list');

        let add_service_btn = document.getElementById('add_service');
        let create_order_btn = document.getElementById('create_order');

        let t_body = document.getElementById('t_body');

        const name_r = document.getElementById('number_r');
        const coment = document.getElementById('coment');

        let ser_info = <?= json_encode($services) ?>;
        let services = [];

        add_service_btn.addEventListener('click', add_service);

        create_order_btn.addEventListener('click', create_order);



        function add_service() {
            alert_serv.classList.add('d-none');
            if (serv_datalist.value == '') {
                alert_serv.innerHTML = 'Оберіть послугу';
                alert_serv.classList.remove('d-none');
                return;
            }

            let serv = serv_datalist.value;
            let cost_s = getServiceCost(serv);
            let com = coment.value;

            let optionExists = serv_list.querySelector(`option[value="${serv}"]`);
            if (!optionExists) {
                alert_serv.innerHTML = 'Введене значення не існує в списку послуг';
                alert_serv.classList.remove('d-none');
                return;
            }

            let serv_id = serv_list.querySelector(`option[value="${serv}"]`).id;
            if (serv == '') {
                alert_serv.innerHTML = 'Оберіть принаймні одну послугу';
                alert_serv.classList.remove('d-none');
                return;
            }

            if (services.some(service => service.serv_id === serv_id)) {
                alert_serv.innerHTML = 'Послуга вже додана';
                alert_serv.classList.remove('d-none');
                return;
            }

            let service = {
                id: services.length,
                serv_id: serv_id,
                com: com
            };

            services.push(service);

            let tr = document.createElement('tr');
            tr.id = `service-${service.id}`;
            tr.innerHTML = `
                <td>${serv}</td>
                <td>${cost_s}</td>
                <td>${com}</td>
                <td><button class="btn btn-danger" style="background-color: #F41812; border-color:#F41812;" onclick="window.del_service(${service.id})"><img src="/img/trash.png" alt="Logo" width="20" height="20"></button></td>
            `;

            t_body.appendChild(tr);

            serv_datalist.value = '';
            coment.value = '';

            alert_serv.classList.add('d-none');
        }


        window.del_service = function(serv_id) {
            serv_id = serv_id.toString();

            services = services.filter(service => service.serv_id == serv_id);

            let row = document.getElementById(`service-${serv_id}`);
            if (row) {
                row.remove();
            }
        }

        function create_order() {
            if (worker_datalist.value == '') {
                alert.innerHTML = 'Оберіть виконавця';
                alert.classList.remove('d-none');
                return;
            }


            let worker_id = worker_list.querySelector(`option[value="${worker_datalist.value}"]`).id;
            let number = name_r.value;

            let optionExists = number_list.querySelector(`option[value="${number}"]`);
            if (!optionExists) {
                alert.innerHTML = 'Введене значення не існує в списку заселених номерів';
                alert.classList.remove('d-none');
                return;
            }

            if (number == '') {
                alert.innerHTML = 'Введіть номер';
                alert.classList.remove('d-none');
                return;
            }

            if (services.length == 0) {
                alert.innerHTML = 'Оберіть принаймні одну послугу';
                alert.classList.remove('d-none');
                return;
            }

            let data = {
                room_num: number,
                worker_id: worker_id,
                services: services
            };

            alert.classList.add('d-none');

            xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/orders/create/create_order') ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (this.status == 200) {
                    let res = JSON.parse(this.responseText);
                    if (res.status == 'success') {
                        window.location.href = '<?= base_url('administrator/orders/view') ?>';
                    } else {
                        console.error('Server returned an error');
                    }
                } else {
                    console.error('Server returned an error');
                }
            }
            xhr.send(JSON.stringify(data));
        }

        function getServiceCost(serviceName) {
            for (let i = 0; i < ser_info.length; i++) {
                if (ser_info[i].name_s === serviceName) {
                    return ser_info[i].cost_s;
                }
            }
            return null;
        }
    });
</script>


</body>

</html>