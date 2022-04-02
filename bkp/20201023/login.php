<?php

if (array_key_exists("login_invalido", $_GET) && $_GET["login_invalido"] == "true") {
	//alert('Nome de Usuário ou Senha Inválidos !!!');
}

if (array_key_exists("usuario_ativo", $_GET) && $_GET["usuario_ativo"] == "false") {
	//alert('Usuário Está Desativado !!!');
}

if (array_key_exists("empresa_ativa", $_GET) && $_GET["empresa_ativa"] == "false") {
	//alert('Empresa Está Desativada !!!');
}
?>
<!DOCTYPE html>

<html lang="pt-br" ng-app="ZMPro">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="msapplication-TileImage" content="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-270x270.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>ZM Pro - Administrativo</title>

        <style>.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style><link rel="icon" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-32x32.png" sizes="32x32" />
        <link rel="icon" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-180x180.png" />

        <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/mCustomScrollbar.min.css">
        <script src="js/solid.js"></script>
        <script src="js/fontawesome.min.js"></script>



    </head>

  <style type="text/css">

    @import "https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap";

    html, body {

      font-family: 'Baloo 2', cursive;
      height: 100%;
      color: #F9F9F9FF;
    }

    body {

      display: -ms-flexbox;
      display: flex;
      -ms-flex-align: center;
      align-items: center;
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #BBB;
      background-image: url(bg/blurred-background-1.jpg);
    }

    .form-signin {
      width: 100%;
      max-width: 330px;
      padding: 15px;
      margin: auto;
    }

    .form-signin .checkbox {
    font-weight: 400;
    }

    .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
    }

    .form-signin .form-control:focus {
    z-index: 2;
    }

    .form-signin input[type="email"] {
    margin-bottom: 10px;
    }

    .form-signin input[type="password"] {
    margin-bottom: 20px;
    }

  </style>

  <body class="text-center">

    <form action="autenticarLogin.php" method="post" class="form-signin">
      <?php
if (array_key_exists("login_invalido", $_GET) && $_GET["login_invalido"] == "true") {
	?>
          <div class="alert alert-danger" role="alert" style="position:absolute;right: 0;margin-top: 0px;">
            Nome de Usuário ou Senha Inválidos !!!
          </div>
          <?php
}
if (array_key_exists("usuario_ativo", $_GET) && $_GET["usuario_ativo"] == "false") {
	?>
          <div class="alert alert-danger" role="alert" style="position:absolute;right: 0;margin-top: 0px;">
            Usuário Está Desativado !!!
          </div>
          <?php
}
if (array_key_exists("empresa_ativa", $_GET) && $_GET["empresa_ativa"] == "false") {
	?>
          <div class="alert alert-danger" role="alert" style="position:absolute;right: 0;margin-top: 0px;">
            Empresa Está Desativada !!!
          </div>
          <?php
}
?>

      <img class="mb-4" src="images/LogoZMProsite.png" alt="" width="144" height="144">
      <h1 class="h3 mb-3 font-weight-normal">Login</h1>
      <label for="inputEmail" class="sr-only">Endereço de email</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Seu email" name="usuario" required autofocus>
      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Lembrar de mim
        </label>
      </div>
      <button type="submit" class="btn btn-lg btn-primary btn-block">Entrar</button>

      <p class="mt-5 mb-3">Não tem cadastro? <a href="#">Cadastre-se</a> </p>
      <p class="mt-5 mb-3"><span><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="copyright" class="svg-inline--fa fa-copyright fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 448c-110.532 0-200-89.451-200-200 0-110.531 89.451-200 200-200 110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200zm107.351-101.064c-9.614 9.712-45.53 41.396-104.065 41.396-82.43 0-140.484-61.425-140.484-141.567 0-79.152 60.275-139.401 139.762-139.401 55.531 0 88.738 26.62 97.593 34.779a11.965 11.965 0 0 1 1.936 15.322l-18.155 28.113c-3.841 5.95-11.966 7.282-17.499 2.921-8.595-6.776-31.814-22.538-61.708-22.538-48.303 0-77.916 35.33-77.916 80.082 0 41.589 26.888 83.692 78.277 83.692 32.657 0 56.843-19.039 65.726-27.225 5.27-4.857 13.596-4.039 17.82 1.738l19.865 27.17a11.947 11.947 0 0 1-1.152 15.518z"></path></svg> ZM Pro Sistemas - 2020</span></p>
    </form>

  </body>
</html>