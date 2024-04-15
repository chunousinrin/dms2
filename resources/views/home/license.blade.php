<div class="table-wrap">
    <h5>各種許可期限
        <div style="display: flex;">
            <a href="/license" class="btn btn-sm"><span class="fa-solid fa-list"></span>一覧</a>
            &nbsp;|&nbsp;
            <a href="/license/input" class="btn btn-sm"><span class="fa-solid fa-plus"></span>追加</a>
        </div>
    </h5>
    <table style="width: 100%;" class="table table-bordered table-sm">
        <thead>
            <tr class="table-success">
                <td>残日数</td>
                <td>名称</td>
                <td>期限日</td>
                <td>着手届</td>
                <td>完了届</td>
            </tr>
        </thead>
        <tbody>
            @foreach($licenses as $license)
            <tr>
                <td>{{$license->lmt}}</td>
                <td>{{$license->FacilityName}}</td>
                <td>{{$license->LicensedEndDate}}</td>
                <td>{{$license->StartDate}}</td>
                <td>{{$license->CompletionDate}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>