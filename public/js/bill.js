function creg() {
    document.getElementById("b05").value = ""; //未登録を空に
    document.getElementById("b07x1").value =
        document.getElementById("b06").value; //取引先ID
    document.getElementById("b07x2").value = $(
        "[id=b06] option:selected"
    ).text(); //取引先名
}

function uncreg() {
    document.getElementById("b06").value = ""; //登録済を空に
    document.getElementById("b07x1").value = "0"; //取引先IDを空に
    document.getElementById("b07x2").value =
        document.getElementById("b05").value; //取引先名
}