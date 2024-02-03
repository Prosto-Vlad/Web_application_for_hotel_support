<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Номер</th>
            <th scope="col">ПІБ клієнта</th>
            <th scope="col">Завдання</th>
            <th scope="col">Побажання</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody id="t_body">

    </tbody>
</table>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const t_body = document.getElementById('t_body');

        update_table();

        function update_table() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/worker/tasks/load', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                let data = JSON.parse(this.responseText);
                let tasks = data.data;
                t_body.innerHTML = '';
                for (let i = 0; i < tasks.length; i++) {
                    let tr = document.createElement('tr');
                    tr.innerHTML = '<th>' + tasks[i].number + '</th>' +
                        '<td>' + tasks[i].last_name + ' ' + tasks[i].first_name + ' ' + tasks[i].middle_name + ' ' + '</td>' +
                        '<td>' + tasks[i].details + '</td>' +
                        '<td>' + tasks[i].notes + '</td>' +
                        '<td><input type="checkbox" value="' + tasks[i].id + '" ' + (tasks[i].is_finish == 't' ? 'checked' : '') + ' onchange="window.finish(this.value, this.checked)" ></td>';
                    t_body.appendChild(tr);
                }
            }
            xhr.send();
        }

        window.finish = function(id, isChecked) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/worker/tasks/update', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                update_table();
            }
            xhr.send(JSON.stringify({
                id: id,
                is_finished: isChecked
            }));
        }
    });
</script>
</body>

</html>