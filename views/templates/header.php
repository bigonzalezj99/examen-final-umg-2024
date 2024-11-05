<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php
                if(isAuth()) {
                    if(isAdmin()) {
            ?>
                        <a class="header__enlace" href="/admin/dashboard">Administrar</a>
            <?php
                    } else {
            ?>
                        <a class="header__enlace" href="/finalizar_registro">Ver registro</a>
            <?php
                    }
            ?>
                    <form method="POST" action="/logout" class="header__form">
                        <input type="submit" value="Cerrar Sesión" class="header__submit">
                    </form>
            <?php
                } else {
            ?>
                    <a href="/registro" class="header__enlace">Registro</a>
                    <a href="/login" class="header__enlace">Iniciar Sesión</a>
            <?php
                }
            ?>
        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">
                    &#60;ExamenFinalUMG/&#62;
                </h1>
            </a>

            <p class="header__texto">4 de noviembre de 2024</p>
            <p class="header__texto header__texto--modalidad">En línea - presencial</p>

            <?php
                if(isAuth()) {
            ?>
                    <a href="/finalizar_registro" class="header__boton">Ver registro</a>
            <?php
                } else {
            ?>
                    <a href="/registro" class="header__boton">Comprar proyecto</a>
            <?php
                }
            ?>
        </div>
    </div>
</header>

<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">
                &#60;ExamenFinalUMG/&#62;
            </h2>
        </a>
        <nav class="navegacion">
            <a href="/devwebcamp" class="navegacion__enlace <?php echo paginaActual('/devwebcamp') ? 'navegacion__enlace--actual' : ''; ?>">Evento</a>
            <a href="/paquetes" class="navegacion__enlace <?php echo paginaActual('/paquetes') ? 'navegacion__enlace--actual' : ''; ?>">Paquetes</a>
            <a href="/conferencias_workshops" class="navegacion__enlace <?php echo paginaActual('/conferencias_workshops') ? 'navegacion__enlace--actual' : ''; ?>">Conferencias & workshops</a>
            <?php
                if(isAuth()) {
                    
                } else {
            ?>
                    <a href="/registro" class="navegacion__enlace <?php echo paginaActual('/registro') ? 'navegacion__enlace--actual' : ''; ?>">Comprar pase</a>
            <?php
                }
            ?>
        </nav>
    </div>
</div>