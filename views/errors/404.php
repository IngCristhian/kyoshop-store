<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-6 text-center">
            <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 6rem;"></i>

            <h1 class="display-1 fw-bold mt-4">404</h1>
            <h2 class="mb-4">Página no encontrada</h2>

            <p class="text-muted mb-4">
                <?= sanitize($message ?? 'La página que buscas no existe o ha sido movida.') ?>
            </p>

            <div class="d-grid gap-2 d-md-block">
                <a href="<?= APP_URL ?>" class="btn btn-primary btn-lg">
                    <i class="bi bi-house"></i> Ir al inicio
                </a>
                <a href="<?= APP_URL ?>/productos" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-grid"></i> Ver productos
                </a>
            </div>
        </div>
    </div>
</div>
