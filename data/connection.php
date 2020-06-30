<?php
class Datos
{

	private $servidor='localhost';
	private $usuario="denil";
	private $pass="56968";
	private $db="SistemaC";
	public $objetoconexion;

	public function conectar(){
		$this->objetoconexion=mysqli_connect($this->servidor,$this->usuario,
			$this->pass,$this->db) or die("Error conection");
	}

	public function desconectar(){
		mysqli_close($this->objetoconexion);
	}
}
?>