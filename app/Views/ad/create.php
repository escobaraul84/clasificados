<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-3">
    <h2 class="mb-3">Publicar anuncio</h2>

    <?= view('auth/_messages') ?>

    <form action="/publish" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" class="form-control" name="title" value="<?= old('title') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select class="form-select" name="category_id" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio (USD)</label>
            <input type="number" step="0.01" class="form-control" name="price" value="<?= old('price') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="description" rows="4" required><?= old('description') ?></textarea>
        </div>

        <!-- Cámara / galería -->
        <div class="mb-3">
            <label class="form-label">Fotos (hasta 5)</label>
            <input type="file" class="form-control" name="images[]" multiple accept="image/*"
                   onchange="previewFiles(this.files)">
            <small class="text-muted">En móvil podrás usar la cámara</small>
            <div id="preview" class="row mt-2"></div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Publicar</button>
    </form>
</div>

<!-- Preview de fotos -->
<script>
function previewFiles(files) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    [...files].slice(0, 5).forEach(file => {
        const col = document.createElement('div');
        col.className = 'col-4 col-sm-3 col-md-2 mb-2';
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'img-fluid rounded';
        col.appendChild(img);
        preview.appendChild(col);
    });
}
</script>
<?= $this->endSection() ?>