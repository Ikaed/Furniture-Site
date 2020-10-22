$(document).ready(function () {
    getFurniture();
});
//Hämtar alla sk kommentrarer

var cssId = 'myCss';
if (!document.getElementById(cssId))
{
    var head  = document.getElementsByTagName('head')[0];
    var link  = document.createElement('link');
    link.id   = cssId;
    link.rel  = 'stylesheet';
    link.type = 'text/css';
    link.href = 'stylesheet.css';
    link.media = 'all';
    head.appendChild(link);
}

function getAllComments() {
    $.getJSON("./index1.php?AdminController2/getAllComments/", function (jsondata) {
        console.log("jsondata: ", jsondata);

        showJSONDataInModal(jsondata);
    });
}

function getAllCommentsByID(ID) {
    $.getJSON("./index1.php?AdminController2/getAllCommentsByID/" + ID, function (jsondata) {
        console.log("jsondata: ", jsondata);

        showJSONDataInModal(jsondata);
    });
}
//Hämtar alla möbler
function getFurniture() {
    $.getJSON("./index1.php?AdminController2/getFurniture/", function (jsondata) {
        console.log("jsondata: ", jsondata);

        showJSONDataInTable(jsondata);
    });
}

function getSortBy() {
    $.getJSON("./index1.php?AdminController2/getSortBy/", function (jsonSorted) {
        console.log("jsondata: ", jsonSorted);

        showJSONDataInTable(jsonSorted);
    });
}


function showJSONDataInTable(json) {
    let table = $('#tbl');
    table.empty();
    let tr = $("<tr></tr>");
    let thNamn = $("<th></th>");
    let thInfo = $("<th></th>");
    let thBild = $("<th></th>");

    thNamn.text("Möbelnamn");
    thInfo.text("Produktinformation");
    tr.append(thNamn);
    tr.append(thInfo);
    tr.append(thBild);
    table.append(tr);
    $.each(json, function (index, element) {
        let tr = $("<tr></tr>");
        let tdNamn = $("<td></td>");
        let tdInfo = $("<td></td>");
        let tdBild = $("<td></td>");
        let tdComm = $("<td></td>");
      
        let tdUpdate = $("<td></td>");
          let tdComment = $("<td></td>");
        tdNamn.text(element.namn);
        tdInfo.text(element.info);
        tdBild.html("<img id='bild' alt='' tabindex='0' src='" + element.bild + "'>");
       tdComm.on("click", function () {
            getCommByID(element.mobelID);
        });
        tdUpdate.on("click", function () {
            getUpdateByID(element.mobelID);

        });
         tdComment.on("click", function () {
            getAllCommentsByID(element.mobelID);

        });
        tdComm.html("<button class='btn btn-link' title='Sign'>Kommentera produkten här »</button>");
        tdUpdate.html("<button class='btn btn-link' title='Edit'>Uppdatera</button>");
         tdComment.html("<button class='btn btn-link' title='Edit'>Läs kommentarer</button>");

        tr.append(tdNamn);
        tr.append(tdInfo);
        tr.append(tdBild);
        tr.append(tdComm);
        tr.append(tdUpdate);
        tr.append(tdComment);

        table.append(tr);

    });

}

function addFurniture() {
    let name = $("#addModal #txtaddNamn").val();
    let inf = $("#addModal #txtaddInfo").val();
    let pic = $("#addModal #txtaddBild").val();

    $.post("./index1.php?AdminController2/addFurniture/", {
        namn: name,
        info: inf,
        bild: pic

    }, function (jsondata) {
        alert(jsondata.Svar);
        getFurniture();
        $("#addModal #txtaddNamn").val(''); //Tömmer textfälten
        $("#addModal #txtaddInfo").val('');
        $("#addModal #txtaddBild").val('');
          
        $('#addModal').modal('hide');
    });
}

function deleteFurniture() {
    let idx = $("#txtupdatemobelID").val();
    $.post("./index1.php?AdminController2/deleteFurniture/", {
        mobelID: idx
    }, function (jsondata) {
        alert(jsondata.Svar);
        getFurniture();
        $('#updateModal').modal('hide');
    });

}
function updateFurniture() {
    let idx = $("#txtupdatemobelID").val();
    let name = $("#txtupdatemobelNamn").val();
    let inf = $("#txtupdateInfo").val();
    $.post("./index1.php?AdminController2/updateFurniture/", {
        mobelID: idx,
        namn: name,
        info: inf
    }, function (jsondata) {
        alert(jsondata.Svar);

        getFurniture();
        $('#updateModal').modal('hide');
    });

}

function addComm() {
    let mnamn = $("#commOnModal #txtmobelNamn").val();
    let id = $("#commOnModal #txtmobelID").val();
    let name = $("#commOnModal #txtNamn").val();
    let comments = $("#commOnModal #txtKommentar").val();

    $.post("./index1.php?AdminController2/addComm/", {
        mobelNamn: mnamn,
        mobelID: id,
        namn: name,
        kommentar: comments

    }, function (jsondata) {
        alert(jsondata.Svar);
        $('#commOnModal #txtmobelNamn').val('');
        $("#commOnModal #txtmobelID").val(''); //Tömmer textfälten
        $("#commOnModal #txtNamn").val('');
        $("#commOnModal #txtKommentar").val('');

        $('#commOnModal').modal('hide');
    });
}

function getCommByID(ID) {
    $.getJSON("./index1.php?AdminController2/getCommByID/" + ID, function (jsondata) {
        showCommOnModal(jsondata);
    });
    console.log("");
}

function getUpdateByID(ID) {
    $.getJSON("./index1.php?AdminController2/getCommByID/" + ID, function (json) {

        showUpdateOnModal(json);
    });
    console.log("");
}


//Sätter data från json i textfältet och visar modalen
function showCommOnModal(jsondata) {
    let moname = $("#txtmobelNamn");
    let id = $("#txtmobelID");
    moname.val(jsondata[0]['namn']);
    id.val(jsondata[0]['mobelID']);
    $('#commOnModal').modal('show');
}

function showUpdateOnModal(json) {
    let moname = $("#txtupdatemobelNamn");
    let id = $("#txtupdatemobelID");
    let inf = $("#txtupdateInfo");
    moname.val(json[0]['namn']);
    console.log(id)

    id.val(json[0]['mobelID']);

    inf.val(json[0]['info']);
    $('#updateModal').modal('show');
}
//Texten i själva modalen för att visa data
function showJSONDataInModal(jsondata) {
    let table = $('#modalTable');
    table.empty();


    let tr = $("<tr></tr>");
    let thNamn = $("<th></th>");
    let thFurniture = $("<th></th>");
    let thComment = $("<th></th>");

    thFurniture.text("Möbelnamn");
    thNamn.text("Namn");
    thComment.text("Kommentar");

    tr.append(thFurniture);
    tr.append(thNamn);
    tr.append(thComment);

    table.append(tr);


    $.each(jsondata, function (index, element) {
        let tr = $("<tr></tr>");
        let tdFurniture = $("<td></td>");
        let tdNamn = $("<td></td>");
        let tdComment = $("<td></td>");

        tdFurniture.text(element.mobelNamn);
        tdNamn.text(element.namn);
        tdComment.text(element.kommentar);

        tr.append(tdFurniture);
        tr.append(tdNamn);
        tr.append(tdComment);

        table.append(tr);

    });

    $('#showCommentsModal').modal('show');
}