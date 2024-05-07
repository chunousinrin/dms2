const today = new Date();
const year = today.getFullYear();
const month = today.getMonth();
const day = today.getDate();
const hour = today.getHours();
const miute = today.getMinutes();
const second = today.getSeconds();
const toTwoDigits = function (num, digit) {
    num += "";
    if (num.length < digit) {
        num = "0" + num;
    }
    return num;
};
const yyyy = toTwoDigits(year, 4);
const mm = toTwoDigits(month + 1, 2);
const dd = toTwoDigits(day, 2);
const hh = toTwoDigits(hour, 2);
const mi = toTwoDigits(miute, 2);
const ss = toTwoDigits(second, 2);
const ymd = yyyy + "-" + mm + "-" + dd;
const hms = hh + ":" + mi;

function opdate() {
    window.onload = document.getElementById("WorkingDay").value = ymd;
}

function attime() {
    document.getElementById("AttendanceTime").value = hms;
    attendanceform.submit();
}

function ottime() {
    document.getElementById("OutingTime").value = hms;
    attendanceform.submit();
}

function retime() {
    document.getElementById("ReentryTime").value = hms;
    attendanceform.submit();
}

function lvtime() {
    document.getElementById("LeavingTime").value = hms;
    attendanceform.submit();
}
function set2fig(num) {
    // 桁数が1桁だったら先頭に0を加えて2桁に調整する
    var ret;
    if (num < 10) {
        ret = "0" + num;
    } else {
        ret = num;
    }
    return ret;
}
