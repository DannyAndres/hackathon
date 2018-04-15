<html>
    <head>
        <link rel="stylesheet" href="./view/css/verification_style.css">
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

      <div class="contenedor-codigo">
          <div class="link">
          	<a target="_blank" href="<?= $authUrl ?>"><?php echo $authUrl; ?></a>
          </div>
          <form action="index.php" method="post">
					  <textarea type="text" name="code" placeholder="  Ingrese su codigo..." class="codigo" rows="5" cols="40"></textarea>
	          <div class="contenedor-boton">
	            <button type="submit" class="botones btn btn-primary btn-sm">Enviar</button>
	          </div>
					</form>
      </div>

      <div class="barra-inferior">
      </div>
    </body>
</html>