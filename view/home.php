<html>
    <head>
        <link rel="stylesheet" href="./view/css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    </head>
<body>
  <div class="barra-superior">
  </div>
    <header>
        <div class="contenedor header">
            <div class="header">
              <img class="logo" src="./logo.png" alt="Text To Slide">
            </div>
        </div>
    </header>

<div class="cajonPrincipal">
  <div class="caja1">
  		<form class="form" action="index.php" method="post">
	      <div class="entradaTexto">
	          <textarea id="#textbox" type="text" name="texto" placeholder="  Escriba su texto..." class="texto" rows="5" cols="40"></textarea>
	        <div class="botonesContenedor">
	            <button onclick="inputClick();" class="botones btn btn-primary btn-sm">Crear Slide</button>
	            <!-- <button type="button" class="botones btn btn-primary btn-sm">Seleccionar Archivo</button> -->
									<input type="file" id="fileinput" />
	        </div>
	      </div>
	    </form>
  </div>
  <div class="caja2">
      <div class="salida">
      	<?php if ($_POST['texto'] != '') { ?>
            <iframe src="https://docs.google.com/presentation/d/<?= $presentationId ?>/embed?start=false&loop=true&delayms=3000" frameborder="0" width="480" height="299" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
            <hr>
            <h4>link presentacion</h4>
            <a style="font-size: 10px;" target="_blank" href="https://docs.google.com/presentation/d/<?= $presentationId ?>/edit">https://docs.google.com/presentation/d/<?php echo $presentationId; ?>/edit</a>
        <?php } ?>
      </div>
  </div>
</div>

<div class="barra-inferior">
</div>

</body>
  <script type="text/javascript">

    function clickInput() {
      console.log('hola');
    }

    function readSingleFile(evt) {
      //Retrieve the first (and only!) File from the FileList object
      var f = evt.target.files[0];

      if (f) {
        var r = new FileReader();
        r.onload = function(e) {
            var contents = e.target.result;
          document.getElementById('#textbox').value=  contents;
        }
        r.readAsText(f);

      } else {
        alert("Failed to load file");
      }
    }

    document.getElementById('fileinput').addEventListener('change', readSingleFile, false);
  </script>
</html>