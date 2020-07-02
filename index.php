<?php 

$mysqli = mysqli_connect("localhost", "denil", "56968", "Pagos_partidas");

/* verificar conexión */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
	
$mysqli->begin_transaction(1);
         for ($d=0;$d<1;$d++)
{
        $cantida=rand(1, 10);
        $id=rand(1,2503);
        $tipo=rand(1,5);
        $fecha= date("Y-m-d", mt_rand(943916400, 1590962400));
  
        //
        $query = 'INSERT INTO Ornato (id_tipo,id_dpi,fecha_pago) 
        values(?,?,?)';
        $stmt=$mysqli->prepare($query);
       $stmt->bind_param('iis',$tipo,$id,$fecha);
       $stmt->execute();
       //pagos
       $query = "INSERT INTO Pagos (fecha_pago, cantidad_pago, id_dpi) 
       values(?,?,?)";
         $stmt=$mysqli->prepare($query);
         $stmt->bind_param('sdi',$fecha,$cantida,$id);
         $stmt->execute();
       echo 'boleta ingresada:'.$d.' <br/>';
}
  
    $stmt->close();
    $mysqli->query('COMMIT');
    echo 'listo';
    // require 'data/functions.php';
    // $exec=new Funciones();
        // echo date("Y-m-d", mt_rand(943916400, 1590962400))."<br />";
        // for ($d=0;$d<20;$d++){
        //     echo mt_rand(1, 5).' <br/>';
        //  }
    // echo $exec->PagoBoleta(1,1,'2020-06-02');


    // for ($d=0;$d<70000;$d++){
    //     $cantida=rand(1, 10);
    //     $id=rand(1,2503);
    //     $tipo=rand(1,5);
    //     $fecha= date("Y-m-d", mt_rand(943916400, 1590962400));
        
    //    echo 'boleta ingresada:'.$d.' <br/>';
    // }
    // echo var_dump($data);
    //  require 'data/functions.php';
    //  $exec=new Funciones();
    //  $pers=$exec->verificarBoletoDeOrnato("1231231231231","2020");         
    //      $rows = [];
    //      while($row = mysqli_fetch_array($pers))
    //      {
    //          $rows[] = $row;
    //      }
    //      echo $rows[0]['dpi'];
