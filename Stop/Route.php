<?php
header('Content-Type: text/html; charset=windows-1251');
?>
<html>
<head><title></title></head>
<body><?
    $Oper = $_POST['NOper'];
    $Route_ID = $_POST['NRoute']; // ВЫПАДАЮЩИЙ СПИСОК
    $NumbStop = $_POST['NNumbStop']; // Новый номер остановки
    $Stop_ID = $_POST['NStopID']; // ID остановки
    $Type = $_POST['NType']; // Тип маршрута
    if ($Oper == '2' || $Oper == '3') {
        // Можно здесь сделать запрос!!!!!!!!!!!!!!!!!!!!!!!Й!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $NOldRouteID = $_POST['NOldRouteID']; // Стар ID Маршрута
        $OldStopNumb = $_POST['NOldStopNumb']; // Стар номер остановки        
    } // if
    $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
    $conn = new COM('ADODB.Connection');
    $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 


    if ($Oper == '1') {
        $sql="INSERT INTO StopInRoute (Route_ID,Stop_ID,StopNumb) Values (".$Route_ID.",".$Stop_ID.",".$NumbStop.")";
        // Запрос для Route бновление типа маршрута
        // if($Type == "Автобус") $sql2 = "UPDATE Route SET [Type]='Автобус' WHERE Route_ID = ".$Route_ID;
        // if($Type == "Трамвай") $sql2 = "UPDATE Route SET [Type]='Трамвай' WHERE Route_ID = ".$Route_ID;
        // if($Type == "Троллейбус") $sql2 = "UPDATE Route SET [Type]='Троллейбус' WHERE Route_ID = ".$Route_ID;
        // $rs2 = $conn->Execute($sql2);
    } // if
    if ($Oper == '2') {
        // Запрос для StopInRoute
        $sql = "UPDATE StopInRoute SET Stop_ID=".$Stop_ID.", StopNumb=".$NumbStop." WHERE Route_ID=".$Route_ID.
        " AND StopNumb = ".$OldStopNumb;
        // Запрос для Route бновление типа маршрута
        if($Type == "Автобус") $sql2 = "UPDATE Route SET [Type]='Автобус' WHERE Route_ID = ".$Route_ID;
        if($Type == "Трамвай") $sql2 = "UPDATE Route SET [Type]='Трамвай' WHERE Route_ID = ".$Route_ID;
        if($Type == "Троллейбус") $sql2 = "UPDATE Route SET [Type]='Троллейбус' WHERE Route_ID = ".$Route_ID;
        $rs2 = $conn->Execute($sql2);
    } // if
    if ($Oper == '3') {
        // Получение старого номера остановки
        // $sql = "SELECT StopNumb FROM StopInRoute WHERE Stop_ID=".$Stop_ID." AND Route_ID = ".$Route_ID;
        // $rs = $conn->Execute($sql);
        // $OldStopNumb =  $rs->Fields['StopNumb']->Value;// Стар номер остановки

        $sql = "DELETE FROM StopInRoute WHERE Route_ID=".$Route_ID.
        " AND StopNumb=".$OldStopNumb; 
    } // if
    $rs = $conn->Execute($sql);
    if ($Oper == '1') {
        echo "<h1>Остановка на маршруте добавлена</h1>"; } // if
    if ($Oper == '2') {
        echo "<h1>Остановка на маршруте изменена</h1>"; } // if
    if ($Oper == '3') {
        echo "<h1>Остановка на маршруте удалена</h1>"; } // if ?>
    <a href="http://localhost/zad4/Stop/index.php">Возврат</2>
</body>
</html>