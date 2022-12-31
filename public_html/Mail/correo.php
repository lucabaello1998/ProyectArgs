<?php include("../db.php"); ?>
<?php include('../includes/header.php'); ?>

<?php
$mifecha= date('Y-m-d H:i:s'); 
$NuevaFecha = strtotime ( '-3 hour' , strtotime ($mifecha) ) ; 
$NuevaFecha = strtotime ( '+4 minute' , $NuevaFecha ) ; 
$NuevaFecha = strtotime ( '+3 second' , $NuevaFecha ) ; 
$NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
echo $NuevaFecha;
?>
<br>
<?php
echo $mifecha;
?>

<div class="form-row justify-content-center p-2">                                          
    <a href="../Mail/mail.php">Enviar mail</i></a>                   
</div>


<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>


