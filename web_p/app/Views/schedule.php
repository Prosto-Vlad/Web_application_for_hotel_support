<div class="text-center mt-4">
    <button id="butt_prev" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">
        <img src="/img/back.png" alt="Logo" width="20" height="20">
    </button>
    <button id="butt_now" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">Поточний місяць</button>
    <button id="butt_next" class="btn btn-primary" style="background-color: #f48412; border-color:#f48412;">
        <img src="/img/next.png" alt="Logo" width="20" height="20">
    </button>
</div>

<div class="d-flex justify-content-center align-items-center mt-3">
    <h3><output id="out"></output></h2>
</div>

<div class="container mt-3">
    <div class="header">
        <div>
            ПОНЕДІЛОК
        </div>
        <div>
            ВІВТОРОК
        </div>
        <div>
            СЕРЕДА
        </div>
        <div>
            ЧЕТВЕР
        </div>
        <div>
            ПЯТНИЦЯ
        </div>
        <div>
            СУБОТА
        </div>
        <div>
            НЕДІЛЯ
        </div>
    </div>

    <div id="schedule_body">

    </div>
</div>

<script>
    const month_list = {
        0: 'Січень',
        1: 'Лютий',
        2: 'Березень',
        3: 'Квітень',
        4: 'Травень',
        5: 'Червень',
        6: 'Липень',
        7: 'Серпень',
        8: 'Вересень',
        9: 'Жовтень',
        10: 'Листопад',
        11: 'Грудень'
    }

    make_schedule(0);

    let shift = 0;

    document.getElementById('butt_prev').addEventListener('click', function() {
        shift--;
        make_schedule(shift);
    });

    document.getElementById('butt_now').addEventListener('click', function() {
        shift = 0;
        make_schedule(shift);
    });

    document.getElementById('butt_next').addEventListener('click', function() {
        shift++;
        make_schedule(shift);
    });

    function make_schedule(shift_month) {
        let date_box = Array();

        let date = new Date();
        date.setMonth(date.getMonth() + shift_month);

        let month = date.getMonth();
        let year = date.getFullYear();

        date.setDate(1);

        while (date.getDay() != 1) {
            date.setDate(date.getDate() - 1);
        }

        for (let i = 0; i < 5 * 7; i++) {
            date_box.push(new Date(date));
            date.setDate(date.getDate() + 1);
        }

        let schedule_body = document.getElementById('schedule_body');
        let schedule = JSON.parse('<?= $schedule ?>');

        schedule_body.innerHTML = '';

        for (let j = 0; j < date_box.length; j++) {
            let day = document.createElement('div');
            day.innerHTML = '<div class="number">' + date_box[j].getDate() + '</div>';

            if (schedule[date_box[j].getDay()] != undefined) {
                day.innerHTML += schedule[date_box[j].getDay()].start + " - " + schedule[date_box[j].getDay()].end;
            }

            if (date_box[j].getMonth() == month) {
                day.classList.add('cur_month');
            } else {
                day.classList.add('not_cur_month');
            }

            if (date_box[j].getDate() == new Date().getDate() && date_box[j].getMonth() == new Date().getMonth() && date_box[j].getFullYear() == new Date().getFullYear()) {
                day.classList.add('cur_day');
            }

            document.getElementById('out').innerHTML = year + " " + month_list[month];

            schedule_body.appendChild(day);
        }



    }
</script>

<style>
    .container {
        display: grid;
        grid-template-rows: 1fr 20fr;
        gap: 0px 0px;
    }

    .container div {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
    }

    .container div div {
        display: block;
    }

    .cur_month {
        background-color: #f4a312;
        border: solid 1px black;
    }

    .not_cur_month {
        background-color: #f48412;
        border: solid 1px black;
    }

    .cur_day {
        background-color: #f4d312;
    }

    .number {
        padding-left: 5px;
    }

    .header {
        text-align: center;
    }
</style>

</body>

</html>