<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Reestablezca su cuenta en DevWebCamp.</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <form class="formulario" method="POST" action="/olvide">
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

        <input class="formulario__submit" type="submit" value="Enviar instrucciones" />
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/login">¿Ya posee una cuenta? Inicie sesión</a>
        <a class="acciones__enlace" href="/registro">¿Aún no tiene cuenta? Obtenga una</a>
    </div>
</main>