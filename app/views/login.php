<!--formulario donde se piden usuario y contraseña-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOCKAROO CRUD</title>
</head>
<body>
    <h1>Acceso al sistema</h1>
    <form action="" method="post">
        <table id="login">
            <tr>
                <td>
                    <label for="usuario">Usuario</label>
                </td>
                <td>
                    <input type="text" name="usuario" id="usuario">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="password">Contraseña</label>
                </td>
                <td>
                    <input type="password" name="password" id="password">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Entrar">
                </td>
                <td>
                    <input type="submit" name="cerrar" value="cerrar">
                </td>
            </tr>
        </table>
     
        <?php
        include_once '../models/AccesoDatos.php';
        include_once '../models/Cliente.php';
        include_once '..//controllers/crudclientes.php';
        //quitar warnings
        error_reporting(E_ALL ^ E_NOTICE);

        //una vez que se ha enviado el formulario, se comprueba si el usuario y la contraseña son correctos
        if (isset($_POST['usuario']) && isset($_POST['password'])) {
            //si el nombre de usuario esta registrado en la bbdd
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
           //SI USUARIO Y CONTRASEÑA ES ADMINISTRADOR
            if ($usuario == 'admin' && $password == 'admin') {
                //redirigimos a la pagina de administrador
                session_start();
                $_SESSION['usuario'] = $usuario;
                header('Location: index.php');
            } else {
                //si excedemos 3 intentos, "has superado el numero de intentos"
                session_start();
                $_SESSION['intentos'] = 1;
                echo "Usuario o contraseña incorrectos, has fallado estas veces: " .$_SESSION['intentos'];
                 
                if (isset($_SESSION['intentos'])) {
                    $_SESSION['intentos']++;
                }
                if($_SESSION['intentos'] > 3){
                    echo "Has superado el numero de intentos";
                    die();
                }
            
            
            
        } 
        if(isset($_POST['cerrar'])){
            session_destroy();
            $_SESSION['usuario'] = null;

        }
    
    }
    

        
        ?>

    </form>
</body>
</html>

