<?php //Программа получения остановок на маршруте 
   header('Content-Type: text/html; charset=windows-1251');
   $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
   $conn = new COM('ADODB.Connection');
   $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
   $Route_ID = $_GET["Route_ID"]; 
   //echo "Route_ID=".$Route_ID."<br>";
   $sql3 = 'select StopInRoute.*, Stop.Name from (StopInRoute inner join Stop on StopInRoute.Stop_ID = Stop.Stop_ID) where StopInRoute.Route_ID='. $Route_ID;
   $rs3 = $conn->Execute($sql3);
   echo '<th hidden>Stop_ID</th><th>Номер</th><th>Название</th>';
   for ($i=0; !$rs3->EOF; $i++) {
      echo '<tr onclick=TRClick2('.$i.')>';
      echo '<td hidden>'.$rs3->Fields['Stop_ID']->Value.'</td>';
      echo '<td>'.$rs3->Fields['StopNumb']->Value.'</td>';
      echo '<td>'.$rs3->Fields['Name']->Value.'</td></tr>';
      $rs3->MoveNext(); 
   } // for 
?>
