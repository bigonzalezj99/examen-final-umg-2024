(function() {
    const horas = document.querySelector('#horas');

    if (horas) {
        const categoria = document.querySelector('[name="id_categoria"]');
        const dias = document.querySelectorAll('[name="dia"]');
        const inputHiddenDia = document.querySelector('[name="id_dia"]');
        const inputHiddenHora = document.querySelector('[name="id_hora"]');

        categoria.addEventListener('change', terminoBusqueda);
        dias.forEach(dia => dia.addEventListener('change', terminoBusqueda));

        let busqueda = {
            id_categoria: +categoria.value || '',
            dia: +inputHiddenDia.value || ''
        }

        if (!Object.values(busqueda).includes('')) {
            (async () => {
                await buscarEventos();

                const id = inputHiddenHora.value;

                // Resaltar la hora actual.
                const horaSeleccionada = document.querySelector(`[data-id-hora="${id}"]`);
                horaSeleccionada.classList.remove('horas__hora--deshabilitada');
                horaSeleccionada.classList.add('horas__hora--seleccionada');

                horaSeleccionada.onclick = seleccionarHora;
            })();
        }

        function terminoBusqueda(e) {
            busqueda[e.target.name] = e.target.value;

            // Reiniciar los campos ocultos y el selector de horas.
            inputHiddenHora.value = '';
            inputHiddenDia.value = '';
            
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');

            if (horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }

            if (Object.values(busqueda).includes('')) {
                return;
            }

            buscarEventos();
        }

        async function buscarEventos() {
            const {dia, id_categoria} = busqueda;
            const url = `/api/eventos_horario?id_dia=${dia}&id_categoria=${id_categoria}`;

            const resultado = await fetch(url);
            const eventos = await resultado.json();
            obtenerHorasDisponibles(eventos);
        }

        function obtenerHorasDisponibles(eventos) {
            // Reiniciar las horas.
            const listadoHoras = document.querySelectorAll('#horas li');
            listadoHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'))

            // Comprobar eventos ya tomados, y quitar la variable de deshabilitado.
            const horasTomadas = eventos.map(evento => evento.id_hora);            
            const listadoHorasArray = Array.from(listadoHoras);

            const resultado = listadoHorasArray.filter(li =>  !horasTomadas.includes(li.dataset.idHora));
            resultado.forEach(li => li.classList.remove('horas__hora--deshabilitada'))

            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
            horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora));
        }

        function seleccionarHora(e) {
            // Deshabilitar la hora previa, si hay un nuevo click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');

            if (horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }

            // Agregar clase de seleccionado.
            e.target.classList.add('horas__hora--seleccionada');

            inputHiddenHora.value = e.target.dataset.idHora;

            // Llenar el campo oculto de dia
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        }
    }
})();