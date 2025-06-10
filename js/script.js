const estacions = document.getElementById("estaciones");

function EDS() {
    let estacion = ` <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <img src="img/LOGO.png" class="card-img-top" alt="Estación 1" />
                                <div class="card-body">
                                    <h5 class="card-title">nombre</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="card-text">Gasolina: </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="card-text">$ </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="card-text">Extra: </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="card-text">$ </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="card-text">Disel: </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="card-text">$ </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="card-text">Gas: </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="card-text">$ </p>
                                        </div>
                                    </div>
                                    <p class="card-text"><b>Servicios</b></p>
                                    <div class="card-text">
                                        ${Servicios(serviciosEDS)}
                                    </div>
                                    <a href="#" class="btn btn-primary">Ver Detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>`;
    estacions.innerHTML += estacion;
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
    { clave: 'carga', nombre: 'Carga electrica', icono: 'battery_charging_full' },
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


EDS();