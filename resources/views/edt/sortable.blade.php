    <!--jQueryを読み込み-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--jQuery UIを読み込み-->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!-- SortTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.js"></script>
    <script>
        $(function() {
            $("#items").sortable();
            // sortstopイベントをバインド
            $("#items").bind("sortstop", function() {
                var moji = "dipt";
                var tmp = document.getElementsByClassName("lists");
                for (var i = 0; i < tmp.length - 1; i++) {
                    tmp[i].setAttribute("id", moji + i);
                    tmp[i].setAttribute("name", moji + i);
                }
            })
            $("#items").disableSelection();
        });
    </script>