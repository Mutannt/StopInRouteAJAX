<?php 
// ��������� ��������� windows-1251
 header('Content-Type: text/html; charset=windows-1251');
  // ��������� ������ ������
 echo '<select id="IRoute">';
 // �� ������ ������� �������� type ��������
 $Type = $_GET["Type"]; 
// � ���������� $db ������� ���� � ���� ������
 $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
  // �������� ������ ADODB.Connection
 $conn = new COM('ADODB.Connection');
  // ����������� � ���� ������
$conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
  // ���������� ������ � ���� �� ������� �������� ������ ������
 $sql1 = "SELECT * FROM Route WHERE [Type]='".$Type."'";
 //echo $sql1;
  // ��������� ������ � ����, rs1 � ����� ������ ��� ������ ��������
 $rs1 = $conn->Execute($sql1);
 // �������� � ����� �� ���� ��������
 while (!$rs1->EOF) { 
        // ��������� ������ ���������
    echo '<option value="'.$rs1->Fields['Route_ID']->Value.'">'.
       $rs1->Fields['Comment']->Value.'</option>';
        // ��������� � ��������� ������
     $rs1->MoveNext(); } // for 
 // ��������� ����������� ������
 echo '</select>'; ?>
