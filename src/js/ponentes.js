(function() {
    const ponentesInput = document.querySelector('#ponentes');

    if (ponentesInput) {
        let ponentes = [];
        let ponentesFiltrados = [];

        const listadoPonentes = document.querySelector('#listado-ponentes');
        const ponenteHiden = document.querySelector('[name="id_ponente"]');

        obtenerPonentes();

        ponentesInput.addEventListener('input', buscarPonentes);

        if (ponenteHiden.value) {
            (async() => {
                const ponente = await obtenerPonente(ponenteHiden.value);
                const {nombre, apellido} = ponente;

                // Insertar en el HTML.
                const ponenteDOM = document.createElement('LI');
                ponenteDOM.classList.add('listado-ponentes__ponente', 'listado-ponentes__ponente--seleccionado');
                ponenteDOM.textContent = `${nombre} ${apellido}`;

                listadoPonentes.appendChild(ponenteDOM);
            })();
        }

        async function obtenerPonentes() {
            const url = `/api/ponentes`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            formatearPonentes(resultado);
        }

        async function obtenerPonente(id) {
            const url = `/api/ponente?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            return resultado;
        }

        function formatearPonentes(arrayPonentes = []) {
            // map: Crea un nuevo arreglo y lo asigna a la variable gloabal de ponentes.
            ponentes = arrayPonentes.map(ponente => {
                return {
                    nombre : `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id : ponente.id
                }
            });
        }

        function buscarPonentes(e) {
            const busqueda = e.target.value;

            if (busqueda.length > 3) {
                const expresion = new RegExp(busqueda, "i");
                ponentesFiltrados = ponentes.filter(ponente => {
                    if (ponente.nombre.toLowerCase().search(expresion) != -1) {
                        return ponente;
                    }
                });
            } else {
                ponentesFiltrados = [];
            }

            mostrarPonentes();
        }

        function mostrarPonentes() {
            while (listadoPonentes.firstChild) {
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }

            if (ponentesFiltrados.length > 0) {
                ponentesFiltrados.forEach(ponente => {
                    const ponenteHTML = document.createElement('LI');
                    ponenteHTML.classList.add('listado-ponentes__ponente');
                    ponenteHTML.textContent = ponente.nombre;
                    ponenteHTML.dataset.idPonente = ponente.id;
                    ponenteHTML.onclick = seleccionarPonente;
    
                    // Añadir al DOM.
                    listadoPonentes.appendChild(ponenteHTML);
                });
            } else {
                const noResultados = document.createElement('P');
                noResultados.classList.add('listado-ponentes__no-resultado');
                noResultados.textContent = '¡No se encontraron resultados relacionados!';

                listadoPonentes.appendChild(noResultados);
            }
        }

        function seleccionarPonente(e) {
            const ponente = e.target;

            // Remover la clase previa.
            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--seleccionado');

            if (ponentePrevio) {
                ponentePrevio.classList.remove('listado-ponentes__ponente--seleccionado');
            }

            ponente.classList.add('listado-ponentes__ponente--seleccionado');
            ponenteHiden.value = ponente.dataset.idPonente;
        }
    }
})();