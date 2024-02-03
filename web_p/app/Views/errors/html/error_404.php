<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= lang('Errors.pageNotFound') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center min-vh-100" style="background-color: #f7a859;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h1>404</h1>
                        <p>
                            <?php if (ENVIRONMENT !== 'production') : ?>
                                <?= nl2br(esc($message)) ?>
                            <?php else : ?>
                                <?= lang('Errors.sorryCannotFind') ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
