var currentPge = 0;
var pageSize = 1;
var allData;
var isFirstTime = true;
var TableContainerName = 'TableContainer';
function DataTable(thName, Data) {
    if (Data != null) {
        allData = Data;
    }
    var dataKeys = Object.keys(allData);
    var i;
    if (isFirstTime) { //_____ firstTime create Tabel and Head
        var table = document.createElement('table');
        table.setAttribute('id', 'DataTabel');
        table.setAttribute('class', 'table table-hover table-striped table-bordered text-center');
        table.style.direction = 'rtl';
        var tHead = document.createElement('thead');
        var trHead = document.createElement('tr');
        var th = '';

        //_____set HeadName
        for (i = 0; i < thName.length; i++) {
            th = document.createElement('th');
            th.setAttribute('class' , 'text-center');
            th.innerText = thName[i];
            trHead.appendChild(th);
        }
        //_____ appendHead
        tHead.appendChild(trHead);
        table.appendChild(tHead);
    } else {
        //_____ remove last table Body
        var LastTbody = document.getElementById('TBODY');
        LastTbody.parentNode.removeChild(LastTbody);
    }
    //______ Create Data Table
    var tBody = document.createElement('tbody');
    tBody.setAttribute('id', 'TBODY');
    var tr, td, trDataKeys, trData, btnDelete, btnEdit;
    var firstIndex = (currentPge * pageSize);
    for (i = firstIndex; i < firstIndex + pageSize; i++) {
        try {
            trData = allData[dataKeys[i]];
            trDataKeys = Object.keys(trData);
            tr = document.createElement('tr');

            for (var a = 0; a <= trDataKeys.length; a++) {
                td = document.createElement('td');
                if (a == trDataKeys.length) {
                    btnDelete = document.createElement('div');
                    btnEdit = document.createElement('div');
                    btnDelete.setAttribute('class', 'btn btn-danger tableBtn');
                    btnEdit.setAttribute('class', 'btn btn-primary tableBtn');
                    btnEdit.setAttribute('onclick', 'Edit(' + allData[i].id + ')');
                    btnDelete.setAttribute('onclick', 'delete(' + allData[i].id + ')');
                    btnDelete.innerText = 'حذف';
                    btnEdit.innerText = 'ویرایش';
                    td.appendChild(btnDelete);
                    td.appendChild(btnEdit);
                } else {
                    td.innerText = trData[trDataKeys[a]];
                }
                tr.appendChild(td);
            }
            tBody.appendChild(tr);
        }catch (err){}
    }
    if (isFirstTime) {
        //___ first Time
        table.appendChild(tBody);
        document.getElementById(TableContainerName).appendChild(table);
        isFirstTime = false;
    } else {
        document.getElementById('DataTabel').appendChild(tBody);
    }
}
function createTableBtn() {
    var btn;
    var btnDivider = document.createElement('div');
    btnDivider.setAttribute('class', 'btnDivider');
    btnDivider.style.direction = 'rtl';
    var btnNumber = allData.length / pageSize;
    if (!Number.isInteger(btnNumber)) {
        btnNumber = parseInt(btnNumber) + 1;
    }
    for (var i = 0; i < btnNumber; i++) {
        btn = document.createElement('span');
        btn.setAttribute('class', 'btn btn-info btnPage');
        btn.setAttribute('onclick', 'goToPage(' + i + ')');
        btn.innerText = i + 1;
        btnDivider.appendChild(btn);
    }
    document.getElementById(TableContainerName).appendChild(btnDivider);
}


function goToPage(pageNumb) {
    currentPge = pageNumb;
    DataTable(null, null);
}
function SetDataGrid(thName, Data) {
    DataTable(thName, Data);
    createTableBtn();
}