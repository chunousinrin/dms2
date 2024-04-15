<div class="tpc">
    <h2 style="font-size:1.2rem;margin:0;padding:0;text-align:center;color:#006451;">更新情報</h2>
    <hr>
    @foreach($topics as $topic)
    <div>
        <p style="color: crimson; font-size:0.8rem;padding-left:1em;margin:0;padding:0;">{{$topic->TopicDate}}</p>{{$topic->Article}}
    </div>
    @endforeach

</div>