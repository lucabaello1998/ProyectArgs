<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: /index.php");
  exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  $usuarios_permitidos = array("Administrador", "Despacho", "Supervisor", "Deposito", "Tecnico");
  if (in_array($tipo_us, $usuarios_permitidos))
  { $usu = 1; }
  else
  { $usu = 0; }

  if($usu != 1)
  {
    header("location: /index.php");
  }
?>
	<?php include('../include/header.php'); ?>

  <!-- MESSAGES -->
    <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
      <div id="liveToast" class="toast m-1" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header border-success p-1 m-1">
          <strong class="mr-auto" id="titulo_toast"></strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body p-2" id="mensaje_toast"></div>
      </div>
    </div>
  <!-- MESSAGES -->

  <div class="container-fluid p-4">
    <div class="row p-2">
      <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1">
        <?php
          $con_tec = mysqli_query($conn, "SELECT * FROM consultas_tec WHERE nivel = 'Inicial'");
          while($row = mysqli_fetch_array($con_tec))
          {
        ?>
        <div class="col-auto align-items-center p-4 inicial">
          <button class="row rounded alert-success shadow m-1 border" style="text-decoration: none;" data-id="<?php echo $row['id']; ?>">
            <div class="col-12 p-2">
              <p class="h6 text-muted text-center"><?php echo $row['texto']; ?></p>
            </div>
          </button>
        </div>
        <?php } ?>
      </div>
      <div id="response" class="p-4"></div>

      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- JavaScript para enviar la solicitud y procesar la respuesta -->
<script>
  // Cuando se haga clic en uno de los botones
  $(".row button").click(function() {
    // Obtener el ID del botón seleccionado
    var id = $(this).attr("data-id");
    $(".inicial button").attr('disabled','disabled');
    
    // Enviar una solicitud AJAX a un archivo PHP en el servidor
    $.ajax({
      url: "../ajax/consultas_tec.php",
      type: "POST",
      data: { id: id },
      success: function(response) {
        // Agregar el código HTML para crear el botón en el elemento con la ID "response"
        $("#response").append(response);

        // Cuando se haga clic en el botón de la respuesta
        $("#response").on("click", "button", function() {

        // Obtener el texto del botón (que es la respuesta)
        var responseText = $(this).attr("data-id");
        $('button').attr('disabled','disabled');        

        // Enviar una nueva solicitud AJAX con la respuesta como el parámetro
        $.ajax({
          url: "../ajax/consultas_tec.php",
          type: "POST",
          data: { response: responseText },
          success: function(newResponse) {
            // Mostrar la nueva respuesta en el elemento con la ID "response"
            $("#response").append(newResponse);

            // Al hacer click sobre la clase copiar seleccionamos su contenido y lo pasamos al portapapeles
            $('.copiar').click(function(event) {
              var text = event.target.dataset.copy;
              navigator.clipboard.writeText(text).then(function() {
                $('#titulo_toast').html('Copiado');
                $('#mensaje_toast').html('El texto seleccionado se copio al portapapeles.');
                $('#liveToast').toast('show');
              });
            });

            // Obtener el primer elemento de la respuesta AJAX
            var firstElement = document.querySelector('#response > *:last-child');
            // Mover el scroll suavemente hasta el primer elemento de la respuesta AJAX
            firstElement.scrollIntoView({ behavior: 'smooth' });
          }
        });
      });

      }
    });
  });
</script>
	</body>
</html>