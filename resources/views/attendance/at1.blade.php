        <section id="first">
            <?php
            while ($users = $user_st->fetch(PDO::FETCH_BOTH)) : ?>
                <div class="namelist" data-value="<?= $users['id'] ?>" onclick="name_click(this)">
                    <div data-value="<?= $users['name'] ?>"><?= $users['name'] ?></div>
                </div>
            <?php endwhile ?>
            <form action="" method="post" name="form1" id="form1">
                @csrf
                <input type="text" name="sbmtype" id="sbmtype1" value="2" hidden>
                <input type="text" name="UserID" id="UserID" hidden>
                <input type="text" name="UserName" id="UserName" hidden>
            </form>

        </section>