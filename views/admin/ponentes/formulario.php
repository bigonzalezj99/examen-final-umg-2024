<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información personal</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre:</label>
        <input
            class="formulario__input" 
            type="text" 
            id="nombre" 
            name="nombre" 
            placeholder="Nombre1 Nombre2" 
            value="<?php echo $ponente->nombre ?? ''; ?>" 
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
            value="<?php echo $ponente->apellido ?? ''; ?>" 
        />
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="ciudad">Ciudad:</label>
        <input
            class="formulario__input" 
            type="text" 
            id="ciudad" 
            name="ciudad" 
            placeholder="Ingrese la ciudad de origen" 
            value="<?php echo $ponente->ciudad ?? ''; ?>" 
        />
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="pais">País:</label>
        <input
            class="formulario__input" 
            type="text" 
            id="pais" 
            name="pais" 
            placeholder="Ingrese el país de origen" 
            value="<?php echo $ponente->pais ?? ''; ?>" 
        />
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="imagen">Imagen:</label>
        <input
            class="formulario__input formulario__input--file" 
            type="file" 
            id="imagen" 
            name="imagen" 
        />
    </div>

    <?php
        if (isset($ponente->imagen_actual)) {
    ?>
            <p class="formulario__texto">Imagen actual:</p>
            <div class="formulario__imagen">
                <picture>
                    <source srcset="/img/speakers/<?php echo $ponente->imagen; ?>.webp" type="image/webp" />
                    <source srcset="/img/speakers/<?php echo $ponente->imagen; ?>.png" type="image/png" />
                    <img loading="lazy" width="200" height="300" src="/img/speakers/<?php echo $ponente->imagen; ?>.png" alt="Imagen ponente">
                </picture>
            </div>
    <?php
        }
    ?>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información extra</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="tags_input">Áreas de experiencia (Separadas por coma):</label>
        <input
            class="formulario__input" 
            type="text" 
            id="tags_input" 
            placeholder="Ejemplo: HTML, CSS, SCSS, JS, PHP, Laravel, UX / UI" 
        />

        <div class="formulario__listado" id="tags"></div>
        <input type="hidden" name="tags" value="<?php echo $ponente->tags ?? ''; ?>" />
    </div>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Redes sociales</legend>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-facebook"></i>
            </div>
            <input
                class="formulario__input--sociales" 
                type="text" 
                name="redes[facebook]" 
                placeholder="Facebook" 
                value="<?php echo $redes->facebook ?? ''; ?>" 
            />
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-github"></i>
            </div>
            <input
                class="formulario__input--sociales" 
                type="text" 
                name="redes[github]" 
                placeholder="GitHub" 
                value="<?php echo $redes->github ?? ''; ?>" 
            />
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-instagram"></i>
            </div>
            <input
                class="formulario__input--sociales" 
                type="text" 
                name="redes[instagram]" 
                placeholder="Instagram" 
                value="<?php echo $redes->instagram ?? ''; ?>" 
            />
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-twitter"></i>
            </div>
            <input
                class="formulario__input--sociales" 
                type="text" 
                name="redes[twitter]" 
                placeholder="Twitter" 
                value="<?php echo $redes->twitter ?? ''; ?>" 
            />
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input
                class="formulario__input--sociales" 
                type="text" 
                name="redes[youtube]" 
                placeholder="YouTube" 
                value="<?php echo $redes->youtube ?? ''; ?>" 
            />
        </div>
    </div>
</fieldset>