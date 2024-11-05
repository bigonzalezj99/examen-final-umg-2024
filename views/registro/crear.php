<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">A continuación se le presentan los planes disponibles, por favor seleccione uno.</p>

    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">Pase gratuito</h3>

            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso virtual a DevWebCamp</li>
            </ul>

            <p class="paquete__precio">Q 0.00</p>

            <form method="POST" action="/finalizar_registro/gratuito">
                <input class="paquetes__submit" type="submit" value="Inscripción gratuita">
            </form>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase presencial</h3>

            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso presencial a DevWebCamp.</li>
                <li class="paquete__elemento">Acceso a comida y bebida.</li>
                <li class="paquete__elemento">Acceso a talleres y conferencias.</li>
                <li class="paquete__elemento">Acceso a las grabaciones realizadas.</li>
                <li class="paquete__elemento">Pase disponible por dos días.</li>
                <li class="paquete__elemento">Souvenir para una camisa del evento.</li>
            </ul>

            <p class="paquete__precio">Q 199.00</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase virtual</h3>

            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso presencial a DevWebCamp.</li>
                <li class="paquete__elemento">Acceso a talleres y conferencias.</li>
                <li class="paquete__elemento">Acceso a las grabaciones realizadas.</li>
                <li class="paquete__elemento">Pase disponible por dos días.</li>
            </ul>

            <p class="paquete__precio">Q 49.00</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container-virtual"></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://www.paypal.com/sdk/js?client-id=AZhK5eqcOLpQJt5RifyiUdkworpcRC5d5oUrxpyLZqSX8gp71HC6PcH8BSNLoCqOxpghakX5yrdhKqAu&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>

<script>
    function initPayPalButton() {
        // Pase de $199.00
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":199}}]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    
                        const datos = new FormData();
                        datos.append('id_paquete', orderData.purchase_units[0].description);
                        datos.append('id_pago', orderData.purchase_units[0].payments.captures[0].id);

                        fetch('/finalizar_registro/pagar', {
                            method: 'POST',
                            body: datos
                        })
                        .then( respuesta => respuesta.json())
                        .then(resultado => {
                            if (resultado.resultado) {
                                actions.redirect('http://localhost:3000/finalizar_registro/conferencias');
                            }
                        })  
                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');

        // Pase de $49.00
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'blue',
                layout: 'vertical',
                label: 'pay',
            },

            createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{"description":"2","amount":{"currency_code":"USD","value":49}}]
            });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    const datos = new FormData();
                    datos.append('id_paquete', orderData.purchase_units[0].description);
                    datos.append('id_pago', orderData.purchase_units[0].payments.captures[0].id);

                    fetch('/finalizar_registro/pagar', {
                        method: 'POST',
                        body: datos
                    })
                    .then( respuesta => respuesta.json())
                    .then(resultado => {
                        if(resultado.resultado) {
                            actions.redirect('http://localhost:3000/finalizar_registro/conferencias');
                        }
                    })
                });
            },

            onError: function(err) {
                console.log(err);
                }
            }).render('#paypal-button-container-virtual');
        }

        initPayPalButton();
</script>