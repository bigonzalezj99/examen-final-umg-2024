<main class="auth">
<h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php
        if (isset($alertas['exito'])) {
    ?>
            <div class="acciones--centrar">
                <a class="acciones__enlace" href="/login">Iniciar sesión</a>
            </div>
    <?php
        }
    ?>
</main>