async function loadAttendanceWidget() {
    /*
    |--------------------------------------------------------------------------
    | widget element
    |--------------------------------------------------------------------------
    */
    const widget = document.getElementById("attendance-widget");

    if (!widget) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | loading
    |--------------------------------------------------------------------------
    */
    widget.innerHTML = `
        <div style="padding:20px;">
            読み込み中...
        </div>
    `;

    try {
        /*
        |--------------------------------------------------------------------------
        | fetch API
        |--------------------------------------------------------------------------
        */
        const response = await fetch(
            "https://cf444722.cloudfree.jp/api/widget/attendance",
        );

        const data = await response.json();

        /*
        |--------------------------------------------------------------------------
        | worker rows
        |--------------------------------------------------------------------------
        */
        let workerRows = "";

        data.workers.forEach((worker) => {
            workerRows += `
                <tr>
                    <td>${worker.name}</td>
                    <td style="text-align:center;">
                        ${worker.clock_in}
                    </td>
                </tr>
            `;
        });

        /*
        |--------------------------------------------------------------------------
        | render
        |--------------------------------------------------------------------------
        */
        widget.innerHTML = `

            <div style="
                border-radius:10px;
                overflow:hidden;
                border:1px solid #ddd;
                font-family:sans-serif;
                background:#fff;
            ">

                <div style="
                    background:#17a2b8;
                    color:#fff;
                    padding:12px 16px;
                    font-size:18px;
                    font-weight:bold;
                ">

                    作業員出勤状況

                </div>

                <div style="padding:16px;">

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        margin-bottom:10px;
                    ">
                        <span>出勤人数</span>
                        <strong>${data.totalCount}</strong>
                    </div>

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        margin-bottom:20px;
                    ">
                        <span>未退勤</span>
                        <strong>${data.workingCount}</strong>
                    </div>

                    <details>

                        <summary style="
                            cursor:pointer;
                            margin-bottom:10px;
                        ">
                            未退勤者一覧
                        </summary>

                        <table style="
                            width:100%;
                            border-collapse:collapse;
                        ">

                            <thead>

                                <tr>

                                    <th style="
                                        text-align:left;
                                        border-bottom:1px solid #ddd;
                                        padding:8px;
                                    ">
                                        氏名
                                    </th>

                                    <th style="
                                        text-align:center;
                                        border-bottom:1px solid #ddd;
                                        padding:8px;
                                    ">
                                        出勤
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                ${workerRows}

                            </tbody>

                        </table>

                    </details>

                </div>

            </div>
        `;
    } catch (error) {
        widget.innerHTML = `
            <div style="padding:20px; color:red;">
                widget load error
            </div>
        `;

        console.error(error);
    }
}

/*
|--------------------------------------------------------------------------
| 初回
|--------------------------------------------------------------------------
*/
loadAttendanceWidget();

/*
|--------------------------------------------------------------------------
| 30秒更新
|--------------------------------------------------------------------------
*/
setInterval(loadAttendanceWidget, 30000);
