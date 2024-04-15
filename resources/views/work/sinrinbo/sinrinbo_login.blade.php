    <div style="width: 100%;height:60vh ;position:relative;">
        <div class="loginbox text-center" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
            <h1>森林情報検索システム</h1>
            <div class="form-group">
                <p>パスワードを入力してください</p>
                <form action="" method="post">
                    @csrf
                    <input type="password" class="form-control text-center" name="pass" style="margin: 0 auto;width:20em;" autofocus><br>
                    <input type="submit" value="ログイン" class="btn btn-secondary rounded-0">
                </form>
            </div>
        </div>
    </div>