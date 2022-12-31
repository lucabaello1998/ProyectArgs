<?php include("../db.php"); ?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Dias cargados</p>
          <div id="export" style="float:left"></div>
          <br/><br/>
          <table id="example" class="table table-responsive table-striped table-bordered display compact table-sm" cellspacing="0" style="width:100%">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>Fecha</th>
                <th>Dia</th>
                <th>Hora deposito</th>
                <th>Hora primera tarea</th>
                <th>2 play</th>
                <th>3 play</th>
                <th>STB</th>
                <th>Mudanza de equipos</th>
                <th>Tareas cumplidas</th>
                <th>Bajas</th>            
                <th>Garantias del tecnico</th>        
                <th>Garantias de un compañero</th>
                <th>Bajas tecnicas</th>
                <th>Bajas con desmonte</th>
                <th>Mtto Interno</th>
                <th>Mtto Externo</th>
                <th>Reclamos</th>       
                <th>Fin del dia</th>
                <th>Zona</th>
                <th>Observaciones</th>
              </tr>
            </thead>
            <tfoot class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>Fecha</th>
                <th>Dia</th>
                <th>Hora deposito</th>
                <th>Hora primera tarea</th>
                <th>2 play</th>
                <th>3 play</th>
                <th>STB</th>
                <th>Mudanza de equipos</th>
                <th>Tareas cumplidas</th>
                <th>Bajas</th>            
                <th>Garantias del tecnico</th>            
                <th>Garantias de un compañero</th>
                <th>Bajas tecnicas</th>
                <th>Bajas con desmonte</th>
                <th>Mtto Interno</th>
                <th>Mtto Externo</th>
                <th>Reclamos</th>           
                <th>Fin del dia</th>
                <th>Zona</th>
                <th>Observaciones</th>           
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
                  titleAttr: 'Imprimir produccion',                  
                  className: 'btn btn-info',
                },
                {
                  extend: 'excelHtml5',
                  text: '<i class="fas fa-file-excel"></i>',
                  titleAttr: 'Exportar ordenes a Excel',
                  autoFilter: false,
                  sheetName: 'Argentseal produccion',
                  title: 'Produccion',
                  className: 'btn btn-success',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 20]}
                },
                {
                  extend: 'pdfHtml5',
                  text: '<i class="fas fa-file-pdf"></i>',
                  pdfName: 'Argentseal Bajas',
                  titleAttr: 'Exportar produccion a PDF',
                  title: 'Produccion',
                  download: 'open',
                  orientation: 'landscape',  ////landscape///
                  className: 'btn btn-danger',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 20]}
                },
                'columnsToggle',
                ],


                "language":
                {
                  "processing":     "Procesando...",
                  "search":         "Buscar:",
                  "lengthMenu":     "Mostrar _MENU_ dias por pagina...",
                  "zeroRecords":    "No se encontro ningun dia",
                  "info":           "Mostrando _START_ a _END_ de un total de _TOTAL_ dias",
                  "infoEmpty":      "No hay dias disponibles",
                  "infoFiltered":   "(filtrado de _MAX_ dias)",
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
                "sAjaxSource": "../ServerSide/serversideProduccion.php",
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
             
                "order": [[ 2, "desc" ]],
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
          onclick (window.location.href='../Editar/edit_produccion.php?id='+data[0]);
        } );
        $('#example tbody').on( 'click', '#borrar', function () {
          var datab = table.row( $(this).parents('tr') ).data();              
          onclick (window.location.href='../Borrar/delete_produccion.php?id='+datab[0]);
        } );
           
      });
    </script>
  </body>
  </html>