<?php
require_once('connection.php');
/**
 *
 */
class Funciones
{

	public function verificarPartida($dpi, $anio)
	{
		$db = new Datos(); //instancio la clase de conexion
		$db->conectar();  //conecta a la base datos
		$consulta = "SELECT p.id_persona as id,p.cui as dpi,p.nombres,p.apellidos,o.fecha_pago  as Fecha, t.costo as costo
		 FROM Persona as p inner join Pagos as o on p.id_persona= o.id_persona  where p.cui=" . $dpi . " 
		 and o.fecha_pago  BETWEEN CAST('" . $anio . "-01-01' AS DATE) AND CAST('" . $anio . "-12-31' AS DATE)";
		$cliente = mysqli_query($db->objetoconexion, $consulta);
		$db->desconectar(); //desconecta de la base de datos
		return $cliente;
	}

	public function verificarBoletoDeOrnato($dpi, $anio)
	{	
		$db = new Datos();
		$db->conectar();
		$consulta = "SELECT p.id_persona as id,p.cui as dpi,p.nombres,p.apellidos,o.fecha_pago  as Fecha, t.costo as costo
		 FROM Persona as p inner join Ornato as o on p.id_persona= o.id_persona inner join Tipo_ornato as t
		 on o.id_tipo= t.id_tipo where p.cui=" . $dpi . " and o.fecha_pago  BETWEEN CAST('" . $anio . "-01-01' AS DATE) AND CAST('" . $anio . "-12-31' AS DATE)";
		$cliente = mysqli_query($db->objetoconexion, $consulta);
		$db->desconectar();
		return $cliente;
	}


	public function PagoPartida($persona, $fecha, $cantidad, $tipo)
	{
		$db = new Datos();
		$db->conectar();
		$cadena = "INSERT INTO Pagos (fecha_pago, cantidad_pago, id_tipo,id_persona) 
		 values(" . $fecha . "," . $cantidad . "," . $tipo . "," . $persona . ")";
		$consulta = mysqli_query($db->objetoconexion, $cadena);
		$db->desconectar();
		return $consulta;
	}

	public function tipos_pagos()
	{
		$db = new Datos();
		$db->conectar();
		$consulta = "SELECT id_tipo as id, tipo from Tipo_Pago";
		$cliente = mysqli_query($db->objetoconexion, $consulta);
		$db->desconectar();
		return $cliente;
	}

	public function auth($user,$pass){
		$db = new Datos();
		$db->conectar();
		$consulta = "SELECT u.nombre_usuario as user, u.password as password, r.nombre_rol  as rol from Usuarios as u
		inner join Roles as r on r.id_rol=u.id_rol where u.nombre_usuario='$user' and u.password='$pass'";
		$cliente = mysqli_query($db->objetoconexion, $consulta);
		$db->desconectar();
		return $cliente;
	}
}

?>