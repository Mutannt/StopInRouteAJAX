<?php
header('Content-Type: text/html; charset=windows-1251');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="Windows-1251">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Транспорт города Челябинск</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $db = 'Z:\home\localhost\www\zad4\Transport.mdb';
    $conn = new COM('ADODB.Connection');
    $conn->Open("Provider=Microsoft.Jet.OLEDB.4.0; Data Source=".$db); 
    $sql = 'SELECT * FROM Route';
    $rs = $conn->Execute($sql); ?>
    <div class="container_fluid">
        <div>
            <table border="1" id="table2">
                <tr>
                <th hidden>ID</th><th>Тип</th><th>Номер</th><th>Маршрут</th>
                </tr>
                <?php for ($i=0; !$rs->EOF; $i++) { ?>
                <tr <?php echo 'onclick=TRClick('.$i.')'?>> <!-- Добавляем событие Click на строчку-->
                <td hidden><?php echo $rs->Fields['Route_ID']->Value ?></td>
                <td><?php echo $rs->Fields['Type']->Value ?></td>
                <td><?php echo $rs->Fields['Number']->Value ?></td>
                <td><?php echo $rs->Fields['Comment']->Value ?></td></tr>
                <?php $rs->MoveNext() ?> <?php } ?>
            </table>
        </div>
        <div class="buttons">
            <input type="button" value="Добавить" onclick="InsertClick()"><br><br>
            <input type="button" value="Обновить" onclick="UpdateClick()"><br><br>
            <input type="submit" value="Удалить  " onclick="DeleteClick()"></td><td>
        </div>  
        <div class="operations">
            <form id="form1" method="POST" action="6.php" hidden>
                Тип<br>
                <select name="NType" id="IType">
                <option>Автобус</option>
                <option>Троллейбус</option>
                <option>Трамвай</option>
                </select><br><br>
                Номер<br>
                <input type="text" name="NNumber"  id="INumber"><br><br>
                Маршрут<br>
                <input type="text" name="NComment" id="IComment"><br><br>
                <input type="submit" value="   OK   " ID="IOK">
                <input type="button" value= "Отмена " onclick="CancelClick()"><br>
                <input type="text" name="NID" id="IID" hidden>
                <input type="text" name="NOper" id="IOper" hidden>
            </form>
        </div>      
    </div> <!--container_fluid-->
    <div class="container_fluid">
        <br>Остановки<br>
        <table border="1" id="table3"></table>
        <div class="buttons">
            <input type="button" value="Добавить" onclick="InsertClick2()">
            <input type="button" value="Изменить" onclick="UpdateClick2()">
            <input type="submit" value="Удалить  " onclick="DeleteClick2()">
        </div>
        <form id="form2" method="POST" action="7.php" hidden>
            <p>Остановка<br>
            <select name="NStop" id="IStop">
            <? $sql2 = 'select * from stop';
            $rs2 = $conn->Execute($sql2);
            for ($i=0; !$rs2->EOF; $i++) {
                echo '<option value='.$rs2->Fields['Stop_ID']->Value.'>'.
                    $rs2->Fields['Name']->Value.'</option>'; 
                $rs2->MoveNext();
            } // for ?>
            </select></p>
            <p>Номер на маршруте<br>
            <input type="text" name="NStopNumb" id="IStopNumb"></p>
            <p><input type="submit" value="   OK   " id="IOK2">          
            <input type="button" value= "Отмена " onclick="CancelClick2()"></p>
            <div hidden><input type="text" name="NRouteID" id="IRouteID">
            <input type="text" name="NOldStopID" id="IOldStopID">
            <input type="text" name="NOldStopNumb" id="IOldStopNumb">
            <input type="text" name="NOper" id="IOper2"></div>
        </form>
    </div>
    <script>
        var CurRow = 0;
        // Добавлен участок
        var CurRow2 = 0; // Текущая строка таблицы остановки на маршруте
        SelectStopInRoute(1); // Функция сформирует таблицу остановки на маршруте
        var T3 = document.getElementById("table3");
        // Конец добавленного участка
        var T2 = document.getElementById("table2");
        var CurTR = T2.rows[1];
        CurTR.style.backgroundColor="#ff00ff";
        function TRClick(i) { // Функция при клике на строчку таблицы2
            CurTR = T2.rows[CurRow+1];
            CurTR.style.backgroundColor="#ffffff";
            CurRow = i;	
            CurTR = T2.rows[CurRow+1];
            CurTR.style.backgroundColor="#ff00ff";
            // Добавлена строчка сформирования таблицы остановки на маршруте
            CurRow2 = CurTR.cells[0].innerHTML;
            SelectStopInRoute(CurRow2); 
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
            IOK.value = "   ОК   ";
        } // End of CancelClick
        function UpdateClick() {
            var F1 = document.getElementById("form1");
            F1.hidden = false;
            T2 = document.getElementById("table2");
            CurTR = T2.rows[CurRow+1];
            var td0 = CurTR.cells[0];
            var ID = td0.innerHTML;
            var td1 = CurTR.cells[1];
            var Type = td1.innerHTML;
            var td2 = CurTR.cells[2];
            var Number = td2.innerHTML;
            var td3 = CurTR.cells[3];
            var Comment = td3.innerHTML;
            var IType = document.getElementById("IType");
            if (Type == "Автобус") IType.selectedIndex = 0;
            if (Type == "Троллейбус") IType.selectedIndex = 1;
            if (Type == "Трамвай") IType.selectedIndex = 2;
            var INumber = document.getElementById("INumber");
            INumber.value = Number; 			
            var IComment = document.getElementById("IComment");
            IComment.value = Comment; 			
            var IID = document.getElementById("IID");
            IID.value = ID; 			
            var IOK = document.getElementById("IOK");
            IOK.value = "   ОК   ";
            var Oper = document.getElementById("IOper");
            Oper.value = 2;
        } // UpdateClick
        function DeleteClick() {
            UpdateClick();
            var IOK = document.getElementById("IOK");
            IOK.value = "Подтвердите удаление";
            var Oper = document.getElementById("IOper");
            Oper.value = 3;
        } // End of 
        // Добавлены функции SelectStopInRoute, ReceiveRequest, TRClick2,
        // PreEdit, InsertClick2, CancelClick2, UpdateClick2, DeleteClick2,
        // CreateAJAX
        // Функция SelectStopInRoute(Route_ID) создает и посылает AJAX-запрос 
        // к серверу на получение остановок на маршруте Route_ID
        function SelectStopInRoute(Route_ID) {
            xmlHttp=CreateAJAX();
            xmlHttp.onreadystatechange = ReceiveRequest;
            p = "5.php?Route_ID="+Route_ID;
            //alert(p);
            xmlHttp.open("GET", p, true);
            xmlHttp.send(null);
        } // End of SelectStopInRoute
        // Функция ReceiveRequest() получает ответ от сервера и подключает
        // полученную таблицу к table3
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
        // Функция TRClick2 выделяет текущую строку
        function TRClick2(i) {
            if (T3.rows.length > 1) {
            CurTR2 = T3.rows[Number(CurRow2)+1];
            CurTR2.style.backgroundColor="#ffffff";
            CurRow2 = i;	
            CurTR2 = T3.rows[Number(CurRow2)+1];
            CurTR2.style.backgroundColor="#ff00ff";
            } // if
        } // end of TRClick
        // Функция PreEdit подготавливает форму form2 к заполнению
        function PreEdit() {
            var F2 = document.getElementById("form2");
            F2.hidden = false;
            var T2 = document.getElementById("table2");
            var T3 = document.getElementById("table3");
            var CurTR  = T2.rows[CurRow +1];
            var CurTR2 = T3.rows[CurRow2+1];
            var td0 = CurTR.cells[0];
            var Route_ID = td0.innerHTML;
            var IRouteID = document.getElementById("IRouteID");
            IRouteID.value = Route_ID;
        } // End of PreEdit
        // Функция InsertClick2 подготавливает форму form2 к добавлению
        // остановки на маршруте
        function InsertClick2()  {
            PreEdit();
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 1;
        } // End of InsertClick
        // Функция CancelClick2 отменяет заполнение формы form2 
        function CancelClick2() {
            var F2 = document.getElementById("form2");
            F2.hidden = true;
            var IOK2 = document.getElementById("IOK2");
            IOK2.value = "   ОК   ";
        } // End of CancelClick
        // Функция UpdateClick2 подготавливает форму form2 к изменению
        // остановки на маршруте
        function UpdateClick2() {
            PreEdit();
            T3 = document.getElementById("table3");
            CurTR2 = T3.rows[CurRow2+1];
            var td02 = CurTR2.cells[0];
            var Stop_ID = td02.innerHTML;
            var td12 = CurTR2.cells[1];
            var StopNumb = td12.innerHTML;
            var td22 = CurTR2.cells[2];
            var Name = td22.innerHTML;
            var td3 = CurTR.cells[3];
            var Comment = td3.innerHTML;
            var IStop = document.getElementById("IStop");
            var StopCount = IStop.length;
            for (i=0; i<StopCount; i++) {
            if (IStop.options[i].value == Stop_ID) IStop.selectedIndex = i;
            } // for
            var IStopNumb = document.getElementById("IStopNumb");
            IStopNumb.value = StopNumb; 			
            var IOldStopID = document.getElementById("IOldStopID");
            IOldStopID.value = Stop_ID; 			
            var IOldStopNumb = document.getElementById("IOldStopNumb");
            IOldStopNumb.value = StopNumb; 			
            var IOK = document.getElementById("IOK");
            IOK2.value = "   ОК   ";
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 2;
        } // UpdateClick
        // Функция InsertClick2 подготавливает форму form2 к удалению
        // остановки на маршруте
        function DeleteClick2() {
            UpdateClick2();
            var IOK2 = document.getElementById("IOK2");
            IOK2.value = "Подтвердите удаление";
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 3;
        }  // End of DeleteClick2
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
            alert("Не удалось создать объект XMLHttpRequest");
            } // if
            return xmlHttp;
        } // CreateAJAX
</script>
</body>
</html>