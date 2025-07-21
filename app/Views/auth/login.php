<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4" style="max-width: 420px">
    <h3>Iniciar sesión</h3>
    <?= view('auth/_messages') ?>
    <form action="/login" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" class="form-control" name="email" value="<?= old('email') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button class="btn btn-primary w-100">Entrar</button>
    </form>
    <p class="mt-3 text-center">
        ¿No tienes cuenta? <a href="/register">Regístrate</a>
    </p>
</div>
<?= $this->endSection() ?>