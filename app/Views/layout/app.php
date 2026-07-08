<?php require_once __DIR__ . '/header.php'; ?>
<?php require_once __DIR__ . '/navbar.php'; ?>
<?php require_once __DIR__ . '/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <!-- O conteúdo da view específica será renderizado aqui -->
            <?php require_once $viewFile; ?>
        </div>
    </section>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
