
    <h1>Профіль</h1>
    
    <p>Ім'я: <?= esc($first_name) ?></p>
    <p>Прізвище: <?= esc($last_name) ?></p>
    <p>ID ролі: <?= esc($role_id) ?></p>

    <IMG SRC="/img/administrator.jpg">

    <a href="<?= base_url('logout') ?>">Вийти</a>

</body>

</html>