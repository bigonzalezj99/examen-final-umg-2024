<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Inicie sesión en DevWebCamp.</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/login">
        <div class="formulario__campo">
            <label class="formulario__label" for="correo">Correo electrónico:</label>
            <input
                class="formulario__input" 
                type="text" 
                id="correo" 
                name="correo" 
                placeholder="Ingrese su correo electrónico."
            />
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="contrasena">Contraseña:</label>
            <input
                class="formulario__input" 
                type="password" 
                id="contrasena" 
                name="contrasena" 
                placeholder="Ingrese su contraseña." 
            />
        </div>

        <input class="formulario__submit" type="submit" value="Iniciar sesión" />
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/registro">¿Aún no tiene cuenta? Obtenga una</a>
        <a class="acciones__enlace" href="/olvide">¿Olvidó su contraseña?</a>
    </div>
</main>