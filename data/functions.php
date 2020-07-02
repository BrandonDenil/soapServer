<?php
require_once('connection.php');
/**
 *
 */
class Funciones
{

	public function verificarPartida($dpi, $anio) //verifica si la partida esta pagada
	{
		$db = new Datos(); //instancio la clase de conexion
		$db->conectar();  //conecta a la base datos
		$consulta = "SELECT dpi.id_dpi as id, dpi.cui as dpi ,o.fecha_pago  as Fecha,  o.cantidad_pago  as costo
		 FROM DPI as dpi inner join Pagos as o on dpi.id_dpi= o.id_dpi  where dpi.cui=" . $dpi . " 
		 and o.fecha_pago  BETWEEN CAST('" . $anio . "-01-01' AS DATE) AND CAST('" . $anio . "-12-31' AS DATE)";
		$cliente = mysqli_query($db->objetoconexion, $consulta);
		$db->desconectar(); //desconecta de la base de datos
		return $cliente;
	}

	public function verificarBoletoDeOrnato($dpi, $anio) //verifica si la boleta esta pagada
	{	
		$db = new Datos();
		$db->conectar();
		$consulta = "SELECT dpi.id_dpi as id,dpi.cui as dpi,o.fecha_pago  as Fecha, t.costo as costo
		 FROM DPI as dpi inner join Ornato as o on dpi.id_dpi= o.id_dpi inner join Tipo_ornato as t
		 on o.id_tipo= t.id_tipo where dpi.cui=" . $dpi . " and o.fecha_pago  BETWEEN CAST('" . $anio . "-01-01' AS DATE) AND CAST('" . $anio . "-12-31' AS DATE)";
		$cliente = mysqli_query($db->objetoconexion, $consulta);
		$db->desconectar();
		return $cliente;
	}


	public function PagoPartida($persona, $fecha, $cantidad ) //realiza un pago de partida
	{
		$db = new Datos();
		$db->conectar();
		$cadena = "INSERT INTO Pagos (fecha_pago, cantidad_pago, id_dpi) 
		 values('" . $fecha . "'," . $cantidad . "," . $persona . ")";
		$consulta = mysqli_query($db->objetoconexion, $cadena);
		$db->desconectar();
		return $consulta;
	}

	public function PagoBoleta($tipo, $dpi, $fecha) //realiza un pago de boleta
	{

		$db = new Datos();
		$db->conectar();
		$cadena = 'INSERT INTO Ornato (id_tipo,id_dpi,fecha_pago) 
		 values('. $tipo. ',' . $dpi . ',"'. $fecha . '")';
		$consulta = mysqli_query($db->objetoconexion, $cadena);
		$db->desconectar();
		return $cadena;
	}

	public function insertarDPI($cui ) //inserta un dpi
	{
		$db = new Datos();
		$db->conectar();
		$cadena = "INSERT INTO DPI (cui) 
		 values(" . $cui .")";
		$consulta = mysqli_query($db->objetoconexion, $cadena);
		$db->desconectar();
		return $consulta;
	}

	public function auth($user,$pass){ //verifica una autenticacion de credenciales
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