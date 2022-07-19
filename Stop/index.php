<?php
header('Content-Type: text/html; charset=windows-1251');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="Windows-1251">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>��������� ������ ���������</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
    $conn = new COM('ADODB.Connection');
    $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
    $sql = 'SELECT * FROM Stop';
    $rs = $conn->Execute($sql); ?>
    <div class="container_fluid">
        <div class="table">
            <table border="1" id="table2">
                <tr>
                <th hidden>ID</th><th>���������</th>
                </tr>
                <?php for ($i=0; !$rs->EOF; $i++) { ?>
                <tr <?php echo 'onclick=TRClick('.$i.')'?> style="cursor: pointer;"><!--style="cursor: pointer;" ������ ������ ������ � �������-->
                <td hidden><?php echo $rs->Fields['Stop_ID']->Value ?></td>
                <td><?php echo $rs->Fields['Name']->Value ?></td></tr>
                <?php $rs->MoveNext() ?> <?php } ?>
            </table>
        </div>
        <div class="buttons">
            <input type="button" value="��������" onclick="InsertClick()"><br><br>
            <input type="button" value="��������" onclick="UpdateClick()"><br><br>
            <input type="submit" value="�������" onclick="DeleteClick()">
        </div>  
        <div class="operations">
            <form id="form1" method="POST" action="Stops.php" hidden>
                �������� ���������:<br>
                <input type="text" name="NStop"  id="IStop"><br><br>
                <input type="submit" value="   OK   " ID="IOK">
                <input type="button" value= "������ " onclick="CancelClick()"><br>
                <input type="text" name="NID" id="IID" hidden>
                <input type="text" name="NOper" id="IOper" hidden>
            </form>
        </div>      
    </div> <!--container_fluid-->
    <div class="container_fluid">
        <br>��������<br>
        <table border="1" id="table3"></table>
        <div class="buttons">
            <input type="button" value="��������" onclick="InsertClick2()"><br><br>
            <input type="button" value="��������" onclick="UpdateClick2()"><br><br>
            <input type="submit" value="�������" onclick="DeleteClick2()">
        </div>
        <div class="operations">
            <form id="form2" method="POST" action="Route.php" hidden>
                ���<br>
                <select name="NType" id="IType" onchange="ChangeType()"><!-- style="opacity: 0.5;" -->
                <option>�������</option>
                <option>����������</option>
                <option>�������</option>
                </select><br><br>
                <p>�������<br>
                <div id="DivRoute">
                    <select name="NRoute" id="IRoute">
                    <? //$sql2 = 'select * from Route';
                    //$sql3 = 'select StopInRoute.Route_ID, Route.Comment from (StopInRoute inner join Route on StopInRoute.Route_ID = Route.Route_ID) where StopInRoute.Stop_ID='. $Stop_ID;
                    $sql3 = "select * from Route where Type = '�������'";
                    $rs2 = $conn->Execute($sql3);
                    for ($i=0; !$rs2->EOF; $i++) {
                        echo '<option value='.$rs2->Fields['Route_ID']->Value.'>'.
                            $rs2->Fields['Comment']->Value.'</option>'; 
                        $rs2->MoveNext();
                    } // for ?>
                    </select>
                </div></p>
                <p>����� ���������<br>
                <input type="text" name="NNumbStop" id="INumbStop"></p>
                <p><input type="submit" value="   OK   " id="IOK2">          
                <input type="button" value= "������ " onclick="CancelClick2()"></p>
                <div hidden><input type="text" name="NStopID" id="IStopID"><!-- ID ��������� hiddenstyle="opacity: 0.5;" -->
                <input type="text" name="NOldRouteID" id="IOldRouteID">
                <input type="text" name="NOldStopNumb" id="IOldStopNumb"><!-- ����� ���������  -->
                <input type="text" name="NOper" id="IOper2"></div>
            </form>
        </div>
    </div>
    <script>
        var CurRow = 0;
        // �������� �������
        var CurRow2 = 0; // ������� ������ ������� �������� ����� ���������
        SelectRouteInStop(1); // ������� ���������� ������� �������� ����� ���������
        var T3 = document.getElementById("table3");
        // ����� ������������ �������
        var T2 = document.getElementById("table2");
        var CurTR = T2.rows[1];
        CurTR.style.backgroundColor="lightgreen";
        function TRClick(i) {
            CurTR = T2.rows[CurRow+1];
            CurTR.style.backgroundColor="#ffffff";
            CurRow = i;	
            CurTR = T2.rows[CurRow+1];
            CurTR.style.backgroundColor="lightgreen";
            // ��������� ������� ������������� ������� �������� ����� ���������
            CurRow2 = CurTR.cells[0].innerHTML;
            SelectRouteInStop(CurRow2); 
        } // end of TRClick
        function InsertClick()  {
            var F1 = document.getElementById("form1");
            F1.hidden = false;
            var Oper = document.getElementById("IOper");
            Oper.value = 1;
        } // End of InsertClick
        function CancelClick() {
            var F1 = document.getElementById("form1");
            F1.hidden = true;
            var IOK = document.getElementById("IOK");
            IOK.value = "   ��   ";
        } // End of CancelClick
        function UpdateClick() {
            var F1 = document.getElementById("form1");
            F1.hidden = false;
            T2 = document.getElementById("table2");
            CurTR = T2.rows[CurRow+1];
            var td0 = CurTR.cells[0];
            var ID = td0.innerHTML;
            var td1 = CurTR.cells[1];
            var Stop = td1.innerHTML;

            var INumber = document.getElementById("IStop");
            INumber.value = Stop; 			
            
            var IID = document.getElementById("IID");
            IID.value = ID; 			
            var IOK = document.getElementById("IOK");
            IOK.value = "   ��   ";
            var Oper = document.getElementById("IOper");
            Oper.value = 2;
        } // UpdateClick
        function DeleteClick() {
            UpdateClick();
            var IOK = document.getElementById("IOK");
            IOK.value = "����������� ��������";
            var Oper = document.getElementById("IOper");
            Oper.value = 3;
        } // End of 
        // ��������� ������� SelectStopInRoute, ReceiveRequest, TRClick2,
        // PreEdit, InsertClick2, CancelClick2, UpdateClick2, DeleteClick2,
        // CreateAJAX
        // ������� SelectRouteInStop(Stop_ID) ������� � �������� AJAX-������ 
        // � ������� �� ��������� ��������� ����� ���������
        function SelectRouteInStop(Stop_ID) {
            xmlHttp=CreateAJAX();
            xmlHttp.onreadystatechange = ReceiveRequest;
            p = "RouteInStop.php?Stop_ID="+Stop_ID;
            //alert(p);
            xmlHttp.open("GET", p, true);
            xmlHttp.send(null);
        } // End of SelectStopInRoute
        // ������� ReceiveRequest() �������� ����� �� ������� � ����������
        // ���������� ������� � table3
        function ReceiveRequest() {
            var TextDoc=null;
            if (xmlHttp.readyState == 4) {
                if (xmlHttp.status == 200) {
                    TextDoc=xmlHttp.responseText;
                document.getElementById("table3").innerHTML = TextDoc;
                    //CurTR2 = 0; 
                    TRClick2(0);	     
                } else {
                } // else
            } //if 
        } // ReceiveRequest
        // ������� TRClick2 �������� ������� ������
        function TRClick2(i) {
            if (T3.rows.length > 1) {
            CurTR2 = T3.rows[Number(CurRow2)+1];
            CurTR2.style.backgroundColor="#ffffff";
            CurRow2 = i;	
            CurTR2 = T3.rows[Number(CurRow2)+1];
            CurTR2.style.backgroundColor="lightgreen";;
            } // if
        } // end of TRClick
        // ������� PreEdit �������������� ����� form2 � ����������
        function PreEdit() {
            var F2 = document.getElementById("form2");
            F2.hidden = false;
            var T2 = document.getElementById("table2");
            var T3 = document.getElementById("table3");
            var CurTR  = T2.rows[CurRow +1];
            var CurTR2 = T3.rows[CurRow2+1];
            var td0 = CurTR.cells[0];
            var Stop_ID = td0.innerHTML;
            var IStopID = document.getElementById("IStopID");
            IStopID.value = Stop_ID;
        } // End of PreEdit
        // ������� InsertClick2 �������������� ����� form2 � ����������
        // �������� ����� ���������
        function InsertClick2()  {
            PreEdit();
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 1;
            var IOK2 = document.getElementById("IOK2");
            IOK2.value = "��������";
        } // End of InsertClick
        // ������� CancelClick2 �������� ���������� ����� form2 
        function CancelClick2() {
            var F2 = document.getElementById("form2");
            F2.hidden = true;
            var IOK2 = document.getElementById("IOK2");
            IOK2.value = "   ��   ";
        } // End of CancelClick
        // ������� UpdateClick2 �������������� ����� form2 � ���������
        // �������� ����� ���������
        function UpdateClick2() {
            PreEdit();
            var F2 = document.getElementById("form2");
            F2.hidden = false;
            T3 = document.getElementById("table3");
            CurTR2 = T3.rows[CurRow2+1];
            var td02 = CurTR2.cells[0];
            var Route_ID = td02.innerHTML;

            var td12 = CurTR2.cells[1];
            var type = td12.innerHTML;
            var IType = document.getElementById("IType");
            if (type === "�������") IType.selectedIndex = 0;
            else if (type === "����������") IType.selectedIndex = 1;
            else if (type === "�������") IType.selectedIndex = 2;

            var td13 = CurTR2.cells[4]; // ����� ���������
            var StopNumb = td13.innerHTML;

            var IRoute = document.getElementById("IRoute");
            var RouteCount = IRoute.length;
            for (i=0; i<RouteCount; i++) {
                if (IRoute.options[i].value == Route_ID) IRoute.selectedIndex = i;
            } // for

            var IOldRouteID = document.getElementById("IOldRouteID"); // ID ��������
            IOldRouteID.value = Route_ID;        
            var IOldStopNumb = document.getElementById("IOldStopNumb"); // ������ ����� ��������� �� ��������
            IOldStopNumb.value = StopNumb;
            var newNumbstop = document.getElementById("INumbStop"); // ����� ����� ��������� �� ��������
            newNumbstop.value = StopNumb;// ��������� ���� ��� ���������, �� ��� ��������
            var IOK = document.getElementById("IOK");
            IOK2.value = "����������� ����������";
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 2;
        } // UpdateClick
        // ������� InsertClick2 �������������� ����� form2 � ��������
        // �������� ����� ���������
        function DeleteClick2() {
            UpdateClick2();
            var IOK2 = document.getElementById("IOK2");
            IOK2.value = "����������� ��������";
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 3;
        }  // End of DeleteClick2
        function ChangeType(){
            // ��������� ����� ��������� ������ � ������ �����
            //var Type_number = document.form2.IType.selectedIndex;
            // ��������� Type ��������, ��������� � ������ ������
            // alert(document.getElementById("IType").value);
            var Type = document.getElementById("IType").value;
            // �������������� AJAX
            xmlHttp=CreateAJAX();
            // ��������� ������� ReceiveRequest, ������� ����� �������� �������
            xmlHttp.onreadystatechange=ReceiveRequest2;
            // ���������� ������ � �������� �� ������
            p = "UpdateComboBox.php?Type="+Type;
            xmlHttp.open("GET", p, true);
            // �������� ������ �� ������
            xmlHttp.send(null); 
        }
        //���������� ������� ReceiveRequest, ������� ����� �������� ������� � ������ ������ �������.
        function ReceiveRequest2() {
            // � ���������� TextDoc ����� ���������� ����� �� �������, ���� �� ��������
            var TextDoc = null;
            // ������ ������� ���������� ����� ���, ��� ���������� �����, ����� 
            // xmlHttp.readyState = 4
            if (xmlHttp.readyState == 4) {
                // ��� ���� xmlHttp.status ������ ���� 200
                if (xmlHttp.status == 200) {
                    // ������ �����, �� � xmlHttp.responseText, ������� ��� � TextDoc
                    TextDoc=xmlHttp.responseText;
                    // ���������� ����� ������� � DivRegion � �������� innerHTML
                    document.getElementById("DivRoute").innerHTML = TextDoc;
                } 
                else {
                    // ���� xmlHttp.status �� 200, �� ������
                    if (xmlHttp.status == 404) {
                        alert("������������� URL �� ����������");
                    } else {
                        alert("Error: status code is " + xmlHttp.status);	
                    } // else
                } // else
            } //if 
        } // End of ReceiveRequest

        function CreateAJAX() {
            var xmlHttp;
            try {
            xmlHttp=new XMLHttpRequest();
            } catch(e) {
            try {
                xmlHttp=new ActiveXObject("MSXML2.XMLHTTP");
            } catch(e) {
                try {
                    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                } catch(e) {
                } // catch
            } // catch
            } // catch
            if (!xmlHttp) {
            alert("�� ������� ������� ������ XMLHttpRequest");
            } // if
            return xmlHttp;
        } // CreateAJAX
        
        
</script>
</body>
</html>