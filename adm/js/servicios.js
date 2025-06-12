const Servicios = async () => {
    try {
        const response = await fetch("../php/jsonservicios.php");
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log('Servicios data:', data);
        renderBarrasHorizontales(data);
    } catch (error) {
        console.error('Error fetching servicios:', error);
    }
};

const renderBarrasHorizontales = (data) => {
    const contenedor = document.getElementById('barras-servicios');
    contenedor.innerHTML = '';

    const total = data.total_registros;
    const colores = [
        'bg-primary', 'bg-success', 'bg-danger', 'bg-warning',
        'bg-info', 'bg-secondary', 'bg-dark', 'bg-primary', 'bg-success'
    ];

    const etiquetas = {
        total_tiendas: "Tienda",
        total_hospedajes: "Hospedaje",
        total_banos: "Baños",
        total_mecanicas: "Mecánica",
        total_lavaderos: "Lavadero",
        total_restaurantes: "Restaurante",
        total_cargas: "Carga",
        total_cajeros: "Cajero",
        total_montallantas: "Montallanta",
       total_gasolina: "Gasolina",
        total_extra: "Extra",
        total_deisel: "Diésel",
        total_gas: "Gas"
    };

    let index = 0;

    for (const [clave, valor] of Object.entries(data)) {
        if (clave === "total_registros") continue;

        const porcentaje = Math.round((valor / total) * 100);
        const color = colores[index % colores.length];
        const etiqueta = etiquetas[clave] || clave;

        contenedor.innerHTML += `
            <div class="bar-row">
            <div class="bar-label"> ${etiqueta}  </div>
            <div class="bar-horizontal ${color}" style="width: ${porcentaje}%">
            ${porcentaje}% &nbsp;(${valor})
            </div>
            </div>`;
        index++;
    }
    contenedor.innerHTML += `<div class="d-flex justify-content-center align-items-center mt-3">
        <div class="text-center">
            <h5>Total de EDS: ${total}</h5></div>
        </div>`;
};

const cargarCombustibles = async () => {
    try {
        const res = await fetch('../php/jsoncombustible.php');
        const data = await res.json();
        BarrasHorizontales(data);
        const ctx = document.getElementById('graficoCombustibles').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Gasolina', 'Extra', 'Diésel', 'Gas'],
                datasets: [{
                    data: [
                        data.total_gasolina,
                        data.total_extra,
                        data.total_deisel,
                        data.total_gas
                    ],
                    
                    backgroundColor: [
                        '#0d6efd', // azul
                        '#ffc107', // amarillo
                        '#198754', // verde
                        '#dc3545'  // rojo
                    ],
                    
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = data.total_gasolina + data.total_extra + data.total_deisel + data.total_gas;
                                const value = context.raw;
                                const porcentaje = ((value / total) * 100).toFixed(1);
                                return `${context.label}: ${value} (${porcentaje}%)`;
                            }
                        }
                    }
                }
            }
        });

    } catch (err) {
        console.error("Error al cargar combustibles:", err);
    }
};
const BarrasHorizontales = (data) => {
    const contenedor = document.getElementById('barras-Combustibe');
    contenedor.innerHTML = '';

    const total = data.total_registros;
    const colores = [
        'bg-primary',  'bg-danger', 
        'bg-info', 'bg-dark', 'bg-primary', 'bg-success'
    ];

    const etiquetas = {
        total_gasolina: "Gasolina",
        total_extra: "Extra",
        total_deisel: "Diésel",
        total_gas: "Gas"
    };

    let index = 0;

    for (const [clave, valor] of Object.entries(data)) {
        if (clave === "total_registros") continue;

        const porcentaje = Math.round((valor / total) * 100);
        const color = colores[index % colores.length];
        const etiqueta = etiquetas[clave] || clave;

        contenedor.innerHTML += `
            <div class="bar-row">
            <div class="bar-label"> ${etiqueta}  </div>
            <div class="bar-horizontal ${color}" style="width: ${porcentaje}%">
            ${porcentaje}% &nbsp;(${valor})
            </div>
            </div>`;
        index++;
    }
    contenedor.innerHTML += `<div class="d-flex justify-content-center align-items-center mt-3">
        <div class="text-center">
            <h5>Total de EDS: ${total}</h5></div>
        </div>`;
};

cargarCombustibles();

Servicios();