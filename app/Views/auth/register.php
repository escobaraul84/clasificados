<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4" style="max-width: 420px">
    <h3>Registro</h3>
    <?= view('auth/_messages') ?>
    <form action="/register" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" class="form-control" name="full_name" value="<?= old('full_name') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" class="form-control" name="email" value="<?= old('email') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" class="form-control" name="pass_confirm">
        </div>
        <button class="btn btn-primary w-100">Crear cuenta</button>
    </form>
    <p class="mt-3 text-center">
        ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
    </p>
</div>
<?= $this->endSection() ?>