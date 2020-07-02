<?php 
 require 'data/functions.php';
    class server
    {   
        private $auth=false; //variable de sesion
        private $rol="none";// variable de rol 
        public function __construct()
        {
            
        }

        public  function authenticate($header_params){ //funcion de autenticación
            $usuario=$header_params->username; //usuario obtenido
            $contrasenia=$header_params->password; // 
            $exec=new Funciones();
            $pers=$exec->auth($usuario,$contrasenia);
            if ($pers->num_rows > 0){
                $this->auth= true;             
                $rows = [];
                while($row = mysqli_fetch_array($pers))
                {
                    $rows[] = $row;
                }
                if($rows[0]['rol']=="Administrador") $this->rol="Administrador";
                elseif($rows[0]['rol']=="Lectura") $this->rol="Lectura";
             }
             else $this->auth=false;
        }

        public function verificarBoleto($dpi,$anio){  // verifica que el boleto de ornato este cancelado el presente año
            if (($this->auth==false) || ($this->rol!="Administrador")) throw new SoapFault("Error al autenticar",401);   // solo para  administradores
            $exec=new Funciones();
            $pers=$exec->verificarBoletoDeOrnato($dpi,$anio);
            if ($pers->num_rows > 0){             
                $rows = [];
                while($row = mysqli_fetch_array($pers))
                {
                    $rows[] = $row;
                }
                return $rows[0]['id'];//retorna el id de la boleta de ornato
                 }
             else return "false";
        }  

        public function verificarPartida($dpi,$anio){ //verifica que la partida de nacimiento este cancelada el presente año
            if ((($this->auth==true) && ($this->rol=="Lectura"))||(($this->auth==true) && ($this->rol=="Administrador"))) { //permisos requeridos
                $exec=new Funciones();
                $pers=$exec->verificarBoletoDeOrnato($dpi,$anio);
                if ($pers->num_rows > 0){             
                    $rows = [];
                    while($row = mysqli_fetch_array($pers))
                    {
                        $rows[] = $row;
                    }
                    return "true";//retorna true si la partida esta pagada
                 }
                 else return "false";//retorna false si la partida no esta pagada
            }
            else throw new SoapFault("Error al autenticar".$this->auth.$this->rol ,401);//lanza un error de autenticación 
           
        } 


        public function realizarPago($persona,$cantidad){ // realiza un pago de partida
            if (($this->auth==false) || ($this->rol!="Administrador")) throw new SoapFault("Error al autenticar",401); // solo para administradores 
            $exec=new Funciones();
            $pers=$exec->PagoPartida($persona,date("Y/m/d"),$cantidad);
            return "pago realizado";
        } 

        public function pagarBoleta($tipo,$persona){ // realiza un pago de partida
            if (($this->auth==false) || ($this->rol!="Administrador")) throw new SoapFault("Error al autenticar",401); // solo para administradores 
            $exec=new Funciones();
            $pers=$exec->PagoBoleta($tipo,$persona,date("Y/m/d"));
            return "pago realizado";
        } 

        public function insertarDpi($cui){ // realiza un pago de partida
            if (($this->auth==false) || ($this->rol!="Administrador")) throw new SoapFault("Error al autenticar",401); // solo para administradores 
            $exec=new Funciones();
            $pers=$exec->insertarDPI($cui);
            return "dpi insertado";
        } 
    }

$params = array("uri"=>"www/soap/server.php");
$server = new SoapServer(NULL,$params);
$server->setClass("server");
$server->handle();
?>