<style>
    html {
        font-size: 62.5%;
    }

    #header,
    #footer,
    .header {
        display: none;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
        -moz-appearance: textfield;
        border-radius: 0;
    }

    input {
        outline: 1px solid rgba(112, 189, 41, 1);
        border: none;
        background-color: rgba(112, 189, 41, 0.2);
        padding: 0.5em;
        width: 100%;
        box-sizing: border-box;
        border-radius: 0;
    }

    * {
        font-size: 1.6rem;
        font-family: "Noto Sans JP", sans-serif;
    }

    h1 {
        width: 100%;
        font-size: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5em 0;
    }

    h1 select {
        outline: 1px solid rgba(112, 189, 41, 1);
        border: none;
        font-size: 2.5rem;
        padding: 0.2em;
        border-radius: 0;
        margin: 0 0.2em;
    }

    body,
    p {
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        position: relative;
    }

    table tbody tr {
        border-bottom: 1px solid rgba(112, 189, 41, 1);
    }

    table tbody tr td {
        padding: 0.5em;
    }

    table tbody tr td:first-child {
        text-align: center;
    }

    table tbody tr td:last-child {
        text-align: center;
    }

    table tbody tr td:nth-of-type(-n + 2) {
        border-right: 1px dotted rgba(112, 189, 41, 1);
    }

    table thead tr,
    table tfoot tr {
        position: sticky;
        background-color: white;
    }

    table thead tr {
        top: 0;
    }

    table tfoot tr {
        bottom: 0;
    }

    table thead tr th,
    table tfoot tr td {
        padding: 0.5em;
        background-color: rgba(112, 189, 41, 0.5);
        text-align: center;
        font-weight: normal;
    }

    table thead tr th:nth-child(-n + 2),
    table tfoot tr td:nth-child(-n + 2) {
        border-right: 1px dotted rgba(2, 51, 40, 1);
    }

    .container {
        width: 50%;
        margin: 0 auto;
    }

    @media screen and (max-width: 900px) {
        .container {
            width: 100%;
        }
    }
</style>
<script>
    window.onload = function() {
        document.getElementById("d4").style.display = "block";
        document.getElementById("d3").style.display = "none";
    };

    function zaicho() {
        if (document.getElementById("selzaicho").value == "4") {
            document.getElementById("d25").style.display = "none";
            document.getElementById("d3").style.display = "none";
            document.getElementById("d4").style.display = "block";
        } else if (document.getElementById("selzaicho").value == "3") {
            document.getElementById("d25").style.display = "none";
            document.getElementById("d3").style.display = "block";
            document.getElementById("d4").style.display = "none";
        }else if (document.getElementById("selzaicho").value == "2.5") {
            document.getElementById("d25").style.display = "block";
            document.getElementById("d3").style.display = "none";
            document.getElementById("d4").style.display = "none";
        }
    }
</script>


<h1>
    材長
    <select name="selzaicho" id="selzaicho" onchange="zaicho()">
        <option value="4" selected>4</option>
        <option value="3">3</option>
        <option value="2.5">2.5</option>
    </select>
    m
</h1>

<div id="d4" style="width: 100%; height: 100%">
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th style="width: 20%">径級</th>
                    <th style="width: 50%">数量</th>
                    <th style="width: 30%">材積(㎥)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>14</td>
                    <td>
                        <input type="number" step="1" name="suryo14" id="suryo14" onchange="k14(),ktotal();" />
                    </td>
                    <td name="zaiseki14" id="zaiseki14"></td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>
                        <input type="number" step="1" name="suryo16" id="suryo16" onchange="k16(),ktotal();" />
                    </td>
                    <td name="zaiseki16" id="zaiseki16"></td>
                </tr>
                <tr>
                    <td>18</td>
                    <td>
                        <input type="number" step="1" name="suryo18" id="suryo18" onchange="k18(),ktotal();" />
                    </td>
                    <td name="zaiseki18" id="zaiseki18"></td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>
                        <input type="number" step="1" name="suryo20" id="suryo20" onchange="k20(),ktotal();" />
                    </td>
                    <td name="zaiseki20" id="zaiseki20"></td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>
                        <input type="number" step="1" name="suryo22" id="suryo22" onchange="k22(),ktotal();" />
                    </td>
                    <td name="zaiseki22" id="zaiseki22"></td>
                </tr>
                <tr>
                    <td>24</td>
                    <td>
                        <input type="number" step="1" name="suryo24" id="suryo24" onchange="k24(),ktotal();" />
                    </td>
                    <td name="zaiseki24" id="zaiseki24"></td>
                </tr>
                <tr>
                    <td>26</td>
                    <td>
                        <input type="number" step="1" name="suryo26" id="suryo26" onchange="k26(),ktotal();" />
                    </td>
                    <td name="zaiseki26" id="zaiseki26"></td>
                </tr>
                <tr>
                    <td>28</td>
                    <td>
                        <input type="number" step="1" name="suryo28" id="suryo28" onchange="k28(),ktotal();" />
                    </td>
                    <td name="zaiseki28" id="zaiseki28"></td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>
                        <input type="number" step="1" name="suryo30" id="suryo30" onchange="k30(),ktotal();" />
                    </td>
                    <td name="zaiseki30" id="zaiseki30"></td>
                </tr>
                <tr>
                    <td>32</td>
                    <td>
                        <input type="number" step="1" name="suryo32" id="suryo32" onchange="k32(),ktotal();" />
                    </td>
                    <td name="zaiseki32" id="zaiseki32"></td>
                </tr>
                <tr>
                    <td>34</td>
                    <td>
                        <input type="number" step="1" name="suryo34" id="suryo34" onchange="k34(),ktotal();" />
                    </td>
                    <td name="zaiseki34" id="zaiseki34"></td>
                </tr>
                <tr>
                    <td>36</td>
                    <td>
                        <input type="number" step="1" name="suryo36" id="suryo36" onchange="k36(),ktotal();" />
                    </td>
                    <td name="zaiseki36" id="zaiseki36"></td>
                </tr>
                <tr>
                    <td>38</td>
                    <td>
                        <input type="number" step="1" name="suryo38" id="suryo38" onchange="k38(),ktotal();" />
                    </td>
                    <td name="zaiseki38" id="zaiseki38"></td>
                </tr>
                <tr>
                    <td>40</td>
                    <td>
                        <input type="number" step="1" name="suryo40" id="suryo40" onchange="k40(),ktotal();" />
                    </td>
                    <td name="zaiseki40" id="zaiseki40"></td>
                </tr>
                <tr>
                    <td>42</td>
                    <td>
                        <input type="number" step="1" name="suryo42" id="suryo42" onchange="k42(),ktotal();" />
                    </td>
                    <td name="zaiseki42" id="zaiseki42"></td>
                </tr>
                <tr>
                    <td>44</td>
                    <td>
                        <input type="number" step="1" name="suryo44" id="suryo44" onchange="k44(),ktotal();" />
                    </td>
                    <td name="zaiseki44" id="zaiseki44"></td>
                </tr>
                <tr>
                    <td>46</td>
                    <td>
                        <input type="number" step="1" name="suryo46" id="suryo46" onchange="k46(),ktotal();" />
                    </td>
                    <td name="zaiseki46" id="zaiseki46"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>合計</td>
                    <td id="suryototal"></td>
                    <td id="zaisekitotal"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        function k14() {
            ks14 = (78 * document.getElementById("suryo14").value) / 1000;
            document.getElementById("zaiseki14").innerHTML = ks14.toFixed(3);
        }

        function k16() {
            ks16 = (102 * document.getElementById("suryo16").value) / 1000;
            document.getElementById("zaiseki16").innerHTML = ks16.toFixed(3);
        }

        function k18() {
            ks18 = (130 * document.getElementById("suryo18").value) / 1000;
            document.getElementById("zaiseki18").innerHTML = ks18.toFixed(3);
        }

        function k20() {
            ks20 = (160 * document.getElementById("suryo20").value) / 1000;
            document.getElementById("zaiseki20").innerHTML = ks20.toFixed(3);
        }

        function k22() {
            ks22 = (194 * document.getElementById("suryo22").value) / 1000;
            document.getElementById("zaiseki22").innerHTML = ks22.toFixed(3);
        }

        function k24() {
            ks24 = (230 * document.getElementById("suryo24").value) / 1000;
            document.getElementById("zaiseki24").innerHTML = ks24.toFixed(3);
        }

        function k26() {
            ks26 = (270 * document.getElementById("suryo26").value) / 1000;
            document.getElementById("zaiseki26").innerHTML = ks26.toFixed(3);
        }

        function k28() {
            ks28 = (314 * document.getElementById("suryo28").value) / 1000;
            document.getElementById("zaiseki28").innerHTML = ks28.toFixed(3);
        }

        function k30() {
            ks30 = (360 * document.getElementById("suryo30").value) / 1000;
            document.getElementById("zaiseki30").innerHTML = ks30.toFixed(3);
        }

        function k32() {
            ks32 = (410 * document.getElementById("suryo32").value) / 1000;
            document.getElementById("zaiseki32").innerHTML = ks32.toFixed(3);
        }

        function k34() {
            ks34 = (462 * document.getElementById("suryo34").value) / 1000;
            document.getElementById("zaiseki34").innerHTML = ks34.toFixed(3);
        }

        function k36() {
            ks36 = (518 * document.getElementById("suryo36").value) / 1000;
            document.getElementById("zaiseki36").innerHTML = ks36.toFixed(3);
        }

        function k38() {
            ks38 = (578 * document.getElementById("suryo38").value) / 1000;
            document.getElementById("zaiseki38").innerHTML = ks38.toFixed(3);
        }

        function k40() {
            ks40 = (640 * document.getElementById("suryo40").value) / 1000;
            document.getElementById("zaiseki40").innerHTML = ks40.toFixed(3);
        }

        function k42() {
            ks42 = (706 * document.getElementById("suryo42").value) / 1000;
            document.getElementById("zaiseki42").innerHTML = ks42.toFixed(3);
        }

        function k44() {
            ks44 = (774 * document.getElementById("suryo44").value) / 1000;
            document.getElementById("zaiseki44").innerHTML = ks44.toFixed(3);
        }

        function k46() {
            ks46 = (846 * document.getElementById("suryo46").value) / 1000;
            document.getElementById("zaiseki46").innerHTML = ks46.toFixed(3);
        }

        function ktotal() {
            kstotal =
                Number(document.getElementById("zaiseki14").innerHTML) +
                Number(document.getElementById("zaiseki16").innerHTML) +
                Number(document.getElementById("zaiseki18").innerHTML) +
                Number(document.getElementById("zaiseki20").innerHTML) +
                Number(document.getElementById("zaiseki22").innerHTML) +
                Number(document.getElementById("zaiseki24").innerHTML) +
                Number(document.getElementById("zaiseki26").innerHTML) +
                Number(document.getElementById("zaiseki28").innerHTML) +
                Number(document.getElementById("zaiseki30").innerHTML) +
                Number(document.getElementById("zaiseki32").innerHTML) +
                Number(document.getElementById("zaiseki34").innerHTML) +
                Number(document.getElementById("zaiseki36").innerHTML) +
                Number(document.getElementById("zaiseki38").innerHTML) +
                Number(document.getElementById("zaiseki40").innerHTML) +
                Number(document.getElementById("zaiseki42").innerHTML) +
                Number(document.getElementById("zaiseki44").innerHTML) +
                Number(document.getElementById("zaiseki46").innerHTML);
            document.getElementById("zaisekitotal").innerHTML =
                kstotal.toFixed(3);
            s4total =
                Number(document.getElementById("suryo14").value) +
                Number(document.getElementById("suryo16").value) +
                Number(document.getElementById("suryo18").value) +
                Number(document.getElementById("suryo20").value) +
                Number(document.getElementById("suryo22").value) +
                Number(document.getElementById("suryo24").value) +
                Number(document.getElementById("suryo26").value) +
                Number(document.getElementById("suryo28").value) +
                Number(document.getElementById("suryo30").value) +
                Number(document.getElementById("suryo32").value) +
                Number(document.getElementById("suryo34").value) +
                Number(document.getElementById("suryo36").value) +
                Number(document.getElementById("suryo38").value) +
                Number(document.getElementById("suryo40").value) +
                Number(document.getElementById("suryo42").value) +
                Number(document.getElementById("suryo44").value) +
                Number(document.getElementById("suryo46").value);
            document.getElementById("suryototal").innerHTML =
                s4total.toFixed(0);
        }
    </script>
</div>

<div id="d3" style="width: 100%; height: 100%">
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th style="width: 20%">径級</th>
                    <th style="width: 50%">数量</th>
                    <th style="width: 30%">材積(㎥)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>14</td>
                    <td>
                        <input type="number" step="1" name="suryo314" id="suryo314" onchange="k314(),k3total();" />
                    </td>
                    <td name="zaiseki314" id="zaiseki314"></td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>
                        <input type="number" step="1" name="suryo316" id="suryo316" onchange="k316(),k3total();" />
                    </td>
                    <td name="zaiseki316" id="zaiseki316"></td>
                </tr>
                <tr>
                    <td>18</td>
                    <td>
                        <input type="number" step="1" name="suryo318" id="suryo318" onchange="k318(),k3total();" />
                    </td>
                    <td name="zaiseki318" id="zaiseki318"></td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>
                        <input type="number" step="1" name="suryo320" id="suryo320" onchange="k320(),k3total();" />
                    </td>
                    <td name="zaiseki320" id="zaiseki320"></td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>
                        <input type="number" step="1" name="suryo322" id="suryo322" onchange="k322(),k3total();" />
                    </td>
                    <td name="zaiseki322" id="zaiseki322"></td>
                </tr>
                <tr>
                    <td>24</td>
                    <td>
                        <input type="number" step="1" name="suryo324" id="suryo324" onchange="k324(),k3total();" />
                    </td>
                    <td name="zaiseki324" id="zaiseki324"></td>
                </tr>
                <tr>
                    <td>26</td>
                    <td>
                        <input type="number" step="1" name="suryo326" id="suryo326" onchange="k326(),k3total();" />
                    </td>
                    <td name="zaiseki326" id="zaiseki326"></td>
                </tr>
                <tr>
                    <td>28</td>
                    <td>
                        <input type="number" step="1" name="suryo328" id="suryo328" onchange="k328(),k3total();" />
                    </td>
                    <td name="zaiseki328" id="zaiseki328"></td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>
                        <input type="number" step="1" name="suryo330" id="suryo330" onchange="k330(),k3total();" />
                    </td>
                    <td name="zaiseki330" id="zaiseki330"></td>
                </tr>
                <tr>
                    <td>32</td>
                    <td>
                        <input type="number" step="1" name="suryo332" id="suryo332" onchange="k332(),k3total();" />
                    </td>
                    <td name="zaiseki332" id="zaiseki332"></td>
                </tr>
                <tr>
                    <td>34</td>
                    <td>
                        <input type="number" step="1" name="suryo334" id="suryo334" onchange="k334(),k3total();" />
                    </td>
                    <td name="zaiseki334" id="zaiseki334"></td>
                </tr>
                <tr>
                    <td>36</td>
                    <td>
                        <input type="number" step="1" name="suryo336" id="suryo336" onchange="k336(),k3total();" />
                    </td>
                    <td name="zaiseki336" id="zaiseki336"></td>
                </tr>
                <tr>
                    <td>38</td>
                    <td>
                        <input type="number" step="1" name="suryo338" id="suryo338" onchange="k338(),k3total();" />
                    </td>
                    <td name="zaiseki338" id="zaiseki338"></td>
                </tr>
                <tr>
                    <td>40</td>
                    <td>
                        <input type="number" step="1" name="suryo340" id="suryo340" onchange="k340(),k3total();" />
                    </td>
                    <td name="zaiseki340" id="zaiseki340"></td>
                </tr>
                <tr>
                    <td>42</td>
                    <td>
                        <input type="number" step="1" name="suryo342" id="suryo342" onchange="k342(),k3total();" />
                    </td>
                    <td name="zaiseki342" id="zaiseki342"></td>
                </tr>
                <tr>
                    <td>44</td>
                    <td>
                        <input type="number" step="1" name="suryo344" id="suryo344" onchange="k344(),k3total();" />
                    </td>
                    <td name="zaiseki344" id="zaiseki344"></td>
                </tr>
                <tr>
                    <td>46</td>
                    <td>
                        <input type="number" step="1" name="suryo346" id="suryo346" onchange="k346(),k3total();" />
                    </td>
                    <td name="zaiseki346" id="zaiseki346"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>合計</td>
                    <td id="suryo3total"></td>
                    <td id="zaiseki3total"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        function k314() {
            ks14 = (59 * document.getElementById("suryo314").value) / 1000;
            document.getElementById("zaiseki314").innerHTML = ks14.toFixed(3);
        }

        function k316() {
            ks16 = (77 * document.getElementById("suryo316").value) / 1000;
            document.getElementById("zaiseki316").innerHTML = ks16.toFixed(3);
        }

        function k318() {
            ks18 = (97 * document.getElementById("suryo318").value) / 1000;
            document.getElementById("zaiseki318").innerHTML = ks18.toFixed(3);
        }

        function k320() {
            ks20 = (120 * document.getElementById("suryo320").value) / 1000;
            document.getElementById("zaiseki320").innerHTML = ks20.toFixed(3);
        }

        function k322() {
            ks22 = (145 * document.getElementById("suryo322").value) / 1000;
            document.getElementById("zaiseki322").innerHTML = ks22.toFixed(3);
        }

        function k324() {
            ks24 = (173 * document.getElementById("suryo324").value) / 1000;
            document.getElementById("zaiseki324").innerHTML = ks24.toFixed(3);
        }

        function k326() {
            ks26 = (203 * document.getElementById("suryo326").value) / 1000;
            document.getElementById("zaiseki326").innerHTML = ks26.toFixed(3);
        }

        function k328() {
            ks28 = (235 * document.getElementById("suryo328").value) / 1000;
            document.getElementById("zaiseki328").innerHTML = ks28.toFixed(3);
        }

        function k330() {
            ks30 = (270 * document.getElementById("suryo330").value) / 1000;
            document.getElementById("zaiseki330").innerHTML = ks30.toFixed(3);
        }

        function k332() {
            ks32 = (307 * document.getElementById("suryo332").value) / 1000;
            document.getElementById("zaiseki332").innerHTML = ks32.toFixed(3);
        }

        function k334() {
            ks34 = (347 * document.getElementById("suryo334").value) / 1000;
            document.getElementById("zaiseki334").innerHTML = ks34.toFixed(3);
        }

        function k336() {
            ks36 = (389 * document.getElementById("suryo336").value) / 1000;
            document.getElementById("zaiseki336").innerHTML = ks36.toFixed(3);
        }

        function k338() {
            ks38 = (433 * document.getElementById("suryo338").value) / 1000;
            document.getElementById("zaiseki338").innerHTML = ks38.toFixed(3);
        }

        function k340() {
            ks40 = (480 * document.getElementById("suryo340").value) / 1000;
            document.getElementById("zaiseki340").innerHTML = ks40.toFixed(3);
        }

        function k342() {
            ks42 = (529 * document.getElementById("suryo342").value) / 1000;
            document.getElementById("zaiseki342").innerHTML = ks42.toFixed(3);
        }

        function k344() {
            ks44 = (581 * document.getElementById("suryo344").value) / 1000;
            document.getElementById("zaiseki344").innerHTML = ks44.toFixed(3);
        }

        function k346() {
            ks46 = (635 * document.getElementById("suryo346").value) / 1000;
            document.getElementById("zaiseki346").innerHTML = ks46.toFixed(3);
        }

        function k3total() {
            kstotal =
                Number(document.getElementById("zaiseki314").innerHTML) +
                Number(document.getElementById("zaiseki316").innerHTML) +
                Number(document.getElementById("zaiseki318").innerHTML) +
                Number(document.getElementById("zaiseki320").innerHTML) +
                Number(document.getElementById("zaiseki322").innerHTML) +
                Number(document.getElementById("zaiseki324").innerHTML) +
                Number(document.getElementById("zaiseki326").innerHTML) +
                Number(document.getElementById("zaiseki328").innerHTML) +
                Number(document.getElementById("zaiseki330").innerHTML) +
                Number(document.getElementById("zaiseki332").innerHTML) +
                Number(document.getElementById("zaiseki334").innerHTML) +
                Number(document.getElementById("zaiseki336").innerHTML) +
                Number(document.getElementById("zaiseki338").innerHTML) +
                Number(document.getElementById("zaiseki340").innerHTML) +
                Number(document.getElementById("zaiseki342").innerHTML) +
                Number(document.getElementById("zaiseki344").innerHTML) +
                Number(document.getElementById("zaiseki346").innerHTML);
            document.getElementById("zaiseki3total").innerHTML =
                kstotal.toFixed(3);

            s3total =
                Number(document.getElementById("suryo314").value) +
                Number(document.getElementById("suryo316").value) +
                Number(document.getElementById("suryo318").value) +
                Number(document.getElementById("suryo320").value) +
                Number(document.getElementById("suryo322").value) +
                Number(document.getElementById("suryo324").value) +
                Number(document.getElementById("suryo326").value) +
                Number(document.getElementById("suryo328").value) +
                Number(document.getElementById("suryo330").value) +
                Number(document.getElementById("suryo332").value) +
                Number(document.getElementById("suryo334").value) +
                Number(document.getElementById("suryo336").value) +
                Number(document.getElementById("suryo338").value) +
                Number(document.getElementById("suryo340").value) +
                Number(document.getElementById("suryo342").value) +
                Number(document.getElementById("suryo344").value) +
                Number(document.getElementById("suryo346").value);
            document.getElementById("suryo3total").innerHTML =
                s3total.toFixed(0);
        }
    </script>
</div>

<div id="d25" style="width: 100%; height: 100%">
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th style="width: 20%">径級</th>
                    <th style="width: 50%">数量</th>
                    <th style="width: 30%">材積(㎥)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>14</td>
                    <td>
                        <input type="number" step="1" name="suryo25_14" id="suryo25_14" onchange="k25_14(),k25_total();" />
                    </td>
                    <td name="zaiseki25_14" id="zaiseki25_14"></td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>
                        <input type="number" step="1" name="suryo25_16" id="suryo25_16" onchange="k25_16(),k25_total();" />
                    </td>
                    <td name="zaiseki25_16" id="zaiseki25_16"></td>
                </tr>
                <tr>
                    <td>18</td>
                    <td>
                        <input type="number" step="1" name="suryo25_18" id="suryo25_18" onchange="k25_18(),k25_total();" />
                    </td>
                    <td name="zaiseki25_18" id="zaiseki25_18"></td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>
                        <input type="number" step="1" name="suryo25_20" id="suryo25_20" onchange="k25_20(),k25_total();" />
                    </td>
                    <td name="zaiseki25_20" id="zaiseki25_20"></td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>
                        <input type="number" step="1" name="suryo25_22" id="suryo25_22" onchange="k25_22(),k25_total();" />
                    </td>
                    <td name="zaiseki25_22" id="zaiseki25_22"></td>
                </tr>
                <tr>
                    <td>24</td>
                    <td>
                        <input type="number" step="1" name="suryo25_24" id="suryo25_24" onchange="k25_24(),k25_total();" />
                    </td>
                    <td name="zaiseki25_24" id="zaiseki25_24"></td>
                </tr>
                <tr>
                    <td>26</td>
                    <td>
                        <input type="number" step="1" name="suryo25_26" id="suryo25_26" onchange="k25_26(),k25_total();" />
                    </td>
                    <td name="zaiseki25_26" id="zaiseki25_26"></td>
                </tr>
                <tr>
                    <td>28</td>
                    <td>
                        <input type="number" step="1" name="suryo25_28" id="suryo25_28" onchange="k25_28(),k25_total();" />
                    </td>
                    <td name="zaiseki25_28" id="zaiseki25_28"></td>
                </tr>
                <tr>
                    <td>30</td>
                    <td>
                        <input type="number" step="1" name="suryo25_30" id="suryo25_30" onchange="k25_30(),k25_total();" />
                    </td>
                    <td name="zaiseki25_30" id="zaiseki25_30"></td>
                </tr>
                <tr>
                    <td>32</td>
                    <td>
                        <input type="number" step="1" name="suryo25_32" id="suryo25_32" onchange="k25_32(),k25_total();" />
                    </td>
                    <td name="zaiseki25_32" id="zaiseki25_32"></td>
                </tr>
                <tr>
                    <td>34</td>
                    <td>
                        <input type="number" step="1" name="suryo25_34" id="suryo25_34" onchange="k25_34(),k25_total();" />
                    </td>
                    <td name="zaiseki25_34" id="zaiseki25_34"></td>
                </tr>
                <tr>
                    <td>36</td>
                    <td>
                        <input type="number" step="1" name="suryo25_36" id="suryo25_36" onchange="k25_36(),k25_total();" />
                    </td>
                    <td name="zaiseki25_36" id="zaiseki25_36"></td>
                </tr>
                <tr>
                    <td>38</td>
                    <td>
                        <input type="number" step="1" name="suryo25_38" id="suryo25_38" onchange="k25_38(),k25_total();" />
                    </td>
                    <td name="zaiseki25_38" id="zaiseki25_38"></td>
                </tr>
                <tr>
                    <td>40</td>
                    <td>
                        <input type="number" step="1" name="suryo25_40" id="suryo25_40" onchange="k25_40(),k25_total();" />
                    </td>
                    <td name="zaiseki25_40" id="zaiseki25_40"></td>
                </tr>
                <tr>
                    <td>42</td>
                    <td>
                        <input type="number" step="1" name="suryo25_42" id="suryo25_42" onchange="k25_42(),k25_total();" />
                    </td>
                    <td name="zaiseki25_42" id="zaiseki25_42"></td>
                </tr>
                <tr>
                    <td>44</td>
                    <td>
                        <input type="number" step="1" name="suryo25_44" id="suryo25_44" onchange="k25_44(),k25_total();" />
                    </td>
                    <td name="zaiseki25_44" id="zaiseki25_44"></td>
                </tr>
                <tr>
                    <td>46</td>
                    <td>
                        <input type="number" step="1" name="suryo25_46" id="suryo25_46" onchange="k25_46(),k25_total();" />
                    </td>
                    <td name="zaiseki25_46" id="zaiseki25_46"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>合計</td>
                    <td id="suryo25_total"></td>
                    <td id="zaiseki25_total"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        function k25_14() {
            ks14 = (49 * document.getElementById("suryo25_14").value) / 1000;
            document.getElementById("zaiseki25_14").innerHTML = ks14.toFixed(3);
        }

        function k25_16() {
            ks16 = (64 * document.getElementById("suryo25_16").value) / 1000;
            document.getElementById("zaiseki25_16").innerHTML = ks16.toFixed(3);
        }

        function k25_18() {
            ks18 = (81 * document.getElementById("suryo25_18").value) / 1000;
            document.getElementById("zaiseki25_18").innerHTML = ks18.toFixed(3);
        }

        function k25_20() {
            ks20 = (100 * document.getElementById("suryo25_20").value) / 1000;
            document.getElementById("zaiseki25_20").innerHTML = ks20.toFixed(3);
        }

        function k25_22() {
            ks22 = (121 * document.getElementById("suryo25_22").value) / 1000;
            document.getElementById("zaiseki25_22").innerHTML = ks22.toFixed(3);
        }

        function k25_24() {
            ks24 = (144 * document.getElementById("suryo25_24").value) / 1000;
            document.getElementById("zaiseki25_24").innerHTML = ks24.toFixed(3);
        }

        function k25_26() {
            ks26 = (169 * document.getElementById("suryo25_26").value) / 1000;
            document.getElementById("zaiseki25_26").innerHTML = ks26.toFixed(3);
        }

        function k25_28() {
            ks28 = (196 * document.getElementById("suryo25_28").value) / 1000;
            document.getElementById("zaiseki25_28").innerHTML = ks28.toFixed(3);
        }

        function k25_30() {
            ks30 = (225 * document.getElementById("suryo25_30").value) / 1000;
            document.getElementById("zaiseki25_30").innerHTML = ks30.toFixed(3);
        }

        function k25_32() {
            ks32 = (256 * document.getElementById("suryo25_32").value) / 1000;
            document.getElementById("zaiseki25_32").innerHTML = ks32.toFixed(3);
        }

        function k25_34() {
            ks34 = (289 * document.getElementById("suryo25_34").value) / 1000;
            document.getElementById("zaiseki25_34").innerHTML = ks34.toFixed(3);
        }

        function k25_36() {
            ks36 = (324 * document.getElementById("suryo25_36").value) / 1000;
            document.getElementById("zaiseki25_36").innerHTML = ks36.toFixed(3);
        }

        function k25_38() {
            ks38 = (361 * document.getElementById("suryo25_38").value) / 1000;
            document.getElementById("zaiseki25_38").innerHTML = ks38.toFixed(3);
        }

        function k25_40() {
            ks40 = (400 * document.getElementById("suryo25_40").value) / 1000;
            document.getElementById("zaiseki25_40").innerHTML = ks40.toFixed(3);
        }

        function k25_42() {
            ks42 = (441 * document.getElementById("suryo25_42").value) / 1000;
            document.getElementById("zaiseki25_42").innerHTML = ks42.toFixed(3);
        }

        function k25_44() {
            ks44 = (484 * document.getElementById("suryo25_44").value) / 1000;
            document.getElementById("zaiseki25_44").innerHTML = ks44.toFixed(3);
        }

        function k25_46() {
            ks46 = (529 * document.getElementById("suryo25_46").value) / 1000;
            document.getElementById("zaiseki25_46").innerHTML = ks46.toFixed(3);
        }

        function k25_total() {
            kstotal =
                Number(document.getElementById("zaiseki25_14").innerHTML) +
                Number(document.getElementById("zaiseki25_16").innerHTML) +
                Number(document.getElementById("zaiseki25_18").innerHTML) +
                Number(document.getElementById("zaiseki25_20").innerHTML) +
                Number(document.getElementById("zaiseki25_22").innerHTML) +
                Number(document.getElementById("zaiseki25_24").innerHTML) +
                Number(document.getElementById("zaiseki25_26").innerHTML) +
                Number(document.getElementById("zaiseki25_28").innerHTML) +
                Number(document.getElementById("zaiseki25_30").innerHTML) +
                Number(document.getElementById("zaiseki25_32").innerHTML) +
                Number(document.getElementById("zaiseki25_34").innerHTML) +
                Number(document.getElementById("zaiseki25_36").innerHTML) +
                Number(document.getElementById("zaiseki25_38").innerHTML) +
                Number(document.getElementById("zaiseki25_40").innerHTML) +
                Number(document.getElementById("zaiseki25_42").innerHTML) +
                Number(document.getElementById("zaiseki25_44").innerHTML) +
                Number(document.getElementById("zaiseki25_46").innerHTML);
            document.getElementById("zaiseki25_total").innerHTML =
                kstotal.toFixed(3);

            s3total =
                Number(document.getElementById("suryo25_14").value) +
                Number(document.getElementById("suryo25_16").value) +
                Number(document.getElementById("suryo25_18").value) +
                Number(document.getElementById("suryo25_20").value) +
                Number(document.getElementById("suryo25_22").value) +
                Number(document.getElementById("suryo25_24").value) +
                Number(document.getElementById("suryo25_26").value) +
                Number(document.getElementById("suryo25_28").value) +
                Number(document.getElementById("suryo25_30").value) +
                Number(document.getElementById("suryo25_32").value) +
                Number(document.getElementById("suryo25_34").value) +
                Number(document.getElementById("suryo25_36").value) +
                Number(document.getElementById("suryo25_38").value) +
                Number(document.getElementById("suryo25_40").value) +
                Number(document.getElementById("suryo25_42").value) +
                Number(document.getElementById("suryo25_44").value) +
                Number(document.getElementById("suryo25_46").value);
            document.getElementById("suryo25_total").innerHTML =
                s3total.toFixed(0);
        }
    </script>
</div>