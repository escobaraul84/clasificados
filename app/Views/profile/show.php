<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card">
        <div class="row g-0">
            <div class="col-md-4 text-center p-3">
                <img src="<?= esc($user['avatar_url'] ?? 'https://via.placeholder.com/150') ?>" 
                     class="rounded-circle img-fluid" width="150">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($user['full_name']) ?></h5>
                    <p class="card-text">
                        <strong>Registrado:</strong> <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                    </p>

                    <?php if ($user['phone']): ?>
                        <a href="https://wa.me/54<?= $user['phone'] ?>" class="btn btn-success me-2">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="tel:+54<?= $user['phone'] ?>" class="btn btn-primary me-2">
                            <i class="fas fa-phone"></i> Llamar
                        </a>
                    <?php endif; ?>

                    <a href="mailto:<?= $user['email'] ?>" class="btn btn-info">
                        <i class="fas fa-envelope"></i> E-mail
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>