<ul class="nav nav-tabs" id="myTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="search-tab" href="<?= base_url('administrator/orders/view') ?>" role="tab">Перегляд</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="register-tab" href="<?= base_url('administrator/orders/create') ?>" role="tab">Створення</a>
    </li>
</ul>

<div class="container mt-4">
    <div class="row">
        <div class="col-12 col-md-2">
            <label for="number" class="form-label">Номер</label>
            <input type="number" class="form-control mt-3" id="number_r" name="number">
        </div>

        <div class="col-12 col-md-2">
            <label for="create_date" class="form-label">Дата створення</label>
            <input type="date" class="form-control mt-3" id="create_date" name="discount">
        </div>

        <div class="col-12 col-md-8 d-flex align-items-end justify-content-end">
            <button id="search_btn" type="submit" class="btn btn-primary mt-5" style="background-color: #f48412; border-color:#f48412;">Пошук</button>
        </div>
    </div>

    <div clas="row">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Номер</th>
                        <th scope="col">ПІБ клієнта</th>
                        <th scope="col">Дата створення</th>
                        <th scope="col">Оплачено</th>
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
        let t_body = document.getElementById('t_body');

        let number_r = document.getElementById('number_r');
        let create_date = document.getElementById('create_date');

        let search_btn = document.getElementById('search_btn');

        search_order()

        search_btn.addEventListener('click', search_order);

        function search_order() {
            let number = number_r.value;
            let date = create_date.value;

            let data = {
                number: number,
                create_date: date
            };

            xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('administrator/orders/view/search') ?>');
            xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (xhr.status != 200) {
                    alert(`Помилка ${xhr.status}: ${xhr.statusText}`);
                } else {
                    let res_data = JSON.parse(xhr.responseText).data;
                    console.log(res_data);
                    t_body.innerHTML = '';
                    for (let i = 0; i < res_data.length; i++) {
                        if (res_data[i].is_finish != 't') {
                            let tr = document.createElement('tr');
                            tr.innerHTML = '<th>' + res_data[i].number + '</th>' +
                                '<th>' + res_data[i].last_name + ' ' + res_data[i].first_name + ' ' + res_data[i].middle_name + '</th>' +
                                '<th>' + res_data[i].create_date + '</th>';
                            if (res_data[i].is_payed == 't') {
                                tr.innerHTML += '<th>Так</th>';
                            } else {
                                tr.innerHTML += '<th>Ні</th>';
                            }
                            tr.innerHTML += '<th><a href="<?= base_url('administrator/orders/view') ?>/' + res_data[i].id + '" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;"><img src="/img/more.png" alt="Logo" width="20" height="20"></a></th>';

                            t_body.appendChild(tr);
                        }
                    }

                }
            };
            xhr.send(JSON.stringify(data));

        };
    });
</script>

</body>

</html>