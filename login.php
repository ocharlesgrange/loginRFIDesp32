<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> User | Login </title>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <meta name="theme-color" content="#3063A0">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/stylesheets/theme.min.css" data-skin="dark">
    <link rel="stylesheet" href="assets/stylesheets/theme-dark.min.css" data-skin="default">
    <link rel="stylesheet" href="assets/stylesheets/custom.css">
    <script>
        var skin = localStorage.getItem('skin') || 'default';
        var isCompact = JSON.parse(localStorage.getItem('hasCompactMenu'));
        var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        disabledSkinStylesheet.setAttribute('rel', '');
        disabledSkinStylesheet.setAttribute('disabled', true);
        if (isCompact == true) document.querySelector('html').classList.add('preparing-compact-menu');
    </script>
</head>
<script type="text/javascript">
    $(function() {
        $("#formLogin").submit(function() {
            var objetos = this;
            var dados = new FormData(objetos);
            var loginVar = document.getElementById("usuario").value;
            $.ajax({
                type: 'POST',
                url: 'operador.php',
                data: dados,
                processData: false,
                cache: false,
                contentType: false,
                success: function(resultado) {

                    if (resultado.indexOf("LOGIN_OK") >= 0) {
                        $('#loginOK').modal('show');
                        getData(loginVar);
                    } else if (resultado.indexOf("LOGIN_ERROR" >= 0)) {
                        $('#loginOFF').modal('show');
                    }
                }
            });
            return false;
        });
    });

    function getData(login) {
        $.ajax({
            url: "rfid.php?acao=search&login=" + login,
            success: function(data) {
                if (data.indexOf("OKs") >= 0) {
                    $('#loginOK').modal('hide');
                    $("#autenticacaoOK").modal('show');
                    setTimeout(function() {
                        window.location.replace("dashboard.php");
                    }, 3000);
                }
            },
            complete: function() {
                var lopa = setTimeout(function() {
                    getData(login);
                }, 5000);
            }
        });
    }
</script>

<body>
    <div class="modal modal-alert fade" id="loginOK" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalAlertWarningLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalAlertWarningLabel" class="modal-title">
                                <i class="fa fa-bullhorn text-warning mr-1"></i> AGUARDANDO AUTENTICAÇÃO! </h5>
                </div>
                <div class="modal-body">
                    <center>
                        <p> Aproxime sua TAG RFID ao leitor para leitura dos dados...
                            <br>
                            <br><span class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></span> </p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-alert fade" id="loginOFF" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalAlertLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalAlertDangerLabel" class="modal-title">
                                <i class="fa fa-exclamation-triangle text-red mr-1"></i> ERRO: USUÁRIO OU SENHA INCORRETOS! </h5>
                </div>
                <div class="modal-body">
                    <p> Usuário e/ou senha incorretos, tente novamente! </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-alert fade" id="autenticacaoOK" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalAlertLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalAlertLabel" class="modal-title">
                                <i class="fa fa-check text-success mr-1"></i> Autenticação Concluída! </h5>
                </div>
                <div class="modal-body">
                    <center>
                        <p> Aguarde mais um pouco, você está sendo redirecionado!
                            <br>
                            <br><span class="spinner-border text-success" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></span> </p>
                </div>
            </div>
        </div>
    </div>
    </div>
    <main class="auth">
        <header id="auth-header" class="auth-header" style="background-image: url(assets/images/illustration/img-1.png);">
            <h1>
          <span class="font-weight-bold">Sistema RFID</span>
            <defs>
              <path id="a" d="M156.538 45.644v1.04a6.347 6.347 0 0 1-1.847 3.98L127.708 77.67a6.338 6.338 0 0 1-3.862 1.839h-1.272a6.34 6.34 0 0 1-3.862-1.839L91.728 50.664a6.353 6.353 0 0 1 0-9l9.11-9.117-2.136-2.138a3.171 3.171 0 0 0-4.498 0L80.711 43.913a3.177 3.177 0 0 0-.043 4.453l-.002.003.048.047 24.733 24.754-4.497 4.5a6.339 6.339 0 0 1-3.863 1.84h-1.27a6.337 6.337 0 0 1-3.863-1.84L64.971 50.665a6.353 6.353 0 0 1 0-9l26.983-27.008a6.336 6.336 0 0 1 4.498-1.869c1.626 0 3.252.622 4.498 1.87l26.986 27.006a6.353 6.353 0 0 1 0 9l-9.11 9.117 2.136 2.138a3.171 3.171 0 0 0 4.498 0l13.49-13.504a3.177 3.177 0 0 0 .046-4.453l.002-.002-.047-.048-24.737-24.754 4.498-4.5a6.344 6.344 0 0 1 8.996 0l26.983 27.006a6.347 6.347 0 0 1 1.847 3.98zm-46.707-4.095l-2.362 2.364a3.178 3.178 0 0 0 0 4.501l2.362 2.364 2.361-2.364a3.178 3.178 0 0 0 0-4.501l-2.361-2.364z"></path>
            </defs>
            <g fill="none" fill-rule="evenodd">
              <path fill="currentColor" fill-rule="nonzero" d="M39.252 80.385c-13.817 0-21.06-8.915-21.06-22.955V13.862H.81V.936h33.762V58.1c0 6.797 4.346 9.026 9.026 9.026 2.563 0 5.237-.446 8.58-1.783l3.677 12.034c-5.794 1.894-9.694 3.009-16.603 3.009zM164.213 99.55V23.78h13.372l1.225 5.571h.335c4.457-4.011 10.585-6.908 16.491-6.908 13.817 0 22.174 11.031 22.174 28.08 0 18.943-11.588 29.863-23.957 29.863-4.903 0-9.694-2.117-13.594-6.017h-.446l.78 9.025V99.55h-16.38zm25.852-32.537c6.128 0 10.92-4.903 10.92-16.268 0-9.917-3.232-14.932-10.14-14.932-3.566 0-6.797 1.56-10.252 5.126v22.397c3.12 2.674 6.686 3.677 9.472 3.677zm69.643 13.372c-17.272 0-30.643-10.586-30.643-28.972 0-18.163 13.928-28.971 28.748-28.971 17.049 0 26.075 11.477 26.075 26.52 0 3.008-.558 6.017-.78 7.354h-37.663c1.56 8.023 7.465 11.589 16.491 11.589 5.014 0 9.36-1.337 14.263-3.9l5.46 9.917c-6.351 4.011-14.597 6.463-21.951 6.463zm-1.338-45.463c-6.462 0-11.031 3.454-12.702 10.363h23.622c-.78-6.797-4.568-10.363-10.92-10.363zm44.238 44.126V23.779h13.371l1.337 12.034h.334c5.46-9.025 13.595-13.371 22.398-13.371 4.902 0 7.465.78 10.697 2.228l-3.343 13.706c-3.454-1.003-5.683-1.56-9.806-1.56-6.797 0-13.928 3.566-18.608 13.483v28.749h-16.38z"></path>
              <use class="fill-warning" xlink:href="#a"></use>
            </g>
          </svg> <span class="sr-only">Sign In</span>
        </h1>
        </header>
        <form class="auth-form" id="formLogin" name="formLogin" method="POST">
            <div class="form-group">
                <div class="form-label-group">
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuário" autocomplete="off" autofocus="">
                    <label for="inputUser">Usuário</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label-group">
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha">
                    <label for="inputPassword">Senha</label>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-lg btn-primary btn-block" type="submit">ENTRAR</button>
            </div>
            </div>
        </form>
        <footer class="auth-footer"> © 2020 Todos os direitos reservados.
        </footer>
    </main>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/popper.js/umd/popper.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendor/particles.js/particles.js"></script>
    <script>
        $(document).on('theme:init', () => {
            particlesJS.load('auth-header', 'assets/javascript/pages/particles.json');
        })
    </script>
    <script src="assets/javascript/theme.js"></script>
    <script async src="../www.googletagmanager.com/gtag/jsbe76?id=UA-116692175-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-116692175-1');
    </script>
</body>
</html>