<?php 
     require 'data/functions.php';
     $exec=new Funciones();
     $pers=$exec->auth("Eric","Eric");         
         $rows = [];
         while($row = mysqli_fetch_array($pers))
         {
             $rows[] = $row;
         }
       echo $rows[0]['rol'];
      
?>