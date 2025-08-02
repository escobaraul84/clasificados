<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Resultados de búsqueda</h2>

    <!-- Formulario de filtros -->
    <form class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="search" name="q" class="form-control" placeholder="Palabra clave" value="<?= esc($filters['q']) ?>">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="min" class="form-control" placeholder="Precio min" value="<?= esc($filters['minPrice']) ?>">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="max" class="form-control" placeholder="Precio max" value="<?= esc($filters['maxPrice']) ?>">
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="newest" <?= $filters['sort']==='newest'?'selected':'' ?>>Más nuevo</option>
                <option value="price_asc" <?= $filters['sort']==='price_asc'?'selected':'' ?>>Precio ↑</option>
                <option value="price_desc" <?= $filters['sort']==='price_desc'?'selected':'' ?>>Precio ↓</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <!-- Grilla igual que home -->
    <div class="row">
        <?php foreach ($ads as $ad): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= esc($ad['image_url'] ?? '/uploads/default.jpg') ?>" class="card-img-top" style="height:160px; object-fit:cover;">
                    <div class="card-body">
                        <h6 class="card-title"><?= esc($ad['title']) ?></h6>
                        <p class="fw-bold">$<?= number_format($ad['price'], 2) ?></p>
                        <a href="/ad/<?= $ad['id'] ?>-<?= $ad['slug'] ?>" class="btn btn-sm btn-primary">Ver</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?= $pager->links('default', 'default_full') ?>
</div>
<?= $this->endSection() ?>