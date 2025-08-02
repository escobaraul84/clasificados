<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <!-- carrusel 0 -->
    <?php if (!empty($promoted)): ?>
    <section class="mb-5">
        <div class="container">
            <h4 class="mb-3">Anuncios destacados</h4>

            <div class="row g-2">
                <!-- Banner izquierdo (placeholder) -->
                <div class="col-lg-2 d-none d-lg-block">
                    <div class="bg-light border rounded text-center p-3" style="height:220px;">
                        <span class="text-muted small">Espacio publicitario<br>(Google / Amazon)</span>
                    </div>
                </div>

                <!-- Carrusel central (3 anuncios) -->
                <div class="col-lg-8">
                    <div id="miniCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-inner">
                            <?php foreach (array_chunk($promoted, 3) as $index => $chunk): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <div class="row g-2">
                                        <?php foreach ($chunk as $ad): ?>
                                            <div class="col-4">
                                                <div class="card h-100">
                                                    <img src="<?= esc($ad['image_url'] ?? '/uploads/default.jpg') ?>"
                                                        class="card-img-top" style="height:160px; object-fit:cover;">
                                                        <!-- Pixel de impresión -->
                                                        <img src="/i/<?= $ad['id'] ?>" width="1" height="1" alt="" style="display:none;">
                                                    <div class="card-body p-2">
                                                        <span class="badge bg-warning mb-1">Promo</span>
                                                        <h6 class="card-title small"><?= esc($ad['title']) ?></h6>
                                                        <span class="fw-bold">$<?= number_format($ad['price'], 2) ?></span>
                                                    </div>
                                                    <a href="/ad/<?= $ad['id'] ?>-<?= $ad['slug'] ?>" class="stretched-link"></a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Flechas -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#miniCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#miniCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
                        </button>
                    </div>
                </div>

                <!-- Banner derecho (placeholder) -->
                <div class="col-lg-2 d-none d-lg-block">
                    <div class="bg-light border rounded text-center p-3" style="height:220px;">
                        <span class="text-muted small">Espacio publicitario<br>(Google / Amazon)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- bloques de anuncios -->
    <div class="row">
        <?php foreach ($ads as $ad): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= esc($ad['image_url'] ?? '/uploads/default.jpg') ?>" class="img-fluid">
                        <!-- Pixel de impresión -->
                        <img src="/i/<?= $ad['id'] ?>" width="1" height="1" alt="" style="display:none;">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($ad['title']) ?></h5>
                        <p class="text-muted">$<?= number_format($ad['price'], 2) ?></p>
                        <a href="/ad/<?= $ad['id'] ?>-<?= $ad['slug'] ?>" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?= $pager->links('default', 'default_full') ?>
</div>
<?= $this->endSection() ?>