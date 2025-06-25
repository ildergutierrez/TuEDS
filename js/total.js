let estacionesOriginales = []; // Guardar las estaciones para filtrar

const Eds = async () => {
    try {
        const respuesta = await fetch("../php/muestra.php?callback=estaciones");
        const data = await respuesta.json();
        console.log(data);
        if (data.length > 0) {
            estacionesOriginales = data; // Guardar copia original
            MostrarEstaciones(data);
        }
    } catch (error) {
        console.error("Error al cargar las estaciones de servicio:", error);
    }
};

// Función para crear un mapa Leaflet dentro de un div específico
function CrearMapa(idDiv, lat, lon, nombre) {
    const map = L.map(idDiv).setView([lat, lon], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v12/tiles/512/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiaWFsYmVydG9ndXRpZXJyZXoiLCJhIjoiY21icjB5amV1MDVsYTJxcHNkeTh6cDBzeSJ9.AEnhdZoGe8F-J6WQceN-og', {
        tileSize: 512,
        zoomOffset: -1,
        attribution: '© Mapbox © OpenStreetMap',
        maxZoom: 20
    }).addTo(map);

    L.marker([lat, lon]).addTo(map)
        .bindPopup(`<strong>${nombre}</strong>`)
        .openPopup();
}

function MostrarEstaciones(estaciones) {
    const contenedor = document.getElementById("eds");
    contenedor.innerHTML = ""; // Limpiar el contenedor

    // Crear un contenedor de fila
    const row = document.createElement("div");
    row.className = "row";

    estaciones.forEach((eds, index) => {
        const mapId = `map${index}`; // ID único para cada mapa

        const col = document.createElement("div");
        col.className = "col-12 col-md-4 mb-3"; // 3 columnas por fila en pantallas medianas+

        col.innerHTML = `
      <div class="card h-100">
        <img src="../${eds.img}" class="card-img-top" alt="${eds.nombre}"  oncontextmenu="return false;"
              ondragstart="return false;"
              onmousedown="return false;"
              style="pointer-events: none; user-select: none"/>
        <div class="card-body">
          <h5 class="card-title text-center">${eds.nombre}</h5>
          <div id="${mapId}" class="map-container" style="height: 200px;"></div>
          <a href="detalles.html?staction=${btoa(eds.id)}" class="btn btn-dark mt-2">Ver detalles</a>
        </div>
      </div>
    `;

        row.appendChild(col);

        // Crear el mapa una vez que el div esté en el DOM
        setTimeout(() => {
            CrearMapa(mapId, eds.latitud, eds.longitud, eds.nombre);
        }, 0);
    });

    // Agregar la fila completa al contenedor
    contenedor.appendChild(row);
}

// Manejador de filtro en tiempo real
document.addEventListener("DOMContentLoaded", () => {
  const inputBuscador = document.getElementById("buscador");

  inputBuscador.addEventListener("input", (e) => {
    const texto = e.target.value.toLowerCase();

    const filtradas = estacionesOriginales.filter(eds =>
      eds.nombre.toLowerCase().includes(texto)
    );

    MostrarEstaciones(filtradas);
  });
});


Eds();
