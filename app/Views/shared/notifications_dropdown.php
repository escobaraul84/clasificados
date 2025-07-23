<?php
$notifs = $notifs ?? [];
$count  = count($notifs);
?>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle position-relative" href="#" id="notifDropdown" role="button"
       data-bs-toggle="dropdown" aria-expanded="false"
       onclick="markRead()">
        <i class="fas fa-bell"></i>
        <?php if ($count): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger pulse">
                <?= $count ?>
            </span>
        <?php endif; ?>
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="min-width: 320px;">
        <li class="dropdown-header">Notificaciones</li>
        <?php if ($count): ?>
            <?php foreach ($notifs as $n): ?>
                <li>
                    <a class="dropdown-item small" href="/ad/<?= $n['ad_id'] ?>">
                        <?= esc($n['message']) ?>
                        <br>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></small>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li><span class="dropdown-item text-muted">Sin notificaciones aún</span></li>
        <?php endif; ?>
    </ul>
</li>

<!-- Script para marcar leídas vía AJAX -->
<script>
function markRead() {
    fetch('/notifications/mark-read', {method: 'POST'})
        .then(r => r.json())
        .then(() => {
            document.querySelector('#notifDropdown .badge')?.remove();
        });
}
</script>