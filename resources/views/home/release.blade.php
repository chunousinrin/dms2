<div class="table-wrap">
    <h5>最新の投稿</h5>
    <table style="width: 100%;" class="table table-bordered table-sm">
        <thead>
            <tr class="table-success">
                <td>作成日</td>
                <td>種類</td>
                <td>作成者</td>
                <td>タイトル</td>
                <td>金額</td>
            </tr>
        </thead>
        <tbody>
            @foreach($releases as $release)
            <tr>
                <td style='text-align:center;'>{{$release->CreatedDate}}</td>
                <td style='text-align:center;'>{{$release->DocType}}</td>
                <td>{{$release->UserName}}</td>
                <td>{{$release->Title}}</td>
                <td style='text-align:right;'>{{number_format($release->price)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>