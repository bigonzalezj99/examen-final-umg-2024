import Swal from 'sweetalert2';

(function(){
    let eventos = [];

    const resumen = document.querySelector('#registro-resumen');

    if(resumen) {
        const eventosBoton = document.querySelectorAll('.evento__agregar');
        eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));

        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit', submitFormulario);

        mostrarEventos();

        function seleccionarEvento({target}) {
            if(eventos.length < 5) {
                // Deshabilitar el evento.
                target.disabled = true
                eventos = [...eventos, {
                    id: target.dataset.id,
                    titulo: target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }];

                mostrarEventos();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Solo es posible registrar un máximo de 5 evetos por usuario.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }

        function mostrarEventos() {
            // Limpiar el HTML.
            limpiarEventos();

            if(eventos.length > 0 ) {
                eventos.forEach( evento => {
                    const eventoDOM = document.createElement('DIV');
                    eventoDOM.classList.add('registro__evento');

                    const titulo = document.createElement('H3');
                    titulo.classList.add('registro__nombre');
                    titulo.textContent = evento.titulo;

                    const botonEliminar = document.createElement('BUTTON');
                    botonEliminar.classList.add('registro__eliminar');
                    botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>`;
                    botonEliminar.onclick = function() {
                        eliminarEvento(evento.id);
                    }

                    // Renderizar en el HTML.
                    eventoDOM.appendChild(titulo);
                    eventoDOM.appendChild(botonEliminar);
                    resumen.appendChild(eventoDOM);
                })
            } else {
                const noRegistro = document.createElement('P');
                noRegistro.textContent = 'No hay eventos, añada hasta 5 del lado izquierdo.';
                noRegistro.classList.add('registro__texto');
                resumen.appendChild(noRegistro);
            }
        }

        function eliminarEvento(id) {
            eventos = eventos.filter( evento => evento.id !== id);
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            mostrarEventos();
        }

        function limpiarEventos() {
            while(resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }

        async function submitFormulario(e) {
            e.preventDefault();

            // Obtener el regalo.
            const id_regalo = document.querySelector('#regalo').value;
            const id_eventos = eventos.map(evento => evento.id);

            if(id_eventos.length === 0 || id_regalo === '') {
                Swal.fire({
                    title: 'Error',
                    text: 'Debe elegir por lo menos un evento y un regalo.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });

                return;
            }

            // Objeto de FormData.
            const datos = new FormData();
            datos.append('eventos', id_eventos);
            datos.append('id_regalo', id_regalo);

            const url = '/finalizar_registro/conferencias'
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();

            console.log(resultado)

            if(resultado.resultado) {
                Swal.fire(
                    'Registro exitoso',
                    'Sus eventos han sido almacenados y su registro fue exitoso, le esperamos en DevWebCamp.',
                    'success'
                ).then(() => location.href = `/boleto?id=${resultado.token}`);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error al completar el registro, por favor vuelva a intentar.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => location.reload());
            }
        }
    }
})();