<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del evento</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre del evento:</label>
        <input
            class="formulario__input"
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Nombre del evento"
            value="<?php echo $evento->nombre; ?>"
        />
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción del evento:</label>
        <textarea
            class="formulario__input"
            id="descripcion"
            name="descripcion"
            cols="30"
            rows="10"
            placeholder="Descripción del evento"
        ><?php echo $evento->descripcion ?? ''; ?></textarea>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="categoria">Categoría del evento:</label>

        <select class="formulario__select" name="id_categoria" id="categoria">
            <option value="">Seleccione la categoría</option>
            <?php
                foreach ($categorias as $categoria) {
            ?>
                    <option <?php echo ($evento->id_categoria === $categoria->id) ? 'selected' : ''; ?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
            <?php
                }
            ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="dia">Seleccione el día:</label>

        <div class="formulario__radio">
            <?php
                foreach ($dias as $dia) { 
            ?>
                    <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre; ?></label>

                    <input
                        type="radio"
                        name="dia"
                        id="<?php echo strtolower($dia->nombre); ?>"
                        value="<?php echo $dia->id; ?>"
                        <?php echo ($evento->id_dia === $dia->id) ? 'checked' : ''; ?>
                    />
            <?php
                }
            ?>
        </div>

        <input type="hidden" name="id_dia" value="<?php echo $evento->id_dia; ?>" />
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="horas">Seleecione la hora</label>

        <ul id="horas" class="horas">
            <?php
                foreach ($horas as $hora) {
            ?>
                    <li data-id-hora="<?php echo $hora->id; ?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora; ?></li>
            <?php
                }
            ?>
        </ul>

        <input type="hidden" name="id_hora" value="<?php echo $evento->id_hora; ?>" />
    </div>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información extra</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="ponentes">Seleccione un ponente:</label>
        <input
            class="formulario__input"
            type="text"
            id="ponentes"
            placeholder="Buscar ponente"
        />
        <ul class="listado-ponentes" id="listado-ponentes"></ul>
        <input type="hidden" name="id_ponente" value="<?php echo $evento->id_ponente; ?>" />
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="disponible">Lugares disponibles:</label>
        <input
            class="formulario__input"
            type="number"
            id="disponible"
            name="disponible"
            min="1"
            max="100"
            placeholder="Ejemplo: 25"
            value="<?php echo $evento->disponible; ?>"
        />
    </div>
</fieldset>