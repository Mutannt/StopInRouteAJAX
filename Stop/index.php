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
    $sql = 'SELECT * FROM Stop';
    $rs = $conn->Execute($sql); ?>
    <div class="container_fluid">
        <div class="table">
            <table border="1" id="table2">
                <tr>
                <th hidden>ID</th><th>Остановки</th>
                </tr>
                <?php for ($i=0; !$rs->EOF; $i++) { ?>
                <tr <?php echo 'onclick=TRClick('.$i.')'?> style="cursor: pointer;"><!--style="cursor: pointer;" Менять курсор только в ячейках-->
                <td hidden><?php echo $rs->Fields['Stop_ID']->Value ?></td>
                <td><?php echo $rs->Fields['Name']->Value ?></td></tr>
                <?php $rs->MoveNext() ?> <?php } ?>
            </table>
        </div>
        <div class="buttons">
            <input type="button" value="Добавить" onclick="InsertClick()"><br><br>
            <input type="button" value="Обновить" onclick="UpdateClick()"><br><br>
            <input type="submit" value="Удалить" onclick="DeleteClick()">
        </div>  
        <div class="operations">
            <form id="form1" method="POST" action="Stops.php" hidden>
                Название остановки:<br>
                <input type="text" name="NStop"  id="IStop"><br><br>
                <input type="submit" value="   OK   " ID="IOK">
                <input type="button" value= "Отмена " onclick="CancelClick()"><br>
                <input type="text" name="NID" id="IID" hidden>
                <input type="text" name="NOper" id="IOper" hidden>
            </form>
        </div>      
    </div> <!--container_fluid-->
    <div class="container_fluid">
        <br>Маршруты<br>
        <table border="1" id="table3"></table>
        <div class="buttons">
            <input type="button" value="Добавить" onclick="InsertClick2()"><br><br>
            <input type="button" value="Изменить" onclick="UpdateClick2()"><br><br>
            <input type="submit" value="Удалить" onclick="DeleteClick2()">
        </div>
        <div class="operations">
            <form id="form2" method="POST" action="Route.php" hidden>
                Тип<br>
                <select name="NType" id="IType" onchange="ChangeType()"><!-- style="opacity: 0.5;" -->
                <option>Автобус</option>
                <option>Троллейбус</option>
                <option>Трамвай</option>
                </select><br><br>
                <p>Маршрут<br>
                <div id="DivRoute">
                    <select name="NRoute" id="IRoute">
                    <? //$sql2 = 'select * from Route';
                    //$sql3 = 'select StopInRoute.Route_ID, Route.Comment from (StopInRoute inner join Route on StopInRoute.Route_ID = Route.Route_ID) where StopInRoute.Stop_ID='. $Stop_ID;
                    $sql3 = "select * from Route where Type = 'Автобус'";
                    $rs2 = $conn->Execute($sql3);
                    for ($i=0; !$rs2->EOF; $i++) {
                        echo '<option value='.$rs2->Fields['Route_ID']->Value.'>'.
                            $rs2->Fields['Comment']->Value.'</option>'; 
                        $rs2->MoveNext();
                    } // for ?>
                    </select>
                </div></p>
                <p>Номер остановки<br>
                <input type="text" name="NNumbStop" id="INumbStop"></p>
                <p><input type="submit" value="   OK   " id="IOK2">          
                <input type="button" value= "Отмена " onclick="CancelClick2()"></p>
                <div hidden><input type="text" name="NStopID" id="IStopID"><!-- ID остановка hiddenstyle="opacity: 0.5;" -->
                <input type="text" name="NOldRouteID" id="IOldRouteID">
                <input type="text" name="NOldStopNumb" id="IOldStopNumb"><!-- Номер остановки  -->
                <input type="text" name="NOper" id="IOper2"></div>
            </form>
        </div>
    </div>
    <script>
        var CurRow = 0;
        // Добавлен участок
        var CurRow2 = 0; // Текущая строка таблицы маршруты через остановку
        SelectRouteInStop(1); // Функция сформирует таблицу Маршруты через остановку
        var T3 = document.getElementById("table3");
        // Конец добавленного участка
        var T2 = document.getElementById("table2");
        var CurTR = T2.rows[1];
        CurTR.style.backgroundColor="lightgreen";
        function TRClick(i) {
            CurTR = T2.rows[CurRow+1];
            CurTR.style.backgroundColor="#ffffff";
            CurRow = i;	
            CurTR = T2.rows[CurRow+1];
            CurTR.style.backgroundColor="lightgreen";
            // Добавлена строчка сформирования таблицы Маршруты через остановку
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
            var Stop = td1.innerHTML;

            var INumber = document.getElementById("IStop");
            INumber.value = Stop; 			
            
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
        // Функция SelectRouteInStop(Stop_ID) создает и посылает AJAX-запрос 
        // к серверу на получение маршрутов через остановку
        function SelectRouteInStop(Stop_ID) {
            xmlHttp=CreateAJAX();
            xmlHttp.onreadystatechange = ReceiveRequest;
            p = "RouteInStop.php?Stop_ID="+Stop_ID;
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
            CurTR2.style.backgroundColor="lightgreen";;
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
            var Stop_ID = td0.innerHTML;
            var IStopID = document.getElementById("IStopID");
            IStopID.value = Stop_ID;
        } // End of PreEdit
        // Функция InsertClick2 подготавливает форму form2 к добавлению
        // маршрута через остановку
        function InsertClick2()  {
            PreEdit();
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 1;
            var IOK2 = document.getElementById("IOK2");
            IOK2.value = "Добавить";
        } // End of InsertClick
        // Функция CancelClick2 отменяет заполнение формы form2 
        function CancelClick2() {
            var F2 = document.getElementById("form2");
            F2.hidden = true;
            var IOK2 = document.getElementById("IOK2");
            IOK2.value = "   ОК   ";
        } // End of CancelClick
        // Функция UpdateClick2 подготавливает форму form2 к изменению
        // маршрута через остановку
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
            if (type === "Автобус") IType.selectedIndex = 0;
            else if (type === "Троллейбус") IType.selectedIndex = 1;
            else if (type === "Трамвай") IType.selectedIndex = 2;

            var td13 = CurTR2.cells[4]; // Номер остановки
            var StopNumb = td13.innerHTML;

            var IRoute = document.getElementById("IRoute");
            var RouteCount = IRoute.length;
            for (i=0; i<RouteCount; i++) {
                if (IRoute.options[i].value == Route_ID) IRoute.selectedIndex = i;
            } // for

            var IOldRouteID = document.getElementById("IOldRouteID"); // ID маршрута
            IOldRouteID.value = Route_ID;        
            var IOldStopNumb = document.getElementById("IOldStopNumb"); // Старый номер остановки на маршруте
            IOldStopNumb.value = StopNumb;
            var newNumbstop = document.getElementById("INumbStop"); // Новый номер остановки на маршруте
            newNumbstop.value = StopNumb;// Заполнить поле для изменения, не для отправки
            var IOK = document.getElementById("IOK");
            IOK2.value = "Подтвердите обновление";
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 2;
        } // UpdateClick
        // Функция InsertClick2 подготавливает форму form2 к удалению
        // маршрута через остановку
        function DeleteClick2() {
            UpdateClick2();
            var IOK2 = document.getElementById("IOK2");
            IOK2.value = "Подтвердите удаление";
            var Oper2 = document.getElementById("IOper2");
            Oper2.value = 3;
        }  // End of DeleteClick2
        function ChangeType(){
            // Определим номер выбранной строки в списке стран
            //var Type_number = document.form2.IType.selectedIndex;
            // Определим Type маршрута, выбранной в первом списке
            // alert(document.getElementById("IType").value);
            var Type = document.getElementById("IType").value;
            // Инициализируем AJAX
            xmlHttp=CreateAJAX();
            // Подключим функцию ReceiveRequest, которая будет изменять регионы
            xmlHttp.onreadystatechange=ReceiveRequest2;
            // подготовим запрос к отправке на сервер
            p = "UpdateComboBox.php?Type="+Type;
            xmlHttp.open("GET", p, true);
            // отправим запрос на сервер
            xmlHttp.send(null); 
        }
        //Рассмотрим функцию ReceiveRequest, которая будет изменять регионы в нужный момент времени.
        function ReceiveRequest2() {
            // В переменной TextDoc будет полученный текст от сервера, пока не получено
            var TextDoc = null;
            // Данная функция вызавается много раз, нас интересует вызов, когда 
            // xmlHttp.readyState = 4
            if (xmlHttp.readyState == 4) {
                // При этом xmlHttp.status должен быть 200
                if (xmlHttp.status == 200) {
                    // Пришел ответ, он в xmlHttp.responseText, запишем его в TextDoc
                    TextDoc=xmlHttp.responseText;
                    // Полученный ответ заносим в DivRegion в качестве innerHTML
                    document.getElementById("DivRoute").innerHTML = TextDoc;
                } 
                else {
                    // Если xmlHttp.status не 200, то ошибка
                    if (xmlHttp.status == 404) {
                        alert("Запрашиваемый URL не существует");
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
            alert("Не удалось создать объект XMLHttpRequest");
            } // if
            return xmlHttp;
        } // CreateAJAX
        
        
</script>
</body>
</html>