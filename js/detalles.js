// Obtiene los parámetros de la URL
const params = new URLSearchParams(window.location.search);

// Obtiene el valor del parámetro "id"
const id = params.get('staction');
const informacion = document.getElementById("information");
const array ={
     id: 1,
        nombre: "EDS San Alberto Norte",
        precio_gasolina: 11200,
        precio_extra: 11900,
        precio_diesel: 9800,
        precio_gnv: 100,
        servicios: {
            tienda: 1,
            hospedaje: 1,
            baños: 1,
            mecanico: 1,
            montallanta: 1,
            carga: 1,
        },
        latitud: 8.321019,
        longitud: -73.587119
}
function Rellenar(array) {
  let preciosHTML = '';

  // Precios de combustibles con íconos y diseño
  if (array.precio_gasolina > 0) {
    preciosHTML += `
      <div class="combustible">
        <span class="material-symbols-outlined text-success">local_gas_station</span>
        <strong>Gasolina:</strong> $${array.precio_gasolina.toLocaleString()} COP
      </div>`;
  }
  if (array.precio_extra > 0) {
    preciosHTML += `
      <div class="combustible">
        <span class="material-symbols-outlined text-success">gas_meter</span>
        <strong>Extra:</strong> $${array.precio_extra.toLocaleString()} COP
      </div>`;
  }
  if (array.precio_diesel > 0) {
    preciosHTML += `
      <div class="combustible">
        <span class="material-symbols-outlined text-success">oil_barrel</span>
        <strong>Diesel:</strong> $${array.precio_diesel.toLocaleString()} COP
      </div>`;
  }
  if (array.precio_gnv > 0) {
    preciosHTML += `
      <div class="combustible">
        <span class="material-symbols-outlined text-success">local_gas_station</span>
        <strong>GNV:</strong> $${array.precio_gnv.toLocaleString()} COP
      </div>`;
  }

  // Sección de información renderizada
  const html = `
    <div class="info-box p-3 rounded ">
     
      <div class="precios mb-4">
        ${preciosHTML}
      </div>
      <h5 class="mb-2">Servicios Disponibles</h5>
      <div class="servicios mb-3">
        ${Servicios(array.servicios)}
      </div>
    </div>
  `;

  informacion.innerHTML = html;

  // Cargar mapa y título
  Point(array.latitud, array.longitud, array.nombre);
  document.getElementById("name").innerText = array.nombre;
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



// Mostrar en consola
// alert("ID recibido: " + id);

function Point(lat = 0, lon = 0, nombre = "EDS") {
  // Crear el mapa
  const map = L.map('map').setView([lat, lon], 18); // Zoom muy cercano

  // Agregar capa satelital de Mapbox
  L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v12/tiles/512/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiaWFsYmVydG9ndXRpZXJyZXoiLCJhIjoiY21icjB5amV1MDVsYTJxcHNkeTh6cDBzeSJ9.AEnhdZoGe8F-J6WQceN-og', {
    tileSize: 512,
    zoomOffset: -1,
    attribution: '© Mapbox © OpenStreetMap',
    maxZoom: 20
  }).addTo(map);

  // Agregar marcador
  L.marker([lat, lon]).addTo(map)
    .bindPopup(`<strong>${nombre}</strong><br>`)
    .openPopup();
}


document.addEventListener('DOMContentLoaded', () => {
  Rellenar(array);
});
