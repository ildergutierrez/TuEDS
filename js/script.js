const estacions = document.getElementById("estaciones");
const listaEDS = async () => {
    try {
        const respuesta = await fetch("php/jsons.php");
        const data = await respuesta.json();
        console.log(data);
        if(data.length >0)
        {
            EDS(data);
        }
        
    } catch (error) {
        console.error("Error al cargar las estaciones de servicio:", error);
    }
};



// <div class="row">
//     <div class="col-6"><p class="card-text">Gasolina:</p></div>
//     <div class="col-6"><p class="card-text">$${eds.precio_gasolina}</p></div>
// </div>
// <div class="row">
//     <div class="col-6"><p class="card-text">Extra:</p></div>
//     <div class="col-6"><p class="card-text">$${eds.precio_extra}</p></div>
// </div>
// <div class="row">
//     <div class="col-6 in"><p class="card-text">Diésel:</p></div>
//     <div class="col-6 in"><p class="card-text">$${eds.precio_diesel}</p></div>
// </div>
// <div class="row">
//     <div class="col-6"><p class="card-text">Gas:</p></div>
//     <div class="col-6"><p class="card-text">$${eds.precio_gnv}</p></div>
// </div>

function EDS(listaEDS) {
    let estacionHTML = ``;
    let contador = 0;
    // console.log("Lista de EDS:", listaEDS);
    listaEDS.forEach((eds, index) => {
        // Abrir nueva fila si es el primero o cada 3 elementos
        if (contador % 3 === 0) {
            estacionHTML += `<div class="row mb-4">`;
        }

        estacionHTML += `
            <div class="col-12 col-md-4 mb-3">
                <div class="card h-100 ">
                
                    <img src="img/servicios.png" class="card-img-top" alt="${eds.nombre}" />
                    <div class="card-body  ">
                    <div> 
                    <h5 class="card-title">${eds.nombre}
                    </h5>
                            </div>   
                            <div class="card-body">               
                        <p class="card-text mt-2"><b>Servicios disponibles:</b></p>
                        <div class="card-text">
                            ${Servicios(eds.servicios)}
                        </div></div>
                        <div>
                        <a href="paginas/detalles.html?staction=${btoa(eds.id)}" class="btn btn-dark mt-2">Ver detalles</a>
                    </div></div>
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
    console.log("Servicios disponibles:", serviciosDB);

    listaServicios.forEach(servicio => {
        console.log("Servicio:",servicio);
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
listaEDS();