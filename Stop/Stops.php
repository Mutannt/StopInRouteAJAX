<?php
header('Content-Type: text/html; charset=windows-1251');
?>
<html>
<head><title></title></head>
<body><?
	$Oper = $_POST['NOper'];
	if ($Oper == '1' || $Oper == '2') {
		$Stop = $_POST['NStop'];
	} // if
	if ($Oper == '2' || $Oper == '3') {
		$ID = $_POST['NID'];
	} // if
	$db = 'Z:\home\localhost\www\zad4\Transport.mdb';
	$conn = new COM('ADODB.Connection');
	$conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
	if ($Oper == '1') {
		$sql = "INSERT INTO Stop ([Name]) Values ('".$Stop."')"; } // if
	if ($Oper == '2') {
		$sql = "UPDATE Stop SET Name='".$Stop."' WHERE Stop_ID=".$ID; } // if
	if ($Oper == '3') {
		$sql = "DELETE FROM Stop WHERE Stop_ID=".$ID; } // if
	$rs = $conn->Execute($sql);
	if ($Oper == '1') {
		echo "<h1>Добавлена остановка</h1>";
		echo "<table border=0>";
		echo "<tr><td>Название остановки: </td><td>".$Stop."</td></tr>";
		echo "</table>"; } // if
	if ($Oper == '2') {
		echo "<h1>Изменена остановка</h1>";
		echo "<table border=0>";
		echo "<tr><td>Название остановки: </td><td>".$Stop."</td></tr>";
		echo "</table>"; } // if
	if ($Oper == '3') {
		echo "<h1>Удалена остановка</h1>";
		echo "<table border=0>";
		echo "<tr><td>ID</td><td>".$ID."</td></tr>";
		echo "</table>"; } // if ?>
	<a href="http://localhost/zad4/stop/">Возврат</2>
</body></html>
