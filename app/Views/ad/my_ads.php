<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container my-4">
    <h2 class="mb-4">Mis anuncios</h2>

    <?php if (!$ads): ?>
        <div class="alert alert-info">Aún no has publicado ningún anuncio.</div>
        <a class="btn btn-primary" href="<?= site_url('ad/create') ?>">Publicar mi primer anuncio</a>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($ads as $ad): ?>
                <div class="col">
                    <div class="card h-100">
                        <!-- imagen miniatura -->
                        <img src="<?= esc($ad['image_url'] ?? '/img/no-image.jpg') ?>"
                            class="card-img-top" style="height:160px; object-fit:cover;" alt="">

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?= esc($ad['title']) ?></h6>
                            <p class="text-muted small mb-1">
                                Estado: <span class="badge bg-<?=
                                    $ad['status'] === 'active'  ? 'success' :
                                   ($ad['status'] === 'paused' ? 'warning' : 'secondary') ?>">
                                    <?= ucfirst($ad['status']) ?>
                                </span>
                            </p>
                            <p class="fw-bold text-primary mb-2">
                                $<?= number_format($ad['price'], 2) ?>
                            </p>

                            <div class="mt-auto">
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <a href="<?= site_url('mis-anuncios/edit/' . $ad['id']) ?>" class="btn btn-outline-primary">Editar</a>
                                    <button type="button" class="btn btn-outline-warning"
                                            onclick="toggleStatus(<?= $ad['id'] ?>, '<?= $ad['status'] ?>')">
                                        <?= $ad['status'] === 'active' ? 'Pausar' : 'Activar' ?>
                                    </button>
                                    <!-- Soft-delete -->
                                    <?= form_open("/mis-anuncios/delete/{$ad['id']}", ['class' => 'd-inline']) ?>
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('¿Marcar como borrado?')">
                                            Borrar
                                        </button>
                                    <?= form_close() ?>
                                    <?php if ($ad['status'] !== 'sold'): ?>
                                        <?= form_open("/mis-anuncios/sold/{$ad['id']}", ['class' => 'd-inline']) ?>
                                            <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('¿Marcar como vendido?')">
                                                Vendido
                                            </button>
                                        <?= form_close() ?>
                                    <?php else: ?>
                                        <span class="badge bg-success">Vendido</span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($ad['status'] === 'active'): ?>
                                    <a href="<?= site_url('mis-anuncios/promote/' . $ad['id']) ?>"
                                    class="btn btn-sm btn-warning">
                                        Destacar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>