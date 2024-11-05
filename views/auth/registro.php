<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Crear cuenta en DevWebCamp.</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/registro">
        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre:</label>
            <input
                class="formulario__input" 
                type="text" 
                id="nombre" 
                name="nombre" 
                placeholder="Nombre1 Nombre2" 
                value="<?php echo $usuario->nombre; ?>" 
            />
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="apellido">Apellido:</label>
            <input
                class="formulario__input" 
                type="text" 
                id="apellido" 
                name="apellido" 
                placeholder="Apellido1 Apellido2"
                value="<?php echo $usuario->apellido; ?>" 
            />
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="correo">Correo electrónico:</label>
            <input
                class="formulario__input" 
                type="text" 
                id="correo" 
                name="correo" 
                placeholder="Ingrese su correo electrónico."
                value="<?php echo $usuario->correo ?>" 
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

        <div class="formulario__campo">
            <label class="formulario__label" for="contrasena2">Repetir contraseña:</label>
            <input
                class="formulario__input" 
                type="password" 
                id="contrasena2" 
                name="contrasena2" 
                placeholder="Ingrese su contraseña de nuevo." 
            />
        </div>

        <input class="formulario__submit" type="submit" value="Crear cuenta" />
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/login">¿Ya posee una cuenta? Inicie sesión</a>
        <a class="acciones__enlace" href="/olvide">¿Olvidó su contraseña?</a>
    </div>
</main>