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
	            <button type="submit" class="botones btn btn-primary btn-sm">Crear Slide</button>
	            <button type="button" class="botones btn btn-primary btn-sm">Seleccionar Archivo</button>
	        </div>
	      </div>
	    </form>
  </div>
  <div class="caja2">
      <div class="salida">
      	<?php echo htmlspecialchars($_POST['texto']); ?>
      	<hr>
      	<h3>link presentacion</h3>
      	<a style="font-size: 10px;" target="_blank" href="https://docs.google.com/presentation/d/<?= $presentationId ?>/edit">https://docs.google.com/presentation/d/<?php echo $presentationId; ?>/edit</a>
      </div>
  </div>
</div>

<div class="barra-inferior">
</div>

</body>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).delegate('#textbox', 'keydown', function(e) {
	  var keyCode = e.keyCode || e.which;

	  if (keyCode == 9) {
	    e.preventDefault();
	    var start = this.selectionStart;
	    var end = this.selectionEnd;

	    // set textarea value to: text before caret + tab + text after caret
	    $(this).val($(this).val().substring(0, start)
	                + "\t"
	                + $(this).val().substring(end));

	    // put caret at right position again
	    this.selectionStart =
	    this.selectionEnd = start + 1;
	  }
	});
</script>
</html>