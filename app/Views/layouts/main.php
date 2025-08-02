<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?= esc($title ?? 'Clasificados') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tus estilos propios -->
    <link rel="stylesheet" href="/css/home.css">

</head>
<body>
    <!-- CSS propio -->
    <link rel="stylesheet" href="/css/navbar.css">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-store me-1"></i>ClasiMarket
            </a>

            <!-- Buscador centrado -->
            <form class="mx-auto d-flex navbar-search" action="/search" method="get">
                <input class="form-control me-2" type="search" name="q" placeholder="¿Qué estás buscando?">
                <button class="btn btn-light" type="submit"><i class="fas fa-search"></i></button>
            </form>

            <!-- Botón móvil (si acaso se necesita) -->
            <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#userActions">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Lo que se colapsa (en móvil) -->
            <div class="collapse navbar-collapse" id="userActions">
                <!-- Menú de navegación -->
                <ul class="navbar-nav me-auto">
                    <?php if (session()->get('logged_in')): ?>
                        <li class="nav-item"><a class="nav-link" href="/mis-anuncios">Mis anuncios</a></li>
                        <li class="nav-item"><a class="nav-link" href="/publish">Publicar</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="/ad/create">Publicar</a></li> -->
                    <?php endif; ?>
                </ul>

                <!-- Bloque final ORIGINAL (sin <li>) -->
                <div class="d-flex align-items-center">
                    <?php if (session()->get('logged_in')): ?>
                        <span class="navbar-text me-3 text-white">Hola, <?= esc(session('full_name')) ?></span>
                        <a class="btn btn-outline-light btn-sm" href="/logout">Salir</a>
                    <?php else: ?>
                        <a class="btn btn-outline-light btn-sm" href="/login">Entrar</a>
                        <a class="btn btn-light btn-sm ms-2" href="/register">Registro</a>
                    <?php endif; ?>
                    <?php if (session()->get('logged_in')): ?>
                        <?= view('shared/notifications_dropdown', ['notifs' => $notifs ?? []]) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?= $this->renderSection('content') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleStatus(id, current) {
        fetch(`/mis-anuncios/toggle/${id}`, {method: 'POST', headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then(res => res.json())
            .then(data => location.reload());
    }
    function confirmDelete(id) {
        if (confirm('¿Eliminar este anuncio?')) {
            fetch(`/mis-anuncios/delete/${id}`, {method: 'POST'}).then(() => location.reload());
        }
    }
    </script>
</body>
</html>