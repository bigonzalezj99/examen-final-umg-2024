<?php
    foreach ($alertas as $llave => $alerta) {
        foreach ($alerta as $mensaje) {
?>
            <div class="alerta alerta__<?php echo $llave; ?>">
                <?php echo $mensaje; ?>
            </div>
<?php
        }
    }
?>