<?php

function crudBorrar ($id){    
    $db = AccesoDatos::getModelo();
    $tuser = $db->borrarCliente($id);
}

function crudTerminar(){
    AccesoDatos::closeModelo();
    session_destroy();
}
 
function crudAlta(){
    $cli = new Cliente();
    $orden= "Nuevo";
    include_once "app/views/formulario.php";
}

function crudDetalles($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    
    include_once "app/views/detalles.php";
}

function crudDetallesSiguiente($id){
  
    $db = AccesoDatos::getModelo();
    //si pincho en siguiente, que me muestre el siguiente cliente
    $cli = $db->getClienteSiguiente($id);
    //si no hay siguiente cliente, que me muestre el mismo cliente
    if($cli==null){
        $cli = $db->getCliente($id);
    }
    

    include_once "app/views/detalles.php";
    
}

function crudDetallesAnterior($id){

   //que muestre el cliente anterior al pinchar el boton anterior
   $db = AccesoDatos::getModelo();
   //MOSTRAR EL CLIENTE SIGUIENTE AL PINCHAR EL BOTON SIGUIENTE
    $cli = $db->getClienteAnterior($id);
    if($cli==null){
        $cli = $db->getCliente($id);
    }
   include_once "app/views/detalles.php";


}
function fotoClienteFormato($id) {
    $fichero = str_pad(0, 7, "0", STR_PAD_LEFT);
    $fichero = substr($fichero, 0, 8 - strlen($id)) . $id;
    $fichero = "app/uploads/" . $fichero . ".jpg";
    $formato = $_FILES['foto']['type'];
    $peso = $_FILES['foto']['size'];
    if ($peso <= 1000000) {
        if ($formato == "image/jpg" || $formato == "image/png") {
            if (!file_exists($fichero)) {
                move_uploaded_file($_FILES['foto']['tmp_name'], $fichero);
            } else {
                unlink($fichero);
                move_uploaded_file($_FILES['foto']['tmp_name'], $fichero);
            }
        } else {
            echo "no es una imagen";
        }
    } else {
        echo "supera el tamaño";
    }
}




function crudModificar($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $orden="Modificar";
    include_once "app/views/formulario.php";
}

function crudModificarSiguiente($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteSiguiente($id);
    if($cli==null){
        $cli = $db->getCliente($id);
    }
    include_once "app/views/formulario.php";
}

function crudModificarAnterior($id){
    $db = AccesoDatos::getModelo();
    $cli = $db->getClienteAnterior($id);
    if($cli==null){
        $cli = $db->getCliente($id);
    }
   
    
    include_once "app/views/formulario.php";
}


function crudPostAlta(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $cli = new Cliente();
    $cli->id            =$_POST['id'];
    $cli->first_name    =$_POST['first_name'];
    $cli->last_name     =$_POST['last_name'];
    $cli->email         =$_POST['email'];	
    $cli->gender        =$_POST['gender'];
    $cli->ip_address    =$_POST['ip_address'];
    $cli->telefono      =$_POST['telefono'];
    $db = AccesoDatos::getModelo();
    $db->addCliente($cli);
    $acceso = true;
    if ($db->getClienteEmail($cli->email)){
        echo "El email fue registrado<br>";
        $acceso=false;
    }
        else if (!comprobarIP($cli->ip_address)){
            echo "La ip no esta bien puesta";
            $acceso=false;
        } 
        
    if ($acceso) {
        $db->addCliente($cli);
        cambiarIcon($cli->id);
    } else {
        include_once "app/views/formulario.php";
    }

    
    
}

function comprobarIP($ip){ //Comprueba que la ip tenga el formato correcto
    $buena=true;
    $partes=explode(".",$ip);
    if (count($partes)!=4) {
        $buena=false;
    } else {
        foreach ($partes as $parte) {
            if (!is_numeric($parte) || $parte<0 || $parte>255) {
                $buena=false;
            }
        }

}
    return $buena;    
}

function origenFoto($id){
    $fichero="app/uploads/$id.jpg";
    if (file_exists($fichero)) {
        return "$id.jpg";
    }
    $fichero="app/uploads/$id.png";
    if (file_exists($fichero)) {
        return "$id.png";
    }
    
    return "<img src='https://robohash.org/$id' width='20'>";


}

function comprobarFotoPerfil($id){
    $fichero=origenFoto($id);
    $fichero="app/uploads/".$fichero;
    if (file_exists($fichero)) {
        return "<img src='$fichero' width='20'>";
    }
    //si no existe la foto, que me devuelva un icono de usuario de robohash

    return "<img src='https://robohash.org/$id' width='20'>";

}


function cambiarIcon($id){
    $fichero="app/uploads/".origenFoto($id);
        move_uploaded_file($_FILES['foto']['tmp_name'],$fichero);
   }

function crudPostModificar(){
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    $cli = new Cliente();

    $cli->id            =$_POST['id'];
    $cli->first_name    =$_POST['first_name'];
    $cli->last_name     =$_POST['last_name'];
    $cli->email         =$_POST['email'];	
    $cli->gender        =$_POST['gender'];
    $cli->ip_address    =$_POST['ip_address'];
    $cli->telefono      =$_POST['telefono'];
    $db = AccesoDatos::getModelo();
    $db->modCliente($cli);
    $acceso=true;
    if (!comprobarIP($cli->ip_address)){
            echo "La ip no es correcta, no se puede dar de alta <br>";
            $acceso=false;
        } 
        
    if ($acceso) {
        cambiarIcon($cli->id);
        $db->modCliente($cli);
    } else {
        $orden= "Nuevo";
        include_once "app/views/formulario.php";
    }
    

}
function mostrarMapa($ip){

    $url = "http://ip-api.com/json/" . $ip;
    $json = file_get_contents($url);
    $datos = json_decode($json, true);

    if ($datos['status'] == "fail") {
        echo "No hay mapa";
    } else {
        $lat = $datos['lat'];
        $lon = $datos['lon'];
        echo "<iframe src='https://maps.google.com/maps?q=$lat,$lon&z=15&output=embed' width='200' height='200' frameborder='0' style='border:0' allowfullscreen></iframe>";
    }
}



function imprimirPdf($id){
    require('app\controllers\imprimir\fpdf.php');
    $db = AccesoDatos::getModelo();
    $cli = $db->getCliente($id);
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Datos del cliente');
    $pdf->Ln();
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(40,10,'ID: '.$cli->id);
    $pdf->Ln();
    $pdf->Cell(40,10,'Nombre: '.$cli->first_name);
    $pdf->Ln();
    $pdf->Cell(40,10,'Apellido: '.$cli->last_name);
    $pdf->Ln();
    $pdf->Cell(40,10,'Email: '.$cli->email);
    $pdf->Ln();
    $pdf->Cell(40,10,'Genero: '.$cli->gender);
    $pdf->Ln();
    $pdf->Cell(40,10,'IP: '.$cli->ip_address);
    $pdf->Ln();
    $pdf->Cell(40,10,'Telefono: '.$cli->telefono);
    $pdf->Ln();
    $pdf->Cell(40,10,'Foto: ');
   //si existe la foto, que la muestre en el pdf
    if(file_exists("app/uploads/".$cli->id.".jpg")){
        $pdf->Image("app/uploads/".$cli->id.".jpg", 10, 80, 50, 50);
    }else {
        //descargar la foto de robohash y guardarla en el pdf
         $imagen=file_get_contents('https://robohash.org/'.$cli->id);
        file_put_contents('app/uploads/'.$cli->id.'.png',$imagen);
        $pdf->Image('app/uploads/'.$cli->id.'.png', 90, 100, 90, 80, 'PNG', 'http://www.fpdf.org');
    }
    $pdf->Ln();
    
    $pdf->Output();
    //ob
    $pdf->Output('app\controllers\imprimir\pdf\pdf.pdf','F');
    header('Location: app\controllers\imprimir\pdf\pdf.pdf');

}



function ordenarboton($valor){
    $_SESSION['campo']=$valor;
    $db = AccesoDatos::getModelo();
    $tvalores = $db->getClientesordenar($_SESSION['posini'],FPAG,$_SESSION['campo']);
    include_once "app/views/list.php";
}

function banderaPais($ip){

    $bandera=file_get_contents('http://ip-api.com/json/'.$ip.'?fields=countryCode');
    $bandera=substr($bandera,16,2);
    $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    if($ipdat->geoplugin_countryCode == null) {
      echo "<img src='https://upload.wikimedia.org/wikipedia/commons/f/f0/One_piece_logo.png' width='20'>";
    } else {
        $datos=$ipdat->geoplugin_countryCode;
        echo "<img src='https://flagcdn.com/".strtolower($datos).".svg' width='10' alt='flag'>";
    }

}

function comprobarLogin($usu, $pass){
    $db = AccesoDatos::getModelo();
    //$usuario = $db->getUsuario($usu);
    //if ($usuario->password == $pass){
        return true;
    //}else{
        return false;
    }



?>
