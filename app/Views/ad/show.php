<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active"><?= esc($ad['title']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-7">
            <!-- Carrusel de imágenes -->
            <div id="carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($images as $k => $img): ?>
                        <div class="carousel-item <?= $k === 0 ? 'active' : '' ?>">
                            <img src="<?= esc($img['url']) ?>" class="d-block w-100" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($images) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-5">
            <h2><?= esc($ad['title']) ?></h2>
            <h3 class="text-primary">$<?= number_format($ad['price'], 2) ?></h3>
            <p><?= esc($ad['description_md']) ?></p>
            <p><strong>Vendedor:</strong> <?= esc($ad['user_name']) ?></p>

            <?php if (session()->get('logged_in')): ?>
                <button class="btn btn-success">Contactar al vendedor</button>
            <?php else: ?>
                <a href="/login" class="btn btn-outline-primary">Inicia sesión para contactar</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>