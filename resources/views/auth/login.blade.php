<!DOCTYPE html>
<html>

<head>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <?php
    $dbh = new PDO('mysql:host=localhost;dbname=' . env('DB_DATABASE') . ';charset=utf8', env('DB_USERNAME'), env('DB_PASSWORD'));
    $sql = "SELECT * FROM conf_loginpage WHERE 1";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetch();
    ?>
    <?php
    $cname = DB::table('conf_registername')
        ->where('RegisterID', '1')
        ->get();
    echo "<title>" . $cname[0]->RegisterName . "　-DMS-" . "</title>";
    ?>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            width: 100vw;
            height: 100vh;
            background-image: url(<?= 'data:images/webp;base64,' . base64_encode($result['LPBackgroundImage']) ?>);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
        }


        .green,
        .lgbox {
            height: 100vh;
        }

        .green {
            background-color: rgb(0, 128, 45);
            mix-blend-mode: multiply;
        }


        .green,
        .lgbox,
        .lgbox_inner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateY(-50%) translateX(-50%);
            -webkit- transform: translateY(-50%) translateX(-50%);
        }

        .lgbox_inner {
            text-align: center;
            width: 80%;
            max-width: 300px;
        }

        .lgbox_inner a {
            text-decoration: none !important;
        }

        .lgbox_inner a div {
            width: 70%;
            background-color: #fff;
            color: rgb(0, 128, 45);
            margin: 0 auto;
            margin-top: 0.5em;
            margin-bottom: 1em;
            padding: 0 2em;
            font-weight: bolder;
            text-align: justify;
            text-align-last: justify;
        }

        @media screen and (max-width:600px) {

            .green,
            .lgbox {
                width: 90vw;
            }
        }

        @media screen and (min-width:600px) and (max-width:800px) {

            .green,
            .lgbox {
                width: 70vw;
            }
        }

        @media screen and (min-width:800px) {

            .green,
            .lgbox {
                width: 50vw;
                max-width: 500px;
            }

        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="green"></div>
    <div class="lgbox">
        <div class="lgbox_inner">
            <a href=".">
                <?php
                $sql = "SELECT * FROM conf_jforestlogo WHERE 1";
                $stmt = $dbh->query($sql);
                $result = $stmt->fetch();
                ?>
                <img src="<?= 'data:image/svg+xml;base64,' . base64_encode($result['JforestWhite']) ?>" alt="中濃森林組合" style="width: 70%; margin:0 auto;">
                <?php
                $sql = "SELECT * FROM conf_registername WHERE 1";
                $stmt = $dbh->query($sql);
                $result = $stmt->fetch();
                $dbh = 0;
                ?>
                <div><?= $result['RegisterName'] ?></div>
            </a>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input name="email" type="email" class="form-control rounded-0" placeholder="Email" value="{{ old('email') }}" autofocus>
                    <label for="floatingInput">Email address</label>
                    @if ($errors->has('email'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    <input name="password" type="password" class="form-control rounded-0" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    @if ($errors->has('password'))
                    <span class="text-danger" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="mb-3 custom-control custom-checkbox">
                    <input class="form-check-input" id="flexCheckDefault" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckDefault" style="color: #fff;">Email・Passwordを記憶する</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-warning rounded-0">ログイン</button>
                </div>
            </form>
            <hr>
            <a href="{{ route('password.request') }}" style="color: #fff;">パスワードを忘れた場合</a>
        </div>
    </div>
</body>

</html>