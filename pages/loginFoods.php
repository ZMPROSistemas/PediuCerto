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

<img class="mb-4" src="https://zmsys.com.br/images/Logo_site_logi.png" alt="" width="244">

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
    <button type="submit" class="btn btn-lg btn-primary btn-block" style="background-color: #F58634; border:none;">Entrar</button>

    <p class="mt-5 mb-3">Não tem cadastro? <a href="#">Cadastre-se</a> </p>
    <p class="mt-5 mb-3"><span><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="copyright" class="svg-inline--fa fa-copyright fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 448c-110.532 0-200-89.451-200-200 0-110.531 89.451-200 200-200 110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200zm107.351-101.064c-9.614 9.712-45.53 41.396-104.065 41.396-82.43 0-140.484-61.425-140.484-141.567 0-79.152 60.275-139.401 139.762-139.401 55.531 0 88.738 26.62 97.593 34.779a11.965 11.965 0 0 1 1.936 15.322l-18.155 28.113c-3.841 5.95-11.966 7.282-17.499 2.921-8.595-6.776-31.814-22.538-61.708-22.538-48.303 0-77.916 35.33-77.916 80.082 0 41.589 26.888 83.692 78.277 83.692 32.657 0 56.843-19.039 65.726-27.225 5.27-4.857 13.596-4.039 17.82 1.738l19.865 27.17a11.947 11.947 0 0 1-1.152 15.518z"></path></svg> 
    ZM Sys - 2020</span></p>

</form>