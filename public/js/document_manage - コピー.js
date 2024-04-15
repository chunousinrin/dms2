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

function createnew() {
    //新規作成
    document.getElementsByName("sbmtype")[0].value = "2";
    document.f_head.submit();
}

function fordesign() {
    //設計用作成
    document.getElementsByName("sbmtype")[0].value = "8";
    document.f_head.submit();
}

function listopen() {
    //一覧印刷
    //const lid = $(this).parent().find('#BillNum').text()
    const bl = document.getElementsByName("billlist")[0].value;
    const url = "bill/list_print?billlist=" + bl;
    window.open(url, "_blank");
}

$(".sellist").click(function (event) {
    //履歴
    const lid = $(this).parent().find("#SerialNumber").text();
    document.getElementsByName("SerialNumber")[0].value = lid;
    document.getElementsByName("sbmtype")[0].value = "6";
    document.f_head.submit();
});

$(".print").click(function (event) {
    const e = $(this).parent().parent().find("#SerialNumber").text();
    document.getElementsByName("SerialNumber")[0].value = e;
    document.getElementsByName("sbmtype")[0].value = "11";
    document.f_head.method = "post";
    document.f_head.action = window.location.href + "/repreview";
    document.f_head.target = "_blank";
    document.f_head.submit();
});

$(".sendingdoc").click(function (event) {
    //送付
    const e = $(this).parent().parent().find("#SerialNumber").text();
    document.getElementsByName("SerialNumber")[0].value = e;
    document.getElementsByName("sbmtype")[0].value = "7";
    document.f_head.submit();
});

$(".delete").click(function (event) {
    if (window.confirm("削除してもよろしいですか?")) {
        // 確認ダイアログを表示
        document.getElementsByName("sbmtype")[0].value = "5";
        $("td").click(function (event) {
            const e = $(this).parent().find("#SerialNumber").text();
            document.getElementsByName("SerialNumber")[0].value = e;
            document.f_head.submit();
        });
    } else {
        // 「キャンセル」時の処理
        window.alert("キャンセルされました"); // 警告ダイアログを表示
        return false; // 送信を中止
    }
});

function bprudt() {
    if (window.confirm("保存実行してもよろしいですか?")) {
        // 確認ダイアログを表示
        document.getElementsByName("sbmtype")[0].value = "9";
        document.f_list.submit();
    } else {
        // 「キャンセル」時の処理
        window.alert("キャンセルされました"); // 警告ダイアログを表示
        return false; // 送信を中止
    }
}

function dateasc() {
    document.getElementById("dateoder").value = " ORDER BY CreatedDate ASC";
    document.f_list.submit();
}

function datedesc() {
    document.getElementById("dateoder").value = " ORDER BY CreatedDate DESC";
    document.f_list.submit();
}

function otamtp1() {
    if (
        document.getElementById("otqat2").value?.trim() &&
        document.getElementById("otup2").value?.trim()
    ) {
        document.getElementById("otamt2").value =
            document.getElementById("otup2").value *
            document.getElementById("otqat2").value;
    } else {
        document.getElementById("otamt2").value =
            document.getElementById("otup2").value;
    }
}

function otamtp2() {
    if (
        document.getElementById("otqat3").value?.trim() &&
        document.getElementById("otup3").value?.trim()
    ) {
        document.getElementById("otamt3").value =
            document.getElementById("otup3").value *
            document.getElementById("otqat3").value;
    } else {
        document.getElementById("otamt3").value =
            document.getElementById("otup3").value;
    }
}

function otamtp3() {
    if (
        document.getElementById("otqat4").value?.trim() &&
        document.getElementById("otup4").value?.trim()
    ) {
        document.getElementById("otamt4").value =
            document.getElementById("otup4").value *
            document.getElementById("otqat4").value;
    } else {
        document.getElementById("otamt4").value =
            document.getElementById("otup4").value;
    }
}
