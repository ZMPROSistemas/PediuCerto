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
if(isset($_GET['app'])){
  $app = $_GET['app'];
}else{
  $app = 'zmpro';
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

    <?php

      if($app == 'pediucerto'){
        include_once('pages/loginFoods.php');
      }
      else if($app == 'zmpro'){
        include_once('pages/loginZmPro.php');
      }else{
        include_once('pages/loginZmPro.php');
      }
      

    ?>

  </body>
</html>