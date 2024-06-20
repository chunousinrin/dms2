<div class="tpc">
    <h2 style="font-size:1.2rem;margin:0;padding:0;text-align:center;color:#006451;">更新情報</h2>
    <hr>

    <?php
    $rss = simplexml_load_file('https://cf444722.cloudfree.jp/wp/feed/');
    foreach ($rss->channel->item as $item) {
        // 記事タイトル
        $title = $item->title;
        // 更新日付
        $date = date("Y/n/j", strtotime($item->pubDate));
        // 記事URL
        $link = $item->link;
    ?>
        <!-- 画面に表示する内容 -->
        <div style="padding-left: 1em;">
            <span>
                <?php echo $date; ?>
            </span>
            <span>
                <a href="<?php echo $link; ?>" target="_blank">
                    <?php echo $title; ?>
                </a>
            </span>
        </div>
    <?php
        // 最初の1件だけ取得するのでここで終了する
        //return;
    }
    ?>

</div>