<!doctype html>
<html lang="en">

<head>
    <title>Login Sistema Experto</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root{
            --color-verde: #076fc0;
        }
        * {
            font-family: 'Poppins', sans-serif;
        }

        main{
            height: 100vh;
        }
        .login-p .img {
            position: relative;
            flex: 0 0 55%;
            width: 55%;
        }
        .login-p .img img{
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }

        .login-p .img:before {
            content: "";
            width: 100%;
            height: 100%;
            position: absolute;
            background-color: #076fc047;
            mix-blend-mode: multiply;
        }

        .login-p .form-log {
            flex: 0 0 45%;
            width: 45%;
            background-color: #fff;
            padding: 2rem;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .login-p .form-log .cont-form{
            position: relative;
        }

        .login-p .text-plane h1 {
            font-size: 1.8rem;
            font-weight: 600;
            line-height: 45px;
        }

        .login-p .text-plane h1>span a {
            font-size: 1.8rem;
            font-weight: 600;
            margin-top: .5rem;
            color: var(--color-verde);
        }

        .login-p .text-plane p.descrip--s {
            font-size: 1rem;
            color: #ccc;
            padding-bottom: 1rem;
        }

        /Input/
        .el-form-item {
            margin-bottom: 22px;
        }
        .el-form-item:after, .el-form-item:before {
            display: table;
            content: "";
        }

        .el-form-item--medium .el-form-item_content, .el-form-item--medium .el-form-item_label {
            line-height: 36px;
        }

        .el-form-item_content:after, .el-form-item_content:before {
            display: table;
            content: "";
        }

        .el-input {
            position: relative;
            font-size: 14px;
            display: inline-block;
            width: 100%;
        }

        .el-input--medium {
            font-size: 14px;
        }

        .el-form-item_content:after, .el-form-item_content:before {
            display: table;
            content: "";
        }

        .el-form-item__content:after {
            clear: both;
        }

        .el-input__inner {
            -webkit-appearance: none;
            background-color: #fff;
            background-image: none;
            border-radius: 4px;
            border: 2px solid rgba(168,176,193,.4);
            box-sizing: border-box;
            color: #606266;
            display: inline-block;
            font-size: inherit;
            height: auto!important;
            line-height: 36px;
            outline: 0;
            padding: .5rem 1rem .5rem 2.2rem;
            transition: border-color .2s cubic-bezier(.645,.045,.355,1);
            width: 100%;
        }

        .el-input__prefix {
            position: absolute;
            top: 0;
            -webkit-transition: all .3s;
            height: 100%;
            color: #c0c4cc;
            text-align: center;
            left: 5px;
        }

        .el-form-item .el-input span.el-input__prefix {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-left: .2rem;
        }

        .el-input span.el-input__prefix i {
            display: flex;
            align-items: center;
        }

        .btn-primary {
            margin-bottom: 1rem;
            padding: 1rem!important;
            border-radius: 5px;
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            text-decoration: none;
            background-color: var(--color-verde)!important;
            border: 0;
            box-shadow: 3px 5px 15px 0 rgba(0,0,0,.2)!important;
            letter-spacing: 1px;
            border-color: var(--color-verde)!important;
            transition: background .5s,border-color .5s;
        }

        input::placeholder{
            color: #ccc;
        }



        @media(max-width:990px) {
            .login-p .form-log {
                flex: 0 0 100%;
                width: 100%;
                background-image: url(https://inventario.misistema99.com/assets/img/login.jpg);
                background-position: center;
                background-size: cover;
            }
            .login-p .form-log::before{
                content: '';
                position: absolute;
                background: linear-gradient(#ffffff, #000000b3);
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
            }
            .login-p .text-plane p.descrip--s{
                color: #373737;
                font-weight: 500;
            }
            .boton{
                text-align: center;
            }
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')
    <main class="login-p d-block d-md-flex">
        <div class="img d-none d-md-block">
            <!-- <img src="https://source.unsplash.com/collection/962362/900x1600"> -->
            <img src="{{asset('assets/img/login.jpg')}}">
        </div>
        <div class="form-log" >
            <div class="cont-form">
                <div class="text-center pb-5">
                    <img src="{{asset('assets/img/logo.png')}}" width="150">
                </div>
                <div class="text-plane">
                    <div class="welcome">
                        <h1 class="d-none d-md-block">
                            Bienvenido a tu panel administrativo de
                            <span>
                                <a href="https://instafact.pe" target="_blank">Sistema Experto</a>
                            </span>
                        </h1>
                        <p class="descrip--s my-3">Administra, controla y organiza tu aplicación.</p>
                    </div>
                </div>
                {!! Form::open(['route' => 'login']) !!}
                <div class="el-form-item el-form-item--feedback is-required is-no-asterisk el-form-item--medium" style="margin-bottom:22px">
                    <div class="el-form-item__content" >
                        <div class="el-input el-input--medium el-input--prefix">
                            <input type="email" name="email" autocomplete="true" placeholder="Dirección de correo" class="el-input__inner" value="{{ old('email') }}" autofocus required>
                            <span class="el-input__prefix">
                                <i class="eva-hover">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="24" viewBox="0 0 24 24" fill="#DCDFE6" class="eva eva-animation eva-icon-hover-undefined"><g data-name="Layer 2"><g data-name="email"><rect width="24" height="24" opacity="0"></rect><path d="M19 4H5a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-.67 2L12 10.75 5.67 6zM19 18H5a1 1 0 0 1-1-1V7.25l7.4 5.55a1 1 0 0 0 .6.2 1 1 0 0 0 .6-.2L20 7.25V17a1 1 0 0 1-1 1z"></path></g></g></svg>
                                </i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="el-form-item el-form-item--feedback is-required is-no-asterisk el-form-item--medium" style="margin-bottom:22px">
                    <div class="el-form-item__content">
                        <div class="el-input el-input--medium el-input--prefix">
                            <input type="password" name="password" autocomplete="off" placeholder="Contraseña" class="el-input__inner" required>
                            <span class="el-input__prefix">
                                <i class="eva-hover">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="24" viewBox="0 0 24 24" fill="#DCDFE6" class="eva eva-animation eva-icon-hover-undefined"><g data-name="Layer 2"><g data-name="lock"><rect width="24" height="24" opacity="0"></rect><path d="M17 8h-1V6.11a4 4 0 1 0-8 0V8H7a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3zm-7-1.89A2.06 2.06 0 0 1 12 4a2.06 2.06 0 0 1 2 2.11V8h-4zM18 19a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1z"></path><path d="M12 12a3 3 0 1 0 3 3 3 3 0 0 0-3-3zm0 4a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"></path></g></g></svg>
                                </i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="boton">
                    <button type="submit" class="btn btn-primary">
                        <i class="eva-hover mr-2" slot="prefix"><svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="#fff" class="eva eva-animation eva-icon-hover-undefined"><g data-name="Layer 2"><g data-name="log-in"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M19 4h-2a1 1 0 0 0 0 2h1v12h-1a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1z"></path><path d="M11.8 7.4a1 1 0 0 0-1.6 1.2L12 11H4a1 1 0 0 0 0 2h8.09l-1.72 2.44a1 1 0 0 0 .24 1.4 1 1 0 0 0 .58.18 1 1 0 0 0 .81-.42l2.82-4a1 1 0 0 0 0-1.18z"></path></g></g></svg></i>
                        <span>
                            Iniciar Sesión
                        </span>
                    </button>
                </div>
                @error('email')
                <div class="form-group pt-3 text-center">
                    {{ $message }}
                </div>
                @enderror
                {!! Form::close() !!}
            </div>
        </div>
    </main>

    <!-- Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>