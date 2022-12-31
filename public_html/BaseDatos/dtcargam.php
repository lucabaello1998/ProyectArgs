<?php include("../db.php"); ?>
<?php include('../includes/header.php'); ?>
<!-- TABLA DE BAJAS -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ingresos</p>
          <div id="export" style="float:left"></div>
          <br/><br/>
          
          <table id="example" class="table table-responsive table-striped table-bordered display compact table-sm" cellspacing="0" style="width:100%">
            <thead class="thead-dark text-center">
              <tr>
                
                <th>Herramientas</th>
                
                <th>Cantidad</th>            
                <th>Fecha de ingreso</th>
                <th>Fecha de egreso</th>
                
                <th>Deposito</th> 
                <th>Tecnico</th> 
                <th>Entregado</th> 
              </tr>
            </thead>
            <tfoot class="thead-dark text-center">
              <tr>
              
                <th>Herramientas</th>
                
                <th>Cantidad</th>            
                <th>Fecha de ingreso</th>
                <th>Fecha de egreso</th>
              
                <th>Deposito</th> 
                <th>Tecnico</th>
                <th>Entregado</th>       
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
                [ //'columnsToggle'///
                {
                  extend: 'print',
                  text: '<i class="fa fa-print"></i>',
                  autoFilter: false,
                  titleAttr: 'Imprimir egresos',                  
                  className: 'btn btn-info',
                },
                {
                  extend: 'excelHtml5',
                  text: '<i class="fas fa-file-excel"></i>',
                  titleAttr: 'Exportar egresos a Excel',
                  autoFilter: false,
                  sheetName: 'Argentseal egresos',
                  title: 'Egresos',
                  className: 'btn btn-success',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5 ]}
                },
                {
                  extend: 'pdfHtml5',
                  text: '<i class="fas fa-file-pdf"></i>',
                  pdfName: 'Argentseal egresos',
                  titleAttr: 'Exportar egresos a PDF',
                  title: 'Egresos',
                  download: 'open',
                  orientation: 'landscape',  ////landscape///
                  className: 'btn btn-danger',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5]}
                },
                'columnsToggle',
                ],


                "language":
                {
                  "processing":     "Procesando...",
                  "search":         "Buscar:",
                  "lengthMenu":     "Mostrar _MENU_ egresos por pagina...",
                  "zeroRecords":    "No se encontro ningun egreso",
                  "info":           "Mostrando _START_ a _END_ de un total de _TOTAL_ egresos",
                  "infoEmpty":      "No hay egresos disponibles",
                  "infoFiltered":   "(filtrado de _MAX_ egresos)",
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
                "sAjaxSource": "../ServerSide/serversideCargam.php",
                "stateSave": true,
                "select":  true,
                "columnDefs":
                [{
                              
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

        
            
      });
    </script>
  </body>
  </html>