<?php 
// Установим кодировку windows-1251
 header('Content-Type: text/html; charset=windows-1251');
  // Формируем первую строку
 echo '<select id="IRoute">';
 // Из строки запроса получаем type маршрута
 $Type = $_GET["Type"]; 
// В переменную $db занесем путь к базе данных
 $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
  // Создадим объект ADODB.Connection
 $conn = new COM('ADODB.Connection');
  // Подключимся к базе данных
$conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
  // Сформируем запрос к базе на выборку регионов нужной страны
 $sql1 = "SELECT * FROM Route WHERE [Type]='".$Type."'";
 //echo $sql1;
  // Выполняем запрос к базе, rs1 – набор данных для нужных регионов
 $rs1 = $conn->Execute($sql1);
 // Проходим в цикле по всем регионам
 while (!$rs1->EOF) { 
        // Формируем список маршрутов
    echo '<option value="'.$rs1->Fields['Route_ID']->Value.'">'.
       $rs1->Fields['Comment']->Value.'</option>';
        // Переходим к следующей строке
     $rs1->MoveNext(); } // for 
 // Формируем завершающую строку
 echo '</select>'; ?>
