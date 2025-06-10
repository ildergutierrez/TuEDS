const estacions = document.getElementById("estaciones");
const listaEDS = [
    {
        id: 1,
        nombre: "EDS San Alberto Norte",
        precio_gasolina: 11200,
        precio_extra: 11900,
        precio_diesel: 9800,
        precio_gnv: 7700,
        servicios: {
            tienda: 1,
            hospedaje: 0,
            baños: 1,
            mecanico: 0,
            montallanta: 1
        }
    },
    {
        id: 2,
        nombre: "EDS Pailitas Express",
        precio_gasolina: 11350,
        precio_extra: 12100,
        precio_diesel: 9900,
        precio_gnv: 7800,
        servicios: {
            tienda: 1,
            hospedaje: 1,
            baños: 1,
            mecanico: 1,
            montallanta: 1
        }
    },
    {
        id: 3,
        nombre: "EDS El Paraíso",
        precio_gasolina: 11000,
        precio_extra: 11700,
        precio_diesel: 9600,
        precio_gnv: 7500,
        servicios: {
            tienda: 1,
            hospedaje: 0,
            baños: 1,
            mecanico: 0,
            montallanta: 0
        }
    },
    {
        id: 4,
        nombre: "EDS Central del Valle",
        precio_gasolina: 11400,
        precio_extra: 12200,
        precio_diesel: 10000,
        precio_gnv: 7900,
        servicios: {
            tienda: 1,
            hospedaje: 1,
            baños: 1,
            mecanico: 1,
            montallanta: 1
        }
    },
    {
        id: 5,
        nombre: "EDS Ruta 45",
        precio_gasolina: 11150,
        precio_extra: 11800,
        precio_diesel: 9700,
        precio_gnv: 7600,
        servicios: {
            tienda: 1,
            hospedaje: 0,
            baños: 1,
            mecanico: 1,
            montallanta: 1
        }
    },
    {
        id: 6,
        nombre: "EDS La Fortuna",
        precio_gasolina: 10900,
        precio_extra: 11550,
        precio_diesel: 9500,
        precio_gnv: 7400,
        servicios: {
            tienda: 0,
            hospedaje: 0,
            baños: 1,
            mecanico: 0,
            montallanta: 1
        }
    },
    {
        id: 7,
        nombre: "EDS Mirador Llanero",
        precio_gasolina: 11300,
        precio_extra: 12000,
        precio_diesel: 9900,
        precio_gnv: 7850,
        servicios: {
            tienda: 1,
            hospedaje: 1,
            baños: 1,
            mecanico: 0,
            montallanta: 0
        }
    }
];

function EDS(listaEDS) {
    let estacionHTML = ``;
    let contador = 0;

    listaEDS.forEach((eds, index) => {
        // Abrir nueva fila si es el primero o cada 3 elementos
        if (contador % 3 === 0) {
            estacionHTML += `<div class="row mb-4">`;
        }

        estacionHTML += `
            <div class="col-12 col-md-4 mb-3">
                <div class="card h-100 ">
                
                    <img src="img/servicios.png" class="card-img-top" alt="${eds.nombre}" />
                    <div class="card-body ">
                        <h5 class="card-title">${eds.nombre}</h5>

                        <div class="row">
                            <div class="col-6"><p class="card-text">Gasolina:</p></div>
                            <div class="col-6"><p class="card-text">$${eds.precio_gasolina}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><p class="card-text">Extra:</p></div>
                            <div class="col-6"><p class="card-text">$${eds.precio_extra}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><p class="card-text">Diésel:</p></div>
                            <div class="col-6"><p class="card-text">$${eds.precio_diesel}</p></div>
                        </div>
                        <div class="row">
                            <div class="col-6"><p class="card-text">Gas:</p></div>
                            <div class="col-6"><p class="card-text">$${eds.precio_gnv}</p></div>
                        </div>

                        <p class="card-text mt-2"><b>Servicios</b></p>
                        <div class="card-text">
                            ${Servicios(eds.servicios)}
                        </div>

                        <a href="paginas/detalles.html?staction=${btoa(eds.id)}" class="btn btn-dark mt-2">Ver detalles</a>
                    </div>
                </div>
            </div>
        `;

        contador++;

        // Cerrar fila después de cada 3 columnas o al final de la lista
        if (contador % 3 === 0 || index === listaEDS.length - 1) {
            estacionHTML += `</div>`; // cerrar la fila
        }
    });

    estacions.innerHTML = estacionHTML;
}

const serviciosEDS = {
    tienda: 1,
    hospedaje: 0,
    banos: 1,
    mecanico: 0,
    montallanta: 0,
    autolavado: 1,
    cajero: 1,
    carga: 1,
};
const listaServicios = [
    { clave: 'tienda', nombre: 'Tienda', icono: 'store' },
    { clave: 'hospedaje', nombre: 'Hospedaje', icono: 'hotel' },
    { clave: 'banos', nombre: 'Baños', icono: 'wc' },
    { clave: 'mecanico', nombre: 'Mecánica', icono: 'build' },
    { clave: 'montallanta', nombre: 'Llantería', icono: 'construction' },
    { clave: 'autolavado', nombre: 'Autolavado', icono: 'local_car_wash' },
    { clave: 'cajero', nombre: 'Cajero', icono: 'local_atm' },
    { clave: 'carga', nombre: 'Carga electrica', icono: 'ev_station' },
    { clave: 'restaurante', nombre: 'Restaurante', icono: 'restaurant' }

];

function Servicios(serviciosDB) {
    let serviciosHTML = ``;
    let filaAbierta = false;
    let contador = 0;

    listaServicios.forEach(servicio => {
        if (serviciosDB[servicio.clave] == 1) {
            // Abrir nueva fila si es necesario
            if (!filaAbierta) {
                serviciosHTML += `<div class="fila">`;
                filaAbierta = true;
            }

            // Añadir servicio
            serviciosHTML += `<div class="columna-servicio">
                <span class="material-symbols-outlined">${servicio.icono}</span>
                <span>${servicio.nombre}</span>
            </div>`;

            contador++;

            // Cerrar fila si ya hay dos columnas
            if (contador % 2 === 0) {
                serviciosHTML += `</div>`;
                filaAbierta = false;
            }
        }
    });

    // Si quedó una fila abierta (por número impar), cerrarla
    if (filaAbierta) {
        serviciosHTML += `</div>`;
    }

    return serviciosHTML;
}


// Inicializar la lista de estaciones de servicio
EDS(listaEDS);