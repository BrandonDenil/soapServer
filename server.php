<?php 
 require 'data/functions.php';
    class server
    {   
        private $auth=false;
        private $rol="none";
        public function __construct()
        {
            
        }

        public  function authenticate($header_params){ //funcion de autenticación
            $usuario=$header_params->username;
            $contrasenia=$header_params->username;
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

        public function verificarBoleto($dpi){  // verifica que el boleto de ornato este cancelado el presente año
            if (($this->auth==false) || ($this->rol!="Administrador")) throw new SoapFault("Error al autenticar",401);  
            $exec=new Funciones();
            $pers=$exec->verificarBoletoDeOrnato($dpi,date("Y"));
            if ($pers->num_rows > 0){             
                $rows = [];
                while($row = mysqli_fetch_array($pers))
                {
                    $rows[] = $row;
                }
                return $rows[0]['id'];
                 }
             else return "false";
        }  

        public function verificarPartida($dpi){ //verifica que la partida de nacimiento este cancelada el presente año
            if ((($this->auth==true) && ($this->rol=="Lectura"))||(($this->auth==true) && ($this->rol=="Administrador"))) {
                $exec=new Funciones();
                $pers=$exec->verificarBoletoDeOrnato($dpi,date("Y"));
                if ($pers->num_rows > 0){             
                    $rows = [];
                    while($row = mysqli_fetch_array($pers))
                    {
                        $rows[] = $row;
                    }
                    return "true";
                 }
                 else return "false";
            }
            else throw new SoapFault("Error al autenticar".$this->auth.$this->rol ,401);//lanza un error de autenticación 
           
        } 


        public function realizarPago($persona,$cantidad,$tipo){ // realiza un pago de partida
            if (($this->auth==false) || ($this->rol!="Administrador")) throw new SoapFault("Error al autenticar",401);  
            $exec=new Funciones();
            $pers=$exec->PagoPartida($persona,date("Y/m/d"),$cantidad,$tipo);
            return "pago realizado";
        } 
    }

$params = array("uri"=>"www/soap/server.php");
$server = new SoapServer(NULL,$params);
$server->setClass("server");
$server->handle();
?>