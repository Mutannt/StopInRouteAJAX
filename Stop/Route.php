<?php
header('Content-Type: text/html; charset=windows-1251');
?>
<html>
<head><title></title></head>
<body><?
    $Oper = $_POST['NOper'];
    $Route_ID = $_POST['NRoute']; // ���������� ������
    $NumbStop = $_POST['NNumbStop']; // ����� ����� ���������
    $Stop_ID = $_POST['NStopID']; // ID ���������
    $Type = $_POST['NType']; // ��� ��������
    if ($Oper == '2' || $Oper == '3') {
        // ����� ����� ������� ������!!!!!!!!!!!!!!!!!!!!!!!�!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $NOldRouteID = $_POST['NOldRouteID']; // ���� ID ��������
        $OldStopNumb = $_POST['NOldStopNumb']; // ���� ����� ���������        
    } // if
    $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
    $conn = new COM('ADODB.Connection');
    $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 


    if ($Oper == '1') {
        $sql="INSERT INTO StopInRoute (Route_ID,Stop_ID,StopNumb) Values (".$Route_ID.",".$Stop_ID.",".$NumbStop.")";
        // ������ ��� Route ��������� ���� ��������
        // if($Type == "�������") $sql2 = "UPDATE Route SET [Type]='�������' WHERE Route_ID = ".$Route_ID;
        // if($Type == "�������") $sql2 = "UPDATE Route SET [Type]='�������' WHERE Route_ID = ".$Route_ID;
        // if($Type == "����������") $sql2 = "UPDATE Route SET [Type]='����������' WHERE Route_ID = ".$Route_ID;
        // $rs2 = $conn->Execute($sql2);
    } // if
    if ($Oper == '2') {
        // ������ ��� StopInRoute
        $sql = "UPDATE StopInRoute SET Stop_ID=".$Stop_ID.", StopNumb=".$NumbStop." WHERE Route_ID=".$Route_ID.
        " AND StopNumb = ".$OldStopNumb;
        // ������ ��� Route ��������� ���� ��������
        if($Type == "�������") $sql2 = "UPDATE Route SET [Type]='�������' WHERE Route_ID = ".$Route_ID;
        if($Type == "�������") $sql2 = "UPDATE Route SET [Type]='�������' WHERE Route_ID = ".$Route_ID;
        if($Type == "����������") $sql2 = "UPDATE Route SET [Type]='����������' WHERE Route_ID = ".$Route_ID;
        $rs2 = $conn->Execute($sql2);
    } // if
    if ($Oper == '3') {
        // ��������� ������� ������ ���������
        // $sql = "SELECT StopNumb FROM StopInRoute WHERE Stop_ID=".$Stop_ID." AND Route_ID = ".$Route_ID;
        // $rs = $conn->Execute($sql);
        // $OldStopNumb =  $rs->Fields['StopNumb']->Value;// ���� ����� ���������

        $sql = "DELETE FROM StopInRoute WHERE Route_ID=".$Route_ID.
        " AND StopNumb=".$OldStopNumb; 
    } // if
    $rs = $conn->Execute($sql);
    if ($Oper == '1') {
        echo "<h1>��������� �� �������� ���������</h1>"; } // if
    if ($Oper == '2') {
        echo "<h1>��������� �� �������� ��������</h1>"; } // if
    if ($Oper == '3') {
        echo "<h1>��������� �� �������� �������</h1>"; } // if ?>
    <a href="http://localhost/zad4/Stop/index.php">�������</2>
</body>
</html>