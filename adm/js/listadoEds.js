let estacionesOriginales = []; // Almacena los datos originales

const listado = async () => {
    try {
        const response = await fetch('../php/jsonEds.php');
        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();

        if (data && data.length > 0) {
            estacionesOriginales = data; // Guardar para futuras búsquedas
            renderTable(data);
        } else {
            console.error('No data found or data is empty');
            document.querySelector('#eds-cards').innerHTML =
                '<div class="col-12 text-center"><p>No hay estaciones disponibles.</p></div>';
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
};

function renderTable(data) {
    const container = document.querySelector('#eds-cards');
    container.innerHTML = ''; // Limpiar contenido anterior

    data.forEach(item => {
        const col = document.createElement('div');
        col.className = 'col-md-3 mb-4'; // 4 columnas por fila
//   <a href="../dashboard/visualizar.php?id=${btoa(item.id)}&res" class="dropdown-item"></a>
        col.innerHTML = `
             <a href="../dashboard/visualizar.php?id=${btoa(item.id)}&res" class="btn2"> <div class="card h-100 shadow-sm">
           
                <img src="../../${item.img}" class="card-img-top" alt="${item.nombre}" style="height: 150px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">${item.nombre}</h5>
                </div>
            </div></a>
        `;

        container.appendChild(col);
    });
}

// Manejador de filtro en tiempo real
document.addEventListener("DOMContentLoaded", () => {
    const inputBuscador = document.getElementById("buscador");

    inputBuscador.addEventListener("input", (e) => {
        const texto = e.target.value.toLowerCase();

        const filtradas = estacionesOriginales.filter(eds =>
            eds.nombre.toLowerCase().includes(texto)
        );

        renderTable(filtradas); // Usamos la misma función de renderizado
    });

    listado(); // Llamamos al cargar la página
});
