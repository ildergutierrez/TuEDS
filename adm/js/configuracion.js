const listado = async () => {
    try {
        const response = await fetch(`../php/jsonadm.php`);
        if (!response.ok) throw new Error('Error al cargar datos');

        const data = await response.json();
        console.table(data);

        if (!data || !data.id_persona) {
            console.error('Datos incompletos o no se encontró administrador');
            return;
        }

        // Llenar los campos del formulario directamente desde data
        document.querySelector('input[name="nombre"]').value = data.nombre || '';
        document.querySelector('input[name="apellido"]').value = data.apellido || '';
        document.querySelector('input[name="tel"]').value = data.telefono || '';
        document.querySelector('input[name="direccion"]').value = data.direccion || '';
        document.querySelector('input[name="email"]').value = data.correo || '';
      
    } catch (error) {
        console.error('Error:', error);
    }
};

document.addEventListener('DOMContentLoaded', listado);
