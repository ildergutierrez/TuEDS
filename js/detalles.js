// Obtiene los parámetros de la URL
const params = new URLSearchParams(window.location.search);

// Obtiene el valor del parámetro "id"
const id = params.get('staction');

// Mostrar en consola
alert("ID recibido: " + id);
