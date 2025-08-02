<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container my-4">
    <h2>Editar anuncio</h2>

    <?= form_open("/mis-anuncios/update/{$ad['id']}") ?>

    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="title" class="form-control" value="<?= esc($ad['title']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Precio</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?= esc($ad['price']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Estado</label>
        <select name="status" class="form-select">
            <option value="draft"   <?= $ad['status'] === 'draft'   ? 'selected' : '' ?>>Borrador</option>
            <option value="active"  <?= $ad['status'] === 'active'  ? 'selected' : '' ?>>Activo</option>
            <option value="paused"  <?= $ad['status'] === 'paused'  ? 'selected' : '' ?>>Pausado</option>
            <option value="sold"    <?= $ad['status'] === 'sold'    ? 'selected' : '' ?>>Vendido</option>
        </select>
    </div>

    <button class="btn btn-primary">Guardar cambios</button>
    <a href="/mis-anuncios" class="btn btn-secondary">Cancelar</a>

    <?= form_close() ?>
</div>
<?= $this->endSection() ?>