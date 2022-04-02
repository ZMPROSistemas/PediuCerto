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

        <title>ZM Sys - Lançar Estoque</title>

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

    <form action="autenticarLoginEstoque.php" method="post" class="form-signin">


<?php
if (array_key_exists("login_invalido", $_GET) && $_GET["login_invalido"] == "true") {
?>
          <div class="alert alert-danger" role="alert" style="position:absolute;right: 0;margin-top: 0px;">
            Nome de Usuário ou Senha Inválidos !!!
          </div>
<?php
} elseif (array_key_exists("usuario_ativo", $_GET) && $_GET["usuario_ativo"] == "false") {
?>
          <div class="alert alert-danger" role="alert" style="position:absolute;right: 0;margin-top: 0px;">
            Usuário Está Desativado !!!
          </div>
          <?php
} elseif (array_key_exists("empresa_ativa", $_GET) && $_GET["empresa_ativa"] == "false") {
	?>
          <div class="alert alert-danger" role="alert" style="position:absolute;right: 0;margin-top: 0px;">
            Empresa Está Desativada !!!
          </div>
<?php
} elseif (!array_key_exists("e", $_GET)) {

        header("Location: login.php?login_invalido=false&usuario_ativo=false&empresa_ativa=false"); #redireciona para a pagina
        die();
}
?>

    <img class="mb-4" src="https://zmpro.com.br/wp-content/uploads/2020/03/Logo-ZM-Pro-300x300.png" alt="" width="144" height="144">
    <h1 class="h3 mb-3 font-weight-normal">Login Estoque</h1>
    <label for="inputEmail" class="sr-only">Endereço de email</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Seu email" name="usuario" required autofocus>
    <label for="inputPassword" class="sr-only">Senha</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
    <button type="submit" class="btn btn-lg btn-primary btn-block">Entrar</button>

    </form>

  </body>
</html>