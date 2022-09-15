<?php  
  session_start();
  require_once "config.php";
  
  if (!empty($_POST)){
    
    // para saber si estamos dandonos de alta o no 
    $me_estoy_dando_de_alta     = $_POST["alta"];
    $usuario  = mysqli_real_escape_string($conexion,$_POST["usuario"]);
    $clave    = mysqli_real_escape_string($conexion,$_POST["clave"]);
    
     

      //************************************************ */
      //  el formulario es el de alta de usuarios       //  
      //************************************************ */
    $usuario_guardado=false;
    if ($me_estoy_dando_de_alta == 'si'){
        $clave2    = mysqli_real_escape_string($conexion,$_POST["clave2"]);
        if (empty($_POST["usuario"]) || empty($_POST["clave"]) ||empty($_POST["clave2"])){
            $mensaje='<div class="alert alert-danger">Rellene todos los datos por favor</div>';          
        }elseif ($clave!= $clave2){
            $mensaje='<div class="alert alert-danger">Las claves no coinciden.</div>';          
        }elseif (ya_existe_usuario($conexion,$usuario)){                
            $mensaje='<div class="alert alert-danger"><strong>El usuario que ha escrito existe y no se puede repetir</strong>. </div>';          
        }else{
            // si todo va bien, pasamos a guardar el usaurio 
            if (guardar_usuario($conexion,$usuario, $clave)) {
                $mensaje='<div class="alert alert-success">Usuario guardado correctamente.<a href="index.php">Haga login por favor</a></div>' ;          
                $usuario_guardado=true;
            }else{
              $mensaje='<div class="alert alert-danger">Hubo un error al guardar el usuario.</div>';                        
            }
            
        } 
      echo $mensaje;               
      

    }elseif ($alta!='si'){
      
      //************************************************ */
      // si el formulario es el de acceso al sistema 
      //************************************************ */
      $usuario  = mysqli_real_escape_string($conexion,$_POST["usuario"]);
      $clave    = mysqli_real_escape_string($conexion,$_POST["clave"]);
      
      // existe usuario está en config.php 
      if (existe_usuario($conexion,$usuario, $clave)){
          header("location:home.php");      
          $_SESSION['usuario'] = $usuario;
          $_SESSION['clave']  = $clave;
      }else{      
          $mensaje='<div class="alert alert-danger">Error usuario y contraseña no encontrados</div>';
          echo $mensaje;    
      }  
  
    }
    
  }

  //********************************************* */
  // si viene el parametro logout = false 
  // cierra la sesión 
  //********************************************* */
  if (!empty($_GET)){
      if ($_GET["logout"]=="true"){
        cerrar_sesion();
      }
  }
  //********************************************* */
  // funciuón que cierra la sesioon y muestra un mensaje al usuario
  //********************************************* */
  function cerrar_sesion(){
    session_start();
    session_destroy();
    $mensaje='<div class="alert alert-info"><strong>Se ha cerrado la sesión correctamente</strong></div>';
    echo $mensaje;    
}

  
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/styles.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>PRACTICA 3</title>
  </head>
  <body>
  
  
  
 <?php 
  
  if ( !$usuario_guardado && (isset($_GET["action"]) || isset($_POST["alta"])) ) {  
    // FORMULARIO DE ACCESO 
  ?>
   <section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <h2>Date de alta</h2>
        <form method="post" action="index.php">
        <input type="hidden" name="alta" value="si">
          <div class="form-outline mb-4">
            <h3>Usuario</h3>
            <input type="text" id="usuario" name="usuario" class="form-control form-control-lg" />
            <label class="form-label" for="usuario">Escriba su nombre de usuario</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
          <h3>Clave</h3>
            <input type="password" id="clave" name="clave" class="form-control form-control-lg" />
            <label class="form-label" for="clave">Escriba su clave por favor</label>
          </div>

          <!-- Password2 input -->
          <div class="form-outline mb-4">
          <h3>Repita su clave</h3>
            <input type="password" id="clave2" name="clave2" class="form-control form-control-lg" />
            <label class="form-label" for="clave">repita su clave por favor</label>
          </div>

          <div class="d-flex justify-content-around align-items-center mb-4">
           
          </div>

          <!-- Submit button -->
          <a href="index.php" class="btn btn-info">Volver al login</a>
          <input type="submit" name="enviar"  class="btn btn-primary btn-lg btn-block"></button> 

        </form>
      </div>
    </div>
  </div>
</section> 
  
 <?php } else
  // FORMULARIO DE ACCESO 
 {?> 
 
  <section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form method="post" action="index.php">
          
          <!-- Email input -->
          <div class="form-outline mb-4">
            <h3>Usuario</h3>
            <input type="text" id="usuario" name="usuario" class="form-control form-control-lg" />
            <label class="form-label" for="usuario">Escriba su nombre de usuario</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
          <h3>Clave</h3>
            <input type="password" id="clave" name="clave" class="form-control form-control-lg" />
            <label class="form-label" for="clave">Escriba su clave por favor</label>
          </div>

          <!-- Submit button -->
          <input type="submit" name="enviar" class="btn btn-primary btn-lg btn-block"></button>   <a href="index.php?action=alta">Registro</a>

        </form>
      </div>
    </div>
  </div>
</section>
<?php 
    }
 ?>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>