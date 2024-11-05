    <h2 class="pagina__heading"><?php echo $titulo; ?></h2>
    <p class="pagina__descripcion">Elija hasta cinco eventos para asistir de forma presencial.</p>

    <div class="eventos-registro">
        <main class="eventos-registro__listado">
            <h3 class="eventos-registro__heading--conferencias">&#60;Conferencias/&#62;</h3>
            <p class="eventos-registro__fecha">Viernes 8 de septiembre</p>

            <div class="eventos-registro__grid">
                <?php
                    foreach ($eventos['conferencias_v'] as $evento) {
                ?>
                        <?php include __DIR__ . '/evento.php'; ?>
                <?php
                    }
                ?>
            </div>

            <p class="eventos-registro__fecha">Sábado 9 de septiembre</p>

            <div class="eventos-registro__grid">
                <?php
                    foreach($eventos['conferencias_s'] as $evento) {
                ?>
                        <?php include __DIR__ . '/evento.php'; ?>
                <?php
                    }
                ?>
            </div>

            <h3 class="eventos-registro__heading--workshops">&#60;Workshops/&#62;</h3>
            <p class="eventos-registro__fecha">Viernes 8 de septiembre</p>

            <div class="eventos-registro__grid eventos--workshops">
                <?php
                    foreach ($eventos['workshops_v'] as $evento) {
                ?>
                        <?php include __DIR__ . '/evento.php'; ?>
                <?php
                    }
                ?>
            </div>

            <p class="eventos-registro__fecha">Sábado 9 de septiembre</p>

            <div class="eventos-registro__grid eventos--workshops">
                <?php
                    foreach ($eventos['workshops_s'] as $evento) {
                ?>
                        <?php include __DIR__ . '/evento.php'; ?>
                <?php
                    }
                ?>
            </div>
        </main>

        <aside class="registro">
            <h2 class="registro__heading">Resumen del registro</h2>

            <div class="registro__resumen" id="registro-resumen"> </div>

            <div class="registro__regalo">
                <label class="registro__label" for="regalo">Seleccione un regalo:</label>
                <select class="registro__select" id="regalo">
                    <option value="">Seleccione un regalo</option>
                    <?php
                        foreach ($regalos as $regalo) {
                    ?>
                            <option value="<?php echo $regalo->id; ?>"><?php echo $regalo->nombre; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>

            <form class="formulario" id="registro">
                <div class="formulario__campo">
                    <input class="formulario__submit formulario__submit--full" type="submit" value="Registrar" />
                </div>
            </form>
        </aside>
    </div>