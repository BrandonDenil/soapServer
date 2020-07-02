<?php

class Datos
{

	private $servidor='localhost';
	private $usuario="denil";
	private $pass="56968";
	private $db="Pagos_partidas";
	public $objetoconexion;

	public function conectar(){ //crea una conexion a una base de datos
		$this->objetoconexion=mysqli_connect($this->servidor,$this->usuario,
			$this->pass,$this->db) or die("Error conection");
	}

	public function desconectar(){ //termina la conexion
		mysqli_close($this->objetoconexion);
	}
}
?>