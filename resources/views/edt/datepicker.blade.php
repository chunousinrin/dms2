<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

<!-- テーマhot-sneaksを選択 -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/hot-sneaks/jquery-ui.css">

<!-- DatePicker日本語表示 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<script>
    $.datepicker._gotoToday = function(id) {
        var target = $(id);
        var inst = this._getInst(target[0]);
        var date = new Date();
        this._setDate(inst, date);
        this._hideDatepicker();
    };
    $(function() {
        $(".iptdt").datepicker({
            dateFormat: "yy-mm-dd",
            showButtonPanel: true,
        });
    });
</script>