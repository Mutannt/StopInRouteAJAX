<html>
<head><title></title></head>
<body><?
 $Oper = $_POST['NOper'];
 if ($Oper == '1' || $Oper == '2') {
	$Type = $_POST['NType'];
	$Number = $_POST['NNumber'];
	$Comment = $_POST['NComment'];
 } // if
 if ($Oper == '2' || $Oper == '3') {
	$ID = $_POST['NID'];
 } // if
 $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
 $conn = new COM('ADODB.Connection');
 $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
 if ($Oper == '1') {
	$sql = "INSERT INTO Route (Type, [Number], comment) Values 
('".$Type."',".$Number.",'".$Comment."')"; } // if
 if ($Oper == '2') {
	$sql = "UPDATE Route SET Type='".$Type."', [Number]=".$Number.",
comment='".$Comment."' WHERE Route_ID=".$ID; } // if
 if ($Oper == '3') {
	$sql = "DELETE FROM Route WHERE Route_ID=".$ID; } // if
 $rs = $conn->Execute($sql);
 if ($Oper == '1') {
	echo "<h1>Добавлен маршрут</h1>";
	echo "<table border=0>";
	echo "<tr><td>Тип</td><td>".$Type."</td></tr>";
	echo "<tr><td>Номер</td><td>".$Number."</td></tr>";
	echo "<tr><td>Маршрут</td><td>".$Comment."</td></tr>";
	echo "</table>"; } // if
 if ($Oper == '2') {
	echo "<h1>Изменен маршрут</h1>";
	echo "<table border=0>";
	echo "<tr><td>Тип</td><td>".$Type."</td></tr>";
	echo "<tr><td>Номер</td><td>".$Number."</td></tr>";
	echo "<tr><td>Маршрут</td><td>".$Comment."</td></tr>";
	echo "</table>"; } // if
 if ($Oper == '3') {
	echo "<h1>Удален маршрут</h1>";
	echo "<table border=0>";
	echo "<tr><td>ID</td><td>".$ID."</td></tr>";
	echo "</table>"; } // if ?>
<a href="http://localhost/zad4/index.php">Возврат</2>
</body></html>
