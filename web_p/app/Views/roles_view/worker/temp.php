<!-- <!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
</head>

<body> -->

    <h1>Профіль</h1>
    
    <p>Ім'я: <?= esc($first_name) ?></p>
    <p>Прізвище: <?= esc($last_name) ?></p>
    <p>ID ролі: <?= esc($role_id) ?></p>

    <img src="/img/worker.jpg">

    <a href="<?= base_url('logout') ?>">Вийти</a>

</body>

</html>