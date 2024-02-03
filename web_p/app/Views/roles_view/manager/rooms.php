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
        const number_r = document.getElementById('number_r');
        const type = document.getElementById('type');
        const beds_num = document.getElementById('beds_num');
        const cost_r_min = document.getElementById('cost_r_min');
        const cost_r_max = document.getElementById('cost_r_max');
        const t_body = document.getElementById('t_body');

        load_table();

        document.getElementById('submit').addEventListener('click', load_table)

        function load_table() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= base_url('manager/rooms/info') ?>', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = () => {
                if (xhr.status == 200) {
                    let search_results = JSON.parse(xhr.responseText)['data'];
                    console.log(search_results);
                    t_body.innerHTML = '';
                    for (let i = 0; i < search_results.length; i++) {
                        let tr = document.createElement('tr');
                        tr.innerHTML = '<th>' + search_results[i].number + '</th>' +
                            '<td>' + search_results[i].t_name + '</td>' +
                            '<td>' + search_results[i].beds_num + '</td>' +
                            '<td>' + search_results[i].cost_r + '</td>' +
                            '<td>' + search_results[i].description + '</td>';
                        tr.innerHTML += '<td><a style="background-color: #f48412; border-color:#f48412;" class="btn btn-primary" href="' + '<?= base_url('manager/rooms/update/') ?>' + search_results[i].id + '"><img src="/img/edit.png" alt="UPD" width="25" height="25"></a></td>'
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
                number: document.getElementById('number_r').value,
                type: document.getElementById('type').value,
                beds_num: document.getElementById('beds_num').value,
                min_price: document.getElementById('cost_r_min').value,
                max_price: document.getElementById('cost_r_max').value,
            }));

        }
    });
</script>
</body>

</html>