<table class="table table-bordered">
    <thead>
        <tr>
            <th>氏名</th>
            <th>出勤日数合計</th>
            <th>有給合計</th>
            <th>詳細</th>
        </tr>
    </thead>
    <tbody>
        @foreach($summary as $row)
        <tr>
            <td>{{ $row->user_name }}</td>
            <td>{{ $row->total_work_days }}</td>
            <td>{{ $row->total_paid_holidays }}</td>
            <td><a href="..." class="btn btn-sm btn-primary">詳細</a></td>
        </tr>
        @endforeach
    </tbody>
</table>