<?php
//acceso a datos de la clase usuario
class AccesoDatosUsu {
    
    private static $modelo = null;
    private $dbh = null;
    
    public static function getModelo(){
        if (self::$modelo == null){
            self::$modelo = new AccesoDatosUsu();
        }
        return self::$modelo;
    }
    
    // Constructor privado  Patron singleton
    
    private function __construct(){
        
       
         $this->dbh = new mysqli(DB_SERVER,DB_USER,DB_PASSWD,DATABASE);
         
      if ( $this->dbh->connect_error){
         die(" Error en la conexión ".$this->dbh->connect_errno);
        } 

    }

    // Cierro la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModelo(){
        if (self::$modelo != null){
            $obj = self::$modelo;
            // Cierro la base de datos
            $obj->dbh->close();
            self::$modelo = null; // Borro el objeto.
        }
    }

    // Devuelvo cuantos filas tiene la tabla

    public function numUsuarios ():int {
      $result = $this->dbh->query("SELECT id FROM users");
      $num = $result->num_rows;  
      return $num;
    }
    //rol de usuario
    public function getRol ($user):string {
        $rol = "";
        // Crea la sentencia preparada
        $stmt = $this->dbh->prepare("SELECT rol FROM users WHERE user = ?");
        // Asocia los parámetros
        $stmt->bind_param("s",$user);
        // Ejecuta la sentencia
        $stmt->execute();
        // Asocia las variables de resultado
        $stmt->bind_result($rol);
        // Recupera los valores
        $stmt->fetch();
        // Cierra la sentencia
        $stmt->close();
        return $rol;
    }
    //get usuario y contraseña cifrada
    public function getUsuario ($user):array {
        $tuser = [];
        // Crea la sentencia preparada
        $stmt = $this->dbh->prepare("SELECT user,password FROM users WHERE user = ?");
        // Asocia los parámetros
        $stmt->bind_param("s",$user);
        // Ejecuta la sentencia
        $stmt->execute();
        // Asocia las variables de resultado
        $stmt->bind_result($tuser['user'],$tuser['password']);
        // Recupera los valores
        $stmt->fetch();
        // Cierra la sentencia
        $stmt->close();
        return $tuser;
    }
    //get usuario y contraseña cifrada
    public function getUsuarioId ($id):array {
        $tuser = [];
        // Crea la sentencia preparada
        $stmt = $this->dbh->prepare("SELECT user,password FROM users WHERE id = ?");
        // Asocia los parámetros
        $stmt->bind_param("i",$id);
        // Ejecuta la sentencia
        $stmt->execute();
        // Asocia las variables de resultado
        $stmt->bind_result($tuser['user'],$tuser['password']);
        // Recupera los valores
        $stmt->fetch();
        // Cierra la sentencia
        $stmt->close();
        return $tuser;
    }
    

}

?>