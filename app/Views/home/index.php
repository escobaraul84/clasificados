<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>

    <div class="row">
        <?php foreach ($ads as $ad): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- <img src="<?= esc($ad['image_url'] ?? 'https://via.placeholder.com/300') ?>" class="card-img-top" alt="">  -->
                    <img src="<?= esc($ad['image_url'] ?? '/uploads/default.jpg') ?>" class="img-fluid">
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