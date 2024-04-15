<div class="slbtn">
    <label for="bill" class="homebutton">
        <img src="https://icongr.am/material/file-document-edit-outline.svg?color=ffffff" alt="請求書">
        <div>請求書</div>
        <input type="submit" id="bill" value="bill" form="select" formaction="/bill" class="homebutton">
    </label>
    <label for="estimate" class="homebutton">
        <img src="https://icongr.am/material/file-document-edit-outline.svg?color=ffffff" alt="見積書">
        <div>見積書</div>
        <input type="submit" id="estimate" value="estimate" form="select" formaction="/estimate" class="homebutton">
    </label>
    <label for="draft" class="homebutton"><img src="https://icongr.am/material/file-document-edit-outline.svg?color=ffffff" alt="稟議書">
        <div>稟議書</div>
        <input type="submit" id="draft" value="draft" form="select" formaction="/draft" class="homebutton">
    </label>
    <label for="cal" class="homebutton"><img src="https://icongr.am/material/calendar-month.svg?color=ffffff" alt="カレンダー">
        <div>カレンダー</div>
        <input type="submit" id="cal" value="calendar" form="select" formaction="/calendar" class="homebutton">
    </label>
    <label for="drs" class="homebutton"><img src="https://icongr.am/material/notebook.svg?color=ffffff" alt="業務日報">
        <div>業務日報</div>
        <input type="submit" id="drs" value="drs" form="select" formaction="/drs" class="homebutton">
    </label>
</div>

<form action="" method="post" id="select">
    @csrf
    <input type="hidden" value="2" id="new" name="sbmtype">
</form>