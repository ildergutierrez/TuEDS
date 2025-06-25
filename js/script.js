const estacions = document.getElementById("estaciones");

// Geolocalización
function obtenerUbicacionUsuario() {
    return new Promise((resolve, reject) => {
        if (!navigator.geolocation) {
            reject("Geolocalización no disponible");
        } else {
            navigator.geolocation.getCurrentPosition(
                (pos) => resolve(pos.coords),
                (err) => reject("Error de ubicación: " + err.message)
            );
        }
    });
}

// Distancia con Haversine
function calcularDistancia(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
        Math.sin(dLat / 2) ** 2 +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) ** 2;
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

// Lista de servicios
const listaServicios = [
    { clave: 'tienda', nombre: 'Tienda', icono: 'store' },
    { clave: 'hospedaje', nombre: 'Hospedaje', icono: 'hotel' },
    { clave: 'banos', nombre: 'Baños', icono: 'wc' },
    { clave: 'mecanica', nombre: 'Mecánica', icono: 'build' },
    { clave: 'lavadero', nombre: 'Autolavado', icono: 'local_car_wash' },
    { clave: 'restaurante', nombre: 'Restaurante', icono: 'restaurant' },
    { clave: 'carga', nombre: 'Carga eléctrica', icono: 'ev_station' },
    { clave: 'cajero', nombre: 'Cajero', icono: 'local_atm' },
    { clave: 'montallanta', nombre: 'Llantería', icono: 'construction' }
];

// HTML de servicios
function Servicios(serviciosDB) {
    let serviciosHTML = ``;
    let filaAbierta = false;
    let contador = 0;

    const servicioDatos = serviciosDB[0];
    if (!servicioDatos) return "";

    listaServicios.forEach(servicio => {
        if (servicioDatos[servicio.clave] === 1) {
            if (!filaAbierta) {
                serviciosHTML += `<div class="fila">`;
                filaAbierta = true;
            }

            serviciosHTML += `<div class="columna-servicio">
                <span class="material-symbols-outlined">${servicio.icono}</span>
                <span>${servicio.nombre}</span>
            </div>`;

            contador++;
            if (contador % 2 === 0) {
                serviciosHTML += `</div>`;
                filaAbierta = false;
            }
        }
    });

    if (filaAbierta) {
        serviciosHTML += `</div>`;
    }

    return serviciosHTML;
}

// Renderizar máximo 6 estaciones
function EDS(listaEDS) {
    let estacionHTML = ``;
    let contador = 0;

    listaEDS.forEach((eds, index) => {
        if (contador % 3 === 0) {
            estacionHTML += `<div class="row mb-4">`;
        }

        estacionHTML += `
            <div class="col-12 col-md-4 mb-3">
                <div class="card h-100">
                    <img src="${eds.img}" class="card-img-top" alt="${eds.nombre}"  oncontextmenu="return false;"
              ondragstart="return false;"
              onmousedown="return false;"
              style="pointer-events: none; user-select: none" />
                    <div class="card-body text-center">
                        <h5 class="card-title">${eds.nombre}</h5>
                        <p class="text-muted small">
                            ${eds.distancia ? eds.distancia.toFixed(2) + ' km de distancia' : ''}
                        </p>
                        <p class="card-text mt-2"><b>Servicios disponibles:</b></p>
                        <div class="card-text">
                            ${Servicios(eds.servicios)}
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="paginas/detalles.html?staction=${btoa(eds.id)}" class="btn btn-dark mt-2">Ver detalles</a>
                    </div>
                </div>
            </div>
        `;

        contador++;
        if (contador % 3 === 0 || index === listaEDS.length - 1) {
            estacionHTML += `</div>`;
        }
    });

    estacions.innerHTML = estacionHTML;
}

// Cargar y limitar estaciones
const listaEDS = async () => {
    try {
        const respuesta = await fetch("php/jsons.php?callback=estaciones");
        const data = await respuesta.json();

        let ubicacion = null;
        try {
            ubicacion = await obtenerUbicacionUsuario();
        } catch (error) {
            console.warn("No se pudo obtener la ubicación del usuario:", error);
        }

        if (ubicacion) {
            data.forEach(eds => {
                eds.distancia = calcularDistancia(
                    ubicacion.latitude,
                    ubicacion.longitude,
                    parseFloat(eds.lat),
                    parseFloat(eds.lon)
                );
            });

            // Ordenar por distancia
            data.sort((a, b) => a.distancia - b.distancia);// Ordenar por distancia
        }

        // Limitar a máximo 6 estaciones
        const edsLimitadas = data.slice(0, 6);

        if (edsLimitadas.length > 0) {
            EDS(edsLimitadas);
        }
    } catch (error) {
        console.error("Error al cargar las estaciones de servicio:", error);
    }
};

window.addEventListener("load", async () => {
    await listaEDS();
    setInterval(async () => {
        await listaEDS();
    }, 2000); // Actualizar cada 2 segundos
});
