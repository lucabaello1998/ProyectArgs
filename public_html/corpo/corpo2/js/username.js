
fetch('../../../corpo/corpo2/php/get_usuario.php')
    .then(function(response) {
    return response.json();
    })
    .then(function(response) {
    // Asignar el nombre del usuario al botón
    document.querySelector('.usuario').textContent = response.nombre_usuario;
});