<?php include("../db.php"); ?>
<!-----Supervisor---->
<?php
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
$nombre_us = $_SESSION['nombre'];
$apellido_us = $_SESSION['apellido'];
$quien_us = $_SESSION['nombre'] .' ' .$_SESSION['apellido'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
?>
<!-----Supervisor---->
<?php include('../includes/header.php'); ?>
<!-- MESSAGES -->
  <?php
    if ($_SESSION['card'] == 1) { ?>
    <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header border-<?= $_SESSION['color_toast']?> ">
          <?php switch($_SESSION['color_toast'])
            {case 'success': $icono_toast = '<i class="fa-solid fa-circle-check text-success pr-2"></i>';break;
            case 'danger': $icono_toast = '<i class="fa-solid fa-circle-xmark text-danger pr-2"></i>';break;
            case 'warning': $icono_toast = '<i class="fa-solid fa-circle-exclamation text-warning pr-2"></i>';break;}
          ?>
          <strong class="mr-auto"><?php echo $icono_toast; ?> <?= $_SESSION['titulo_toast']?></strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body p-2"><?= $_SESSION['mensaje_toast']?></div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $('.toast').toast('show');
      });
    </script>
  <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->
<script>
			
	
		// Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
		/* $("#adicional").on('click', function(){
			$("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla");
		}); */

    $(document).ready(function(){
        var inputs = $("form :text"),
        length = inputs.length,
        i = 0;
 
        inputs.on("keypress", function(event){
		    var code = event.keyCode || event.which;    
		    if (code == 13){
		        event.preventDefault();
		        i = i == length - 1 ? 0 : ++i;
		        /* inputs[i].focus(); */
		        $("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla"); //// esta linea solo duplica el input
             document.getElementById("seriado").value = ""; ////limpia el input 
		    }        
		});
    


		// Evento que selecciona la fila y la elimina 
		$(document).on("click",".eliminar",function(){
			var parent = $(this).parents().get(0);
			$(parent).remove();
		});
	});
</script>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

        <div class="row justify-content-center p-1">
          <div class="col-5 col-sm-5 p-1">
            <div class="row justify-content-center p-1 pr-3">
              <button type="button" class="btn btn-success p-2 m-2" data-toggle="modal" data-target="#excel">
                <i class="fa-solid fa-file-excel"></i>
              </button>
              <button type="button" class="btn btn-success p-2 m-2" data-toggle="modal" data-target="#individual">
                <i class="fa-solid fa-barcode"></i>
              </button>
            </div>
          </div>
        </div>
      <!-- MODAL EXCEL -->
        <div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" text-center>Ingreso de materiales seriado con excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center text-danger">Cargue los equipos sin encabezados, en el siguiente orden</p>
                <div class="row justify-content-center p-1">
                  <div class="col-auto">
                    <table class="table table-responsive table-striped table-bordered table-sm">
                      <thead class="thead-dark text-center">
                        <tbody align="center">
                          <tr>
                            <td>SAP</td>
                            <td>SN</td>
                            <td>Descripcion</td>
                          </tr>
                        </tbody>
                      </thead>
                    </table>
                  </div>
                </div>
                  
                <form action="../Guardar/save_ingresomaterial.php" method="POST" enctype="multipart/form-data" name="frmExcelImport" id="frmExcelImport">
                  <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                      <label for="ingresoMaterial">Fecha</label >
                      <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group col-12 col-md-6">
                      <label for="ingresoMaterial">Proveedor</label >
                      <select type="text" name="proveedor" class="form-control" required>
                        <option selected value="" disabled>Proveedor...</option>
                        <option value="Claro">Claro</option>
                        <option value="Argentseal">Argentseal</option>
                        <option value="Otro">Otro</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                      <label for="ingresoMaterial">Deposito</label >
                      <select type="text" name="deposito" class="form-control" required>
                        <option selected value="" disabled>Deposito...</option>
                        <option value="Lomas de Zamora">Lomas de Zamora</option>
                        <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                        <option value="La Tablada">La Tablada</option>
                        <option value="San Nicolas">San Nicolas</option>
                      </select>
                    </div>
                    <div class="form-group col-12 col-md-6">
                      <label for="ingresoMaterial">Num pedido</label >
                      <input type="number" name="pedido" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <label for="ingresoMaterial">Observaciones</label >
                      <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"></textarea>
                    </div>          
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <div class="form-row align-items-start justify-content-center"> 
                        <label>Cargar excel del pedido </label>
                      </div>
                      <div class="form-row align-items-start justify-content-center">
                        <input type="file" name="file" id="file" accept=".xls,.xlsx" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-row p-2">
                    <input type="submit" id="submit" name="serie" value="Ingresar pedido" class="btn btn-success btn-block"/>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      <!-- MODAL SERIADO INDIIVIDUAL -->
        <div class="modal fade" id="individual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabell" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabell" text-center>Ingreso de materiales seriado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="../Guardar/save_ingresomaterialseriado.php" method="POST">
                  <p class="h4 mb-4 text-center">Ingreso de equipos seriados</p>
                  <div class="form-row">
                      <div class="form-group col">
                        <label for="ingresoMaterial">Nro pedido</label>
                        <input type="text" maxlength="255" name="pedido" class="form-control" placeholder="Ingrese el nro de pedido" required>
                      </div>
                      <div class="form-group col">
                        <label for="ingresoMaterial">SAP</label>
                        <input type="text" maxlength="255" name="sap" class="form-control" placeholder="Ingrese el nro SAP" required>
                      </div>
                    </div>
                    <div class="form-row"> 
                      <div class="form-group col">
                        <label for="ingresoMaterial">Observaciones</label >
                        <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"></textarea>
                      </div>          
                    </div>
                    <br>

                  <table class="table"  id="tabla">
                    <tr class="fila-fija">
                      <td><input type="text" name="seriado[]" placeholder="Equipo seriado" id="seriado" autofocus /></td>
                      <td class="eliminar"><input type="button" value="Menos -"/></td>
                    </tr>
                  </table>    

                    <div class="row align-items-start justify-content-center">                
                      <input type="submit" name="enviar" value="Ingresar equipos seriados" class="btn btn-success"/>              
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <br>
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <?php
            $a = mysqli_query($conn, "SELECT *, COUNT(seriado) as 'count_seri' FROM ingresomaterial WHERE fecha LIKE '%$mes%' AND seriado <> '' AND cantidad = 1 ");
            while($row = mysqli_fetch_assoc($a))
            { $cant_ser = $row['count_seri']; }
          ?>
          <p class="h4 mb-4 text-center"><?php echo $cant_ser; ?> equipos seriados en deposito</p>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <?php
            $b = mysqli_query($conn, "SELECT *, COUNT(seriado) as 'count_seria' FROM ingresomaterial WHERE fecha LIKE '%$mes%' AND seriado <> '' AND cantidad = 0 ");
            while($ro = mysqli_fetch_assoc($b))
            { $cant_seria = $ro['count_seria']; }
          ?>
          <p class="h4 mb-4 text-center"><?php echo $cant_seria; ?> equipos seriados instalados</p>
        </div>
      </div>

    </div>
  </div>
</div> 

<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="./excel/assets/jquery-1.12.4-jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>