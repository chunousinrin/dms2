/*　Datapicker　--------------------------------------------------------*/
$(".datepicker").datepicker({
    dateformat: "yy-mm-dd",
    showButtonPanel: true,
    changeYear: true,
    changeMonth: true,
});

$.datepicker._gotoToday = function (id) {
    var target = $(id);
    var inst = this._getInst(target[0]);
    var date = new Date();
    this._setDate(inst, date);
    this._hideDatepicker();
};

/*　Sortable　----------------------------------------------------------*/
$("#items").sortable({
    update: function (event, ui) {
        var moji = "InputItems";
        var tmp = document.getElementsByClassName("lists");
        for (var i = 0; i < tmp.length - 1; i++) {
            tmp[i].setAttribute("id", moji + i);
            tmp[i].setAttribute("name", moji + i);
        }
    },
});

/*　新規作成　----------------------------------------------------------*/
function createnew() {
    document.getElementById("sbmtype").value = "2";
    document.f_list.action = "";
    document.f_list.target = "_self";
    document.f_list.submit();
}

/*　設計作成　----------------------------------------------------------*/
function fordesign() {
    document.getElementById("sbmtype").value = "8";
    document.f_list.action = "";
    document.f_list.target = "_self";
    document.f_list.submit();
}

/*　印刷　--------------------------------------------------------------*/
function pr() {
    $("#table td").bind("click", function () {
        $tag_tr = $(this).parent()[0]; //クリックした行を取得
        $rowNum = $tag_tr.rowIndex - 1; //行番号を取得
        const el =
            document.getElementsByName("SerialNumber")[$rowNum].textContent;
        document.getElementById("SerialNumber").value = el;
        document.getElementById("sbmtype").value = "1";
        document.f_list.action = window.location.href + "/repreview";
        document.f_list.target = "_new";
    });
}

function es2pr() {
    $("#table td").bind("click", function () {
        $tag_tr = $(this).parent()[0]; //クリックした行を取得
        $rowNum = $tag_tr.rowIndex - 1; //行番号を取得
        const el =
            document.getElementsByName("SerialNumber")[$rowNum].textContent;
        document.getElementById("SerialNumber").value = el;
        document.getElementById("sbmtype").value = "1";
        document.f_list.action = "estimate2/repreview";
        document.f_list.target = "_new";
        document.f_list.submit();
    });
}

/*　削除　--------------------------------------------------------------*/
function dl() {
    if (window.confirm("削除してもよろしいですか?")) {
        // 確認ダイアログを表示
        $("#table td").bind("click", function () {
            $tag_tr = $(this).parent()[0]; //クリックした行を取得
            $rowNum = $tag_tr.rowIndex - 1; //行番号を取得
            const el =
                document.getElementsByName("SerialNumber")[$rowNum].textContent;
            document.getElementById("SerialNumber").value = el;
            document.getElementById("sbmtype").value = "5";
        });
    } else {
        // 「キャンセル」時の処理
        window.alert("キャンセルされました"); // 警告ダイアログを表示
        return false; // 送信を中止
    }
}

/*　送付文書　----------------------------------------------------------*/
function sd() {
    $("#table td").bind("click", function () {
        $tag_tr = $(this).parent()[0]; //クリックした行を取得
        $rowNum = $tag_tr.rowIndex - 1; //行番号を取得
        const el =
            document.getElementsByName("SerialNumber")[$rowNum].textContent;
        document.getElementById("SerialNumber").value = el;
        document.getElementById("sbmtype").value = "7";
    });
}

/*　見積->請求　--------------------------------------------------------*/
function e2b() {
    $("#table td").bind("click", function () {
        $tag_tr = $(this).parent()[0]; //クリックした行を取得
        $rowNum = $tag_tr.rowIndex - 1; //行番号を取得
        const el =
            document.getElementsByName("SerialNumber")[$rowNum].textContent;
        document.getElementById("SerialNumber").value = el;
        document.getElementById("sbmtype").value = "13";
    });
}

/*　請求一覧印刷　--------------------------------------------------------*/
function listopen() {
    document.f_list.action = window.location.href + "/list_print";
    document.f_list.target = "_new";
    document.f_list.submit();
}

/*　履歴　--------------------------------------------------------------*/
$(".sellist").bind("click", function () {
    $tag_tr = $(this).parent()[0]; //クリックした行を取得
    $rowNum = $tag_tr.rowIndex - 1; //行番号を取得
    const el = document.getElementsByName("SerialNumber")[$rowNum].textContent;
    document.getElementById("SerialNumber").value = el;
    document.getElementById("sbmtype").value = "6";
    document.f_list.action = "";
    document.f_list.target = "_self";
    document.f_list.submit();
});

/*　検索　--------------------------------------------------------------*/
function search_click() {
    document.getElementById("sbmtype").value = "1";
    document.f_list.action = "";
    document.f_list.target = "_self";
}
