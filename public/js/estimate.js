function creg() {
    document.getElementById("e05").value = ""; //未登録を空に
    document.getElementById("e07x1").value =
        document.getElementById("e06").value; //取引先ID
    document.getElementById("e07x2").value = $(
        "[id=e06] option:selected"
    ).text(); //取引先名
}

function uncreg() {
    document.getElementById("e06").value = ""; //登録済を空に
    document.getElementById("e07x1").value = "0"; //取引先IDを空に
    document.getElementById("e07x2").value =
        document.getElementById("e05").value; //取引先名
}

