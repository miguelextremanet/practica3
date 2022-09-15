<?php  
  session_start();
  require_once "config.php";
  $mensaje='<div class="alert alert-danger">No tiene acceso a esta página. Volver al <a href="index.php">login</a></div>';

  if (isset($_SESSION['usuario']) && isset($_SESSION['clave']) ){
      $usuario = $_SESSION['usuario'];
      $clave   = $_SESSION['clave'];    

      // si viene sesion, igualmente busco el usaurio por si hubiera cambiado la clave o 
      // se hubiera borrado el usuario o modificado algo en la base de datos       
      if (existe_usuario($conexion,$usuario, $clave)){        
        $mensaje='  
        <div class="container  px-4 py-4">
        <div class="row flex-nowrap justify-content-between align-items-center">
          <div class="col-12 d-flex justify-content-end align-items-center">            
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"/><circle cx="12" cy="10" r="3"/><circle cx="12" cy="12" r="10"/></svg>
            <b>Hola <strong>'.$_SESSION['usuario'].'</strong> </b> 
            &nbsp;<a class="btn btn-sm btn-outline-secondary" href="index.php?logout=true">Cerrar sesión</a>
          </div>
        </div>
      </div>';          
      }  
  }

  echo $mensaje;




?>
<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/styles.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>PRACTICA 3 pagina de usuarios</title>
  </head>
  <body>
  <?php
    // para mostrar el contenido el usuario debe estar logegado y debería existir 
    
      if (isset($_SESSION['usuario'])  &&  (existe_usuario($conexion,$usuario, $clave)) ){
      ?>
          <div class="container px-4 py-1">
            <h2 class="border-bottom">Listado de usuarios</h2>
          </div>
          
          <div class="container px-1 py-1" id="custom-cards">           
              <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4">  
              <?php
                  $sql = "select id, username from users order by username";
                  $resultado = mysqli_query($conexion,$sql);   
                  if (mysqli_num_rows($resultado) > 0){
                    $contador=1;

                     while($row = mysqli_fetch_assoc($resultado)) {
                              $foto = "http://sc.extremanet.com/assets/unsplash-photo-".$contador.".jpg";
                              ?>  
                              
                              <div class="col">
                                  <div class="card card-cover h-100 overflow-hidden text-white bg-dark rounded-5 shadow-lg" style="background-image: url('<?echo $foto?>');">
                                    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                      <h2 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold"><?php echo $row['username']?></h2>
                                      <ul class="d-flex list-unstyled mt-auto">
                                        <li class="me-auto">
                                          <img src="https://github.com/twbs.png" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                                        </li>
                                        <li class="d-flex align-items-center me-3">
                                          <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#geo-fill"></use></svg>
                                          <small>ID Usuario:</small>
                                        </li>
                                        <li class="d-flex align-items-center">
                                          <svg class="bi me-2" width="1em" height="1em"><use xlink:href="#calendar3"></use></svg>
                                          <small><?php echo $row['id']?></small>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div>

                              <?php         
                              
                              if ($contador>=3) {
                                   $contador=0;
                              }
                              $contador+=1;
                              
                          }                             
                 } ?> 

            </div>

          
          </div>


       

  <?php } ?> 
  
 
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    
  </body>
</html>