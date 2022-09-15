<?php
    define("DB_SERVER","localhost");
    define("DB_USERNAME","practica3");
    define("DB_PASSWORD","1031practica3");
    define("DB_NAME","practica3");

    $conexion = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
    
    if ($conexion == false){
        die("ERROR, no se puede abrir la conexión a la base de datos". mysqli_connect_error());
    }else{
        //echo "Conexión establecida";    
    }
     
    
    
    //********************************************* */
    // función que comprueba que no exista ya un usuario 
    //********************************************* */
    function ya_existe_usuario($condb,$usuario){
        $sql = "select username from users where username='$usuario'";
        $resultado = mysqli_query($condb,$sql);                        
        return (mysqli_num_rows($resultado) > 0) ;   
    };

    
    //********************************************* */
    // función que guarda el usuario nuevo 
    //********************************************* */
    function guardar_usuario($condb,$usuario,$clave){
        
        $clavejaseada = password_hash($clave,PASSWORD_DEFAULT);
        $sql = "insert into users(username,password) values ('$usuario','$clavejaseada')";
        $resultado = mysqli_query($condb,$sql);
        return ($resultado);
    }
    
    //********************************************* */
    // función que devuelve si un usuario existe o no
    //********************************************* */
    function existe_usuario($condb,$usuario,$clave){     
        
        //$sql = "select username from users where username='$usuario' and password='$clave'";
        $sql = "select username,password from users where username='$usuario'";
        $resultado = mysqli_query($condb,$sql);                
        
        if (mysqli_num_rows($resultado) > 0){
            if ($row = mysqli_fetch_array($resultado)){                
                 //comprueba que la clave que llega es igual al has guardado en la base de datos 
                return  (password_verify($clave,$row["password"]));
            }else{
                return false;           
            }    
        }else{
            return false;           
        }

   }


    // funcion de pruebas no vale para nada ya 
  function existe_usuario_TEST($usuario,$clave){

     /*   if ($usuario=="miguel" && $clave=="1234"){
            return true;
        }else{
             return false;
        }  */
   }

?>