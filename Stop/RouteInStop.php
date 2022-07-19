<?php // Подгрузка маршрутов через остановку
   header('Content-Type: text/html; charset=windows-1251');
   $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
   $conn = new COM('ADODB.Connection');
   $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
   $Stop_ID = $_GET["Stop_ID"]; 
   //echo "Stop_ID=".$Stop_ID."<br>";
   $sql3 = 'select StopInRoute.*, Route.Type, Route.Number, Route.Comment from (StopInRoute inner join Route on StopInRoute.Route_ID = Route.Route_ID) where StopInRoute.Stop_ID='. $Stop_ID;
   $rs3 = $conn->Execute($sql3);
   echo '<th hidden>Route_ID</th><th>Тип</th><th>Номер маршрута</th><th>Маршрут</th><th>Номер остановки</th>';
   for ($i=0; !$rs3->EOF; $i++) {
      echo '<tr onclick=TRClick2('.$i.')>';
      echo '<td hidden>'.$rs3->Fields['Route_ID']->Value.'</td>';
      echo '<td>'.$rs3->Fields['Type']->Value.'</td>';
      echo '<td>'.$rs3->Fields['Number']->Value.'</td>';
      echo '<td>'.$rs3->Fields['Comment']->Value.'</td>';
      echo '<td>'.$rs3->Fields['StopNumb']->Value.'</td></tr>';
      $rs3->MoveNext(); 
   } // for 
?>