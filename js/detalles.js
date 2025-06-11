// Obtiene los parámetros de la URL
const params = new URLSearchParams(window.location.search);

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

// Obtiene el valor del parámetro "id"
const id = params.get('staction');
const informacion = document.getElementById("information");
const array = async () => {
  try {
    const respuesta = await fetch("../php/detallejson.php?callback=estaciones&dt=" + id);
    const data = await respuesta.json();
    // console.log(data);
    let distancia = 0; // Inicializamos la distancia
    let ubicacion = null;
    try {
      ubicacion = await obtenerUbicacionUsuario();
    } catch (error) {
      console.warn("No se pudo obtener la ubicación del usuario:", error);
    }
    if (ubicacion) {
      // Calcular la distancia desde la ubicación del usuario a la estación
      distancia = calcularDistancia(ubicacion.latitude, ubicacion.longitude, data[0].latitud, data[0].longitud);
    }

    if (data.length > 0) {
      Rellenar(data[0], distancia); // <-- Arreglado aquí
    }

  } catch (error) {
    console.error("Error al cargar las estaciones de servicio:", error);
  }
};

function Rellenar(array, km) {
   let preciosHTML = '';
  //  console.log("dis: ",km);
  // console.log("Datos de la estación:", array);
if (km > 0) {
  preciosHTML += `<div class="distancia mb-3">
      <span class="material-symbols-outlined text-warning">location_on</span>
      <strong>Distancia:</strong> ${km.toFixed(2)} km
    </div>`;
  }


 
  const precios = array.combustibles[0]; // Sacamos el objeto de combustibles
  // console.log("Precios de combustibles:", precios);
  if (precios.gasolisa > 0) {
    preciosHTML += `
      <div class="combustible">
        <span class="material-symbols-outlined text-success">local_gas_station</span>
        <strong>Gasolina:</strong> $${precios.gasolisa.toLocaleString()} COP
      </div>`;
  }

  if (precios.extra > 0) {
    preciosHTML += `
      <div class="combustible">
        <span class="material-symbols-outlined text-success">gas_meter</span>
        <strong>Extra:</strong> $${precios.extra.toLocaleString()} COP
      </div>`;
  }

  if (precios.deisel > 0) {
    preciosHTML += `
      <div class="combustible">
        <span class="material-symbols-outlined text-success">oil_barrel</span>
        <strong>Diesel:</strong> $${precios.deisel.toLocaleString()} COP
      </div>`;
  }

  if (precios.gas > 0) {
    preciosHTML += `
      <div class="combustible">
        <span class="material-symbols-outlined text-success">local_gas_station</span>
        <strong>GNV:</strong> $${precios.gas.toLocaleString()} COP
      </div>`;
  }

  let serviciosHTML = '';
  if (array.servicios && array.servicios.length > 0) {
    serviciosHTML = Servicios(array.servicios[0]); // Asegúrate que pasas el objeto correcto
  } else {
    serviciosHTML = '<p>No hay servicios disponibles.</p>';
  }

  const html = `
    <div class="info-box p-3 rounded">
      <div class="precios mb-4">
        ${preciosHTML}
      </div>
      <h5 class="mb-2">Servicios Disponibles</h5>
      <div class="servicios mb-3">
        ${serviciosHTML}
      </div>
    </div>
  `;

  informacion.innerHTML = html;

  // Mapa y nombre
  Point(array.latitud, array.longitud, array.nombre);
  document.getElementById("name").innerText = array.nombre;
}




const listaServicios = [
  { clave: 'tienda', nombre: 'Tienda', icono: 'store' },
  { clave: 'hospedaje', nombre: 'Hospedaje', icono: 'hotel' },
  { clave: 'banos', nombre: 'Baños', icono: 'wc' },
  { clave: 'mecanica', nombre: 'Mecánica', icono: 'build' }, { clave: 'lavadero', nombre: 'Autolavado', icono: 'local_car_wash' },

  { clave: 'restaurante', nombre: 'Restaurante', icono: 'restaurant' }, { clave: 'carga', nombre: 'Carga electrica', icono: 'ev_station' },
  { clave: 'cajero', nombre: 'Cajero', icono: 'local_atm' },
  { clave: 'montallanta', nombre: 'Llantería', icono: 'construction' },


];

function Servicios(serviciosDB) {
  // console.log("Servicios DB:", serviciosDB);
  let serviciosHTML = ``;
  let filaAbierta = false;
  let contador = 0;

  // Asegurar que haya al menos un objeto
  const servicioDatos = serviciosDB;
  if (!servicioDatos) return "";

  // console.log("Datos de servicio:", servicioDatos);

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


array();
