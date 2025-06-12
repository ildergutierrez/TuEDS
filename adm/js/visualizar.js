const listado = async () => {
    const id = document.getElementById('id').value;
    try {
        const response = await fetch(`../php/todo.php?id=${id}`);
        if (!response.ok) throw new Error('Error al cargar datos');

        const data = await response.json();

        if (!data || !data.eds) {
            console.error('Datos incompletos');
            return;
        }

        // 🟩 EDS
        document.querySelector('input[name="nombre_eds"]').value = data.eds.nombre || '';
        document.querySelector('input[name="lat"]').value = data.eds.lat || '';
        document.querySelector('input[name="lon"]').value = data.eds.lon || '';

        // Imagen
        const imagenContenedor = document.querySelector('#imagen-preview img');
if (imagenContenedor && data.eds.img) {
    imagenContenedor.src = "../../" + data.eds.img;
}

        // 🟩 Combustibles
        if (data.combustibles && data.combustibles.length > 0) {
            const c = data.combustibles[0];
            document.querySelector('input[name="gasolina"]').value = c.gasolina || '';
            document.querySelector('input[name="extra"]').value = c.extra || '';
            document.querySelector('input[name="diesel"]').value = c.deisel || ''; // OJO: typo en tu JSON: "deisel"
            document.querySelector('input[name="gas"]').value = c.gas || '';
        }

        // 🟩 Servicios
        if (data.servicios && data.servicios.length > 0) {
            const s = data.servicios[0];

            // Mapeo del JSON a los nombres de los checkboxes
            const serviciosMap = {
                tienda: s.tienda,
                hospedaje: s.hospedaje,
                banos: s.banos,
                taller: s.mecanica,
                lavado: s.lavadero,
                restaurante: s.restaurante,
                carga: s.carga,
                cajero: s.cajero,
                llanteria: s.montallanta
            };

            Object.entries(serviciosMap).forEach(([key, value]) => {
                const checkbox = document.querySelector(`input[name="${key}"]`);
                if (checkbox) {
                    checkbox.checked = value == 1;
                }
            });
        }

    } catch (error) {
        console.error('Error:', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    listado();
});