<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php
        if ($token_valido) {
    ?>

            <form class="formulario" method="POST">
                <div class="formulario__campo">
                    <label class="formulario__label" for="contrasena">Contraseña:</label>
                    <input
                        class="formulario__input" 
                        type="password" 
                        id="contrasena" 
                        name="contrasena" 
                        placeholder="Ingrese su nueva contraseña."
                    />
                </div>

                <input class="formulario__submit" type="submit" value="Guardar contraseña" />
            </form>
    <?php
        }
    ?>

    <div class="acciones">
        <a class="acciones__enlace" href="/login">¿Ya posee una cuenta? Inicie sesión</a>
        <a class="acciones__enlace" href="/registro">¿Aún no tiene cuenta? Obtenga una</a>
    </div>
</main>