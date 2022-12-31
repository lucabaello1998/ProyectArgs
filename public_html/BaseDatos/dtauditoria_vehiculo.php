<?php include("../db.php"); ?>
<?php include('../includes/header.php'); ?>
<!-- TABLA DE BAJAS -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Auditorias de vehiculos cargadas</p>
          <div id="export" style="float:left"></div>
          <br/><br/>
          
          <table id="example" class="table table-responsive table-striped table-bordered display compact table-sm" cellspacing="0" style="width:100%">
            <thead class="thead-dark text-center">
              <tr>
                  <th>Acciones</th>
                  <th>Supervisor</th>
                  <th>Fecha auditoria</th>
                  <th class="sticky pl-0">Tecnico</th>
                  <th>Fecha</th>
                  <th class="bg-info">Auxilio</th>
                  <th class="bg-info">Balizas</th>
                  <th class="bg-info">Cedula</th>
                  <th class="bg-info">Chasis</th>            
                  <th class="bg-info">Color</th>
                  <th class="bg-info">Criquet</th>
                  <th class="bg-info">Dominio</th>
                  <th class="bg-info">Llave Cruz</th>
                  <th class="bg-info">Matafuego</th>
                  <th class="bg-info">Modelo</th>
                  <th class="bg-info">Motor</th>
                  <th class="bg-warning text-dark">Aire</th>
                  <th class="bg-warning text-dark">Balizas</th>
                  <th class="bg-warning text-dark">Bocina</th>
                  <th class="bg-warning text-dark">Calefaccion</th>
                  <th class="bg-warning text-dark">Encendedor</th>
                  <th class="bg-warning text-dark">Giro delantero acomp</th>
                  <th class="bg-warning text-dark">Giro delantero conduc</th>
                  <th class="bg-warning text-dark">Giro trasero acomp</th>
                  <th class="bg-warning text-dark">Giro trasero acomp</th>
                  <th class="bg-warning text-dark">Limpia parabrisas</th>
                  <th class="bg-warning text-dark">Luz alta</th>
                  <th class="bg-warning text-dark">Luz baja</th>
                  <th class="bg-warning text-dark">Luz de freno</th>
                  <th class="bg-warning text-dark">Sapito</th>
                  <th class="bg-warning text-dark">Stereo</th>
                  <th class="bg-warning text-dark">Tapa de fusilera</th>
                  <th class="bg-warning text-dark">Medidor temperatura</th>
                  <th class="bg-warning text-dark">Medidor velocimetro</th>
                  <th class="bg-warning text-dark">Llave</th>
                  <th class="bg-primary">Manija giro</th>
                  <th class="bg-primary">Manija luces</th>
                  <th class="bg-primary">Pulsadores</th>
                  <th class="bg-primary">Rejilla ventilacion</th>
                  <th class="bg-info">Capot</th>
                  <th class="bg-info">Cubiertas</th>
                  <th class="bg-info">Llantas</th>
                  <th class="bg-info">Opticas</th>
                  <th class="bg-info">Parabrisas</th>
                  <th class="bg-info">Paragolpe</th>
                  <th class="bg-info">Parrilla</th>
                  <th class="bg-info">Portaescalera</th>
                  <th class="bg-warning">Baul</th>
                  <th class="bg-warning">Caño de escape</th>
                  <th class="bg-warning">Cerradura</th>
                  <th class="bg-warning">Cubiertas</th>
                  <th class="bg-warning">Llantas</th>
                  <th class="bg-warning">Luneta</th>
                  <th class="bg-warning">Opticas</th>
                  <th class="bg-warning">Paragolpe</th>
                  <th class="bg-success">Alfombra delantera</th>
                  <th class="bg-success">Alfombra trasera</th>
                  <th class="bg-success">Apoya brazo delantero</th>
                  <th class="bg-success">Apoya brazo trasero</th>
                  <th class="bg-success">Butaca delantera</th>
                  <th class="bg-success">Butaca trasera</th>
                  <th class="bg-success">Cerradura delantera</th>
                  <th class="bg-success">Cerradura trasera</th>
                  <th class="bg-success">Manija puerta delantera</th>
                  <th class="bg-success">Manija puerta trasera</th>
                  <th class="bg-success">Manija ventanilla delantera</th>
                  <th class="bg-success">Manija ventanilla trasera</th>
                  <th class="bg-success">Panel puerta delantera</th>
                  <th class="bg-success">Panel puerta trasera</th>
                  <th class="bg-success">Panel techo</th>
                  <th class="bg-success">Polarizado delantero</th>
                  <th class="bg-success">Polarizado trasero</th>
                  <th class="bg-success">Seguro puerta delantera</th>
                  <th class="bg-success">Seguro puerta trasera</th>
                  <th class="bg-danger">Alfombra delantera</th>
                  <th class="bg-danger">Alfombra trasera</th>
                  <th class="bg-danger">Apoya brazo delantero</th>
                  <th class="bg-danger">Apoya brazo trasero</th>
                  <th class="bg-danger">Butaca delantera</th>
                  <th class="bg-danger">Butaca trasera</th>
                  <th class="bg-danger">Cerradura delantera</th>
                  <th class="bg-danger">Cerradura trasera</th>
                  <th class="bg-danger">Manija puerta delantera</th>
                  <th class="bg-danger">Manija puerta trasera</th>
                  <th class="bg-danger">Manija ventanilla delantera</th>
                  <th class="bg-danger">Manija ventanilla trasera</th>
                  <th class="bg-danger">Panel puerta delantera</th>
                  <th class="bg-danger">Panel puerta trasera</th>
                  <th class="bg-danger">Panel techo</th>
                  <th class="bg-danger">Polarizado delantero</th>
                  <th class="bg-danger">Polarizado trasero</th>
                  <th class="bg-danger">Seguro puerta delantera</th>
                  <th class="bg-danger">Seguro puerta trasera</th>
                  <th class="bg-success">Observaciones</th>
              </tr>
            </thead>
            <tfoot class="thead-dark text-center">
              <tr>
                  <th>Acciones</th>
                  <th>Supervisor</th>
                  <th>Fecha auditoria</th>
                  <th class="sticky pl-0">Tecnico</th>
                  <th>Fecha</th>
                  <th class="bg-info">Auxilio</th>
                  <th class="bg-info">Balizas</th>
                  <th class="bg-info">Cedula</th>
                  <th class="bg-info">Chasis</th>            
                  <th class="bg-info">Color</th>
                  <th class="bg-info">Criquet</th>
                  <th class="bg-info">Dominio</th>
                  <th class="bg-info">Llave Cruz</th>
                  <th class="bg-info">Matafuego</th>
                  <th class="bg-info">Modelo</th>
                  <th class="bg-info">Motor</th>
                  <th class="bg-warning text-dark">Aire</th>
                  <th class="bg-warning text-dark">Balizas</th>
                  <th class="bg-warning text-dark">Bocina</th>
                  <th class="bg-warning text-dark">Calefaccion</th>
                  <th class="bg-warning text-dark">Encendedor</th>
                  <th class="bg-warning text-dark">Giro delantero acomp</th>
                  <th class="bg-warning text-dark">Giro delantero conduc</th>
                  <th class="bg-warning text-dark">Giro trasero acomp</th>
                  <th class="bg-warning text-dark">Giro trasero acomp</th>
                  <th class="bg-warning text-dark">Limpia parabrisas</th>
                  <th class="bg-warning text-dark">Luz alta</th>
                  <th class="bg-warning text-dark">Luz baja</th>
                  <th class="bg-warning text-dark">Luz de freno</th>
                  <th class="bg-warning text-dark">Sapito</th>
                  <th class="bg-warning text-dark">Stereo</th>
                  <th class="bg-warning text-dark">Tapa de fusilera</th>
                  <th class="bg-warning text-dark">Medidor temperatura</th>
                  <th class="bg-warning text-dark">Medidor velocimetro</th>
                  <th class="bg-warning text-dark">Llave</th>
                  <th class="bg-primary">Manija giro</th>
                  <th class="bg-primary">Manija luces</th>
                  <th class="bg-primary">Pulsadores</th>
                  <th class="bg-primary">Rejilla ventilacion</th>
                  <th class="bg-info">Capot</th>
                  <th class="bg-info">Cubiertas</th>
                  <th class="bg-info">Llantas</th>
                  <th class="bg-info">Opticas</th>
                  <th class="bg-info">Parabrisas</th>
                  <th class="bg-info">Paragolpe</th>
                  <th class="bg-info">Parrilla</th>
                  <th class="bg-info">Portaescalera</th>
                  <th class="bg-warning">Baul</th>
                  <th class="bg-warning">Caño de escape</th>
                  <th class="bg-warning">Cerradura</th>
                  <th class="bg-warning">Cubiertas</th>
                  <th class="bg-warning">Llantas</th>
                  <th class="bg-warning">Luneta</th>
                  <th class="bg-warning">Opticas</th>
                  <th class="bg-warning">Paragolpe</th>
                  <th class="bg-success">Alfombra delantera</th>
                  <th class="bg-success">Alfombra trasera</th>
                  <th class="bg-success">Apoya brazo delantero</th>
                  <th class="bg-success">Apoya brazo trasero</th>
                  <th class="bg-success">Butaca delantera</th>
                  <th class="bg-success">Butaca trasera</th>
                  <th class="bg-success">Cerradura delantera</th>
                  <th class="bg-success">Cerradura trasera</th>
                  <th class="bg-success">Manija puerta delantera</th>
                  <th class="bg-success">Manija puerta trasera</th>
                  <th class="bg-success">Manija ventanilla delantera</th>
                  <th class="bg-success">Manija ventanilla trasera</th>
                  <th class="bg-success">Panel puerta delantera</th>
                  <th class="bg-success">Panel puerta trasera</th>
                  <th class="bg-success">Panel techo</th>
                  <th class="bg-success">Polarizado delantero</th>
                  <th class="bg-success">Polarizado trasero</th>
                  <th class="bg-success">Seguro puerta delantera</th>
                  <th class="bg-success">Seguro puerta trasera</th>
                  <th class="bg-danger">Alfombra delantera</th>
                  <th class="bg-danger">Alfombra trasera</th>
                  <th class="bg-danger">Apoya brazo delantero</th>
                  <th class="bg-danger">Apoya brazo trasero</th>
                  <th class="bg-danger">Butaca delantera</th>
                  <th class="bg-danger">Butaca trasera</th>
                  <th class="bg-danger">Cerradura delantera</th>
                  <th class="bg-danger">Cerradura trasera</th>
                  <th class="bg-danger">Manija puerta delantera</th>
                  <th class="bg-danger">Manija puerta trasera</th>
                  <th class="bg-danger">Manija ventanilla delantera</th>
                  <th class="bg-danger">Manija ventanilla trasera</th>
                  <th class="bg-danger">Panel puerta delantera</th>
                  <th class="bg-danger">Panel puerta trasera</th>
                  <th class="bg-danger">Panel techo</th>
                  <th class="bg-danger">Polarizado delantero</th>
                  <th class="bg-danger">Polarizado trasero</th>
                  <th class="bg-danger">Seguro puerta delantera</th>
                  <th class="bg-danger">Seguro puerta trasera</th>

                  <th class="bg-success">Observaciones</th>
                  
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 

<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script> 
<script src="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></script> 







<script>
   var editar = '<i class="fas fa-pen p-2"></i>';
   var borrar = '<i class="far fa-trash-alt p-2"></i>';
  $(document).ready(function()
        {  // Agregado de texto al final de la columna '<f<t>lip>'<"wrapper"flipt>
        $('#example tfoot th').each( function () {
          var title = $(this).text();
          $(this).html( '<input type="text" placeholder="Buscar en... '+title+'" />' );
        });
        var table = $("#example").DataTable(
        {           
          "lengthChange": true,
          "dom": 'lBfrt<t>ip',                 

          "buttons":
                [ 
                
                {
                  extend: 'print',
                  text: '<i class="fa fa-print"></i>',
                  autoFilter: false,
                  titleAttr: 'Imprimir auditorias',                  
                  className: 'btn btn-info',
                },
                {
                  extend: 'excelHtml5',
                  text: '<i class="fas fa-file-excel"></i>',
                  titleAttr: 'Exportar auditorias a Excel',
                  autoFilter: false,
                  sheetName: 'Argentseal Auditoriass',
                  title: 'Auditoria_vehiculos',
                  className: 'btn btn-success',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93]}
                },
                {
                  extend: 'pdfHtml5',
                  text: '<i class="fas fa-file-pdf"></i>',
                  pdfName: 'Argentseal auditorias',
                  titleAttr: 'Exportar auditorias a PDF',
                  title: 'Auditoria_vehiculos',
                  download: 'open',
                  orientation: 'landscape',  ////landscape///
                  className: 'btn btn-danger',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 90, 91, 92, 93]}
                },
                'columnsToggle',
                ],


                "language":
                {
                  "processing":     "Procesando...",
                  "search":         "Buscar:",
                  "lengthMenu":     "Mostrar _MENU_ auditorias por pagina...",
                  "zeroRecords":    "No se encontro ninguna auditorias",
                  "info":           "Mostrando _START_ a _END_ de un total de _TOTAL_ auditorias",
                  "infoEmpty":      "No hay auditorias disponibles",
                  "infoFiltered":   "(filtrado de _MAX_ auditorias)",
                  "loadingRecords": "Cargando...",
                  "paginate": {
                    "first":      "Primer",
                    "previous":   "Anterior",
                    "next":       "Siguiente",
                    "last":       "Ultimo"
                  },
                  "aria": {
                    "sortAscending":  ": ordenar ascendentemente",
                    "sortDescending": ": ordenar descendientemente"
                  },
                },
                "processing": true,
                "serverSide": true,              
                "sAjaxSource": "../ServerSide/serverside_auditoria_vehiculo.php",
                "stateSave": true,
                 "select":  true,
                "columnDefs":
                [{
                  "targets": 0,
                  "data": null,
                  "width": "10%",
                  "defaultContent": "<i type='button' class='text-primary' id='editar'>"+editar+"</i> <i type='button' class='text-danger' id='borrar'>"+borrar+"</i>",
                  
                }
                ],
             
                "order": [[ 4, "desc" ]],
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todo"]],
                initComplete: function ()
                {
                // Se aplica la busqueda
                this.api().columns().every( function ()
                {
                  var that = this;
                  
                  $( 'input', this.footer() ).on( 'keyup change clear', function ()
                  {
                    if ( that.search() !== this.value )
                    {
                      that
                      .search( this.value )
                      .draw();
                    }
                  });
                });
              }
            });
        table.buttons().container().appendTo($('#export'));

        $('#example tbody').on( 'click', '#editar', function () {
          var data = table.row( $(this).parents('tr') ).data();              
          onclick (window.location.href='../Editar/edit_auditoria_vehiculo.php?id='+data[0]);
        } );
        $('#example tbody').on( 'click', '#borrar', function () {
          var datab = table.row( $(this).parents('tr') ).data();              
          onclick (window.location.href='../Borrar/delete_auditoria_vehiculo.php?id='+datab[0]);
        } );
           
      });
    </script>
  </body>
  </html>