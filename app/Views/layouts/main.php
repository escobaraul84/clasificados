<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?= esc($title ?? 'Clasificados') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Clasificados</a>
            <div class="d-flex">
                <?php if (session()->get('logged_in')): ?>
                    <span class="navbar-text me-3">Hola, <?= esc(session('full_name')) ?></span>
                    <a class="btn btn-outline-light btn-sm" href="/logout">Salir</a>
                <?php else: ?>
                    <a class="btn btn-outline-light btn-sm" href="/login">Entrar</a>
                    <a class="btn btn-light btn-sm ms-2" href="/register">Registro</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?= $this->renderSection('content') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>