<?php include("../../db.php"); ?>
<?php include('../includesatc/headeratc.php'); ?>

<!-- MESSAGES -->
      <?php session_start();      
       if ($_SESSION['card'] == 1) { ?>
      <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->


<br>
<center><h3>Importar registros GPON a la base de datos</h3></center>
<br>
<div class="container">
    <form action="../Guardar/save_reportesgpon.php" method="POST" enctype="multipart/form-data"/>
        <div class="form-row align-items-start justify-content-center">
            <input type="file" accept=".csv" name="dataCSV" id="file"/>
        </div>
    <br>
        <div class="form-row  align-items-start justify-content-center">
            <input type="submit" name="subir" id="btn_lectura" class="btn btn-success" value="Registrar Datos"/>
        </div>
    </form>
</div>
<br>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-auto p-2 text-center">
      <p class="h4 mb-4 text-center">Vista previa gpon</p>
      <div class="container-fluid p-1">
        <table id="csvRoot" class="table-responsive"></table>
      </div>
    </div>
  </div>
</div>

<style type="text/css">


th {
  background: #343a40;
  color: #ffffff;
  text-align: left;
}

th {
  padding: 10px 20px;
}

tr:nth-child(even) {
  background: #eeeeee;
}

</style>


      
<script src="https://cdn.jsdelivr.net/npm/papaparse@5.2.0/papaparse.min.js"></script>

<script type="text/javascript" charset="UTF-8">
  class TableCsv {
  /**
   * @param {HTMLTableElement} root The table element which will display the CSV data.
   */
  constructor(root) {
    this.root = root;
  }

  /**
   * Clears existing data in the table and replaces it with new data.
   *
   * @param {string[][]} data A 2D array of data to be used as the table body
   * @param {string[]} headerColumns List of headings to be used
   */
  update(data, headerColumns = []) {
    this.clear();
    this.setHeader(headerColumns);
    this.setBody(data);
  }

  /**
   * Clears all contents of the table (incl. the header).
   */
  clear() {
    this.root.innerHTML = "";
  }

  /**
   * Sets the table header.
   *
   * @param {string[]} headerColumns List of headings to be used
   */
  setHeader(headerColumns) {
    this.root.insertAdjacentHTML(
      "afterbegin",
      `
            <thead>
                <tr>
                    <th>Fecha y hora</th><th>Relevador</th><th>Num R</th><th>Vacio 1</th><th>Vacio 2</th><th>Direccion</th><th>Partido</th><th>Localidad</th><th>Pais</th><th>Tipo</th><th>Num</th><th>Tarea</th><th>Lat</th><th>Long</th><th>Alt</th><th>Foto</th><th>Observaciones</th><th>Cant</th><th>Prioridad</th><th>Direccion manual</th><th>Comentarios</th>
                </tr>
            </thead>
        `
    );
  }

  /**
   * Sets the table body.
   *
   * @param {string[][]} data A 2D array of data to be used as the table body
   */
  setBody(data) {
    const rowsHtml = data.map((row) => {
      return `
                <tr>
                    ${row.map((text) => `<td>${text}</td>`).join("")}
                </tr>
            `;
    });

    this.root.insertAdjacentHTML(
      "beforeend",
      `
            <tbody>
                ${rowsHtml.join("")}
            </tbody>
        `
    );
  }
}

const tableRoot = document.querySelector("#csvRoot");
const csvFileInput = document.querySelector("#file");
const tableCsv = new TableCsv(tableRoot);

csvFileInput.addEventListener("change", (e) => {
  Papa.parse(csvFileInput.files[0], {
    delimiter: ";",
    skipEmptyLines: true,
    complete: (results) => {
      tableCsv.update(results.data.slice(0), results.data[0]);
    }
  });
});

</script>

<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>
</html>