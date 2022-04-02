<?php
$login_valido='true';
if(array_key_exists("login_invalido", $_GET) && $_GET["login_invalido"]=="true"){
  $login_valido='true';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MegaTreino | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./plugins/iCheck/square/blue.css">
  <link rel="icon" href="./imagens/logo_mega.png">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
  .login-box { 
                width: 400px; 
                height: 10em;
                margin: auto;
                left: 50%; 
                margin: -120px 0 0 -110px; 
                padding:30px;
                position:fixed; 
                top: 40%;
                padding-top: 20px;
                bottom: 30%;
                margin-right: -50%;
    transform: translate(-50%, -50%);  


   }
</style>
<body class="login-page" style="align-content: center; float: center;">
  <!--  <img class="img-fluid" src="\31.01.2018\production\imagem.jfif" usemap="#shape"  /> -->
  <img width="100%" src="./imagens/fundo.jpg"> <!-- style="margin:auto;"> -->     
  

  <div style="margin-right:auto; margin-left: auto;"class="login-box" >
   
  <div class="login-logo"  style="margin-right:auto; margin-left: auto;" >
   
    <a href="./index2.html"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body"> 
    <p style="text-align:left;" class="login-logo"><img src="./imagens/logo1.png"></p>
    <form action="./menu.php" method="post">
      <div class="form-group has-feedback" style="padding-bottom:25px;
      float: center;align-content: center;">
        <input type="email" class="form-control" placeholder="Usuário" name="usuario">
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Senha" name="senha">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
           
         <!-- <div class="checkbox icheck"> -->
          <div class="form-group has-feedback">
            <?php
            if(array_key_exists("login_invalido", $_GET) && $_GET["login_invalido"]=="true"){

            //if($login_valido='false'){ 
              ?> 
              <p class="text-danger">Nome de Usuário ou Senha Inválidos !!!</p> 
              <?php 
            }
            if(array_key_exists("usuario_ativo", $_GET) && $_GET["usuario_ativo"]=="false"){

            //if($login_valido='false'){ 
              ?> 
              <p class="text-danger">Usuário Está Desativado !!!</p> 
              <?php 
            }
            if(array_key_exists("academia_ativa", $_GET) && $_GET["academia_ativa"]=="false"){

            //if($login_valido='false'){ 
              ?> 
              <p class="text-danger">Academia Está Desativada !!!</p> 
              <?php 
            }



            ?>
            <!--
            <label>
              <input type="checkbox"> Lembrar 
            </label>
            -->
          </div>
          
        </div>  
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-lock btn-lg">Entrar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!--
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    -->
    <!-- /.social-auth-links -->
<!-- 
    <a href="#">Esqueci a senha</a><br>
    <a href="register.html" class="text-center">Increva-se</a>
-->
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="js/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
