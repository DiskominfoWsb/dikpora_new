<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex,nofollow">
    <meta name="description" content="Masuk ke panel">
    <meta name="author" content="DISDIKPORA Wonosobo">
    <title>DISDIKPORA - Login</title>
    <!-- Favicon-->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/assets/dikpora_logobulet.png">
    <!-- Bootstrap CSS Only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- Animate CSS *not compatible with g-recaptcha v3
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"> -->
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="text"] {
            margin-bottom: -1px;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="text-center">

<main class="form-signin w-100 m-auto">
    <form id="login-form" method="post" action="<?php echo base_url(); ?>/authentication/login">
        <img class="mb-4" src="<?php echo base_url(); ?>/assets/dikpora_logobulet.png" alt="" width="72" style="width: 72px; cursor: pointer;" onclick="window.location='<?php echo base_url(); ?>'">
        <?php if(session()->alert): ?>
        <div class="alert alert-danger"><?php echo session()->alert['message']; ?></div>
        <?php else: ?>
        <h1 class="h3 mb-3 fw-normal">Masuk Panel</h1>
        <?php endif; ?>

        <div class="form-floating mb-2">
            <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username / email" required="required">
            <label for="floatingInput" class="text-start">Username / email</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required="required">
            <label for="floatingPassword" class="text-start">Password</label>
        </div>

        <div class="checkbox mb-3 text-start">
            <p>
                &nbsp;<input type="checkbox" name="remember" value="1"> Ingat saya
                <span class="float-end">
                    <a href="#" style="text-decoration: none;">Lupa password?</a>
                </span>
            </p>
        </div>
        <button class="w-100 btn btn-lg btn-warning g-recaptcha" type="submit" data-sitekey="6LfWrPkhAAAAAHcFqtgs_1z--lI6iJ43ZmKr0P3o" data-callback="onSubmit" data-action="submit">Masuk</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2023 - DISDIKPORA Wonosobo</p>
    </form>
</main>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    function onSubmit(token) {
        document.getElementById('login-form').submit();
    }
</script>
</body>
</html>