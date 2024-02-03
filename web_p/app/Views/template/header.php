<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $first_name . ' ' . $last_name ?></title>
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
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="navbar-brand"><?= $first_name . ' ' . $last_name ?></a>

                    <?php foreach ($links as $link) : ?>
                        <a class="nav-link" href="<?= $link['url'] ?>"><?= $link['text'] ?></a>
                    <?php endforeach; ?>

                </div>
            </div>


            <div class="navbar-nav d-flex align-items-center">
                <a class="nav-link" href="<?= base_url('logout') ?>">Вихід</a>
                <img src="/img/logo.png" alt="Logo" width="50" height="50">
            </div>
        </div>
    </nav>