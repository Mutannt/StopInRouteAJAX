<?php
header('Content-Type: text/html; charset=windows-1251');
?>
<html>
<head><title></title></head>
<body><?
    // header('Content-Type: text/html; charset=windows-1251');
    $Oper = $_POST['NOper'];
    $Stop_ID = $_POST['NStop'];
    $StopNumb = $_POST['NStopNumb'];
    $Route_ID = $_POST['NRouteID'];
    if ($Oper == '2' || $Oper == '3') {
        $OldStop_ID = $_POST['NOldStopID'];
        $OldStopNumb = $_POST['NOldStopNumb'];
    } // if
    $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
    $conn = new COM('ADODB.Connection');
    $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
    if ($Oper == '1') {
    $sql="INSERT INTO StopInRoute (Route_ID,Stop_ID,StopNumb) Values (".
        $Route_ID.",".$Stop_ID.",".$StopNumb.")"; 
    } // if
    if ($Oper == '2') {
        $sql = "UPDATE StopInRoute SET Stop_ID=".$Stop_ID.
        ", StopNumb=".$StopNumb." WHERE Route_ID=".$Route_ID.
        " AND StopNumb = ".$OldStopNumb; 
    } // if
    if ($Oper == '3') {
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
    <a href="http://localhost/zad4/index.php">Возврат</2>
</body>
</html>
