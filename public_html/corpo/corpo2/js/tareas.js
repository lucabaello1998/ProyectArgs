fetch('../../../corpo/corpo2/php/get_tareas.php')
  .then(response => response.json()) // Convertimos la respuesta a formato JSON
  .then(data => {
    console.log(data)
    document.querySelector('.altas').textContent = data.alta_mes.total;
    document.querySelector('.bajas').textContent = data.baja_mes.total;
    document.querySelector('.sin-confirmar').textContent = data.pendientes.total;
  });