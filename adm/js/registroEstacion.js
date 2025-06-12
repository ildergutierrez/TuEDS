document.addEventListener('DOMContentLoaded', function () {
    // Selecciona todos los checkboxes dentro del formulario
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    checkboxes.forEach(function (checkbox) {
        // Establece el valor inicial según si está marcado
        checkbox.value = checkbox.checked ? '1' : '0';

        // Agrega evento para cambiar el valor dinámicamente
        checkbox.addEventListener('change', function () {
            this.value = this.checked ? '1' : '0';
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('input[name="lat"], input[name="lon"],input[name="gasolina"],input[name="diesel"], input[name="extra"], input[name="gas"]');

    inputs.forEach(function (input) {
        input.addEventListener('input', function () {
            // Solo permite números y un punto decimal
            this.value = this.value.replace(/[^0-9.-]/g, '');
            // Evita más de un punto decimal

        });
    });
});
