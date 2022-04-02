<?php
if(isset($_GET['app'])){
    $app = $_GET['app'];
  }else{
    $app = 'zmpro';
  }

  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');

?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="msapplication-TileImage" content="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-270x270.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>ZM Pro - Cadastro</title>

        <link rel="icon" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="https://zmpro.com.br/wp-content/uploads/2020/03/cropped-Logo-ZM-Pro3-180x180.png" />

        <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/mCustomScrollbar.min.css">
        <script src="js/fontawesome.min.js"></script>

    </head>
    <body>

      <header style="text-align:center; padding-top:30px">
        <div>
          <h1>Cadastro
            <?php
              if($app=='zmpro'){
                echo 'ZM Pro';
              } else{
                echo 'Pediu Certo';
              }
            ?>
          </h1>
        </div>
      </header>

    
      <style type="text/css">

        html, body {

          font-family: 'Baloo 2', cursive;
          height: 100%;
          color: #F9F9F9FF;
        }

        body {
          background-image: url(bg/blurred-background-1.jpg);
        }
        .alert{
          display: none;
        }

        
          <?php
            if($app=='zmpro'){
          ?>
            .btn-primary {
            
            }
          <?php
            } else {

            ?>
            .btn-primary {
            background-color:  #F58634;
            }
            <?php
            }
          ?>
        
        
        
      </style>
      
      <div class="alert alert-danger" role="alert" style="position:fixed;right: 0;margin-top: 0px;">
          Empresa já cadastrada, por favor faça login!
      </div>
      
      
      <div class="cadastro">

        <div class="row justify-content-md-center">
          <div class="col-md-6 d-flex">          
            <form class="mt-4 mb-4" id="cad" method="POST" action="CadNovo.php" autocomplete="off">
              <div class="form-row">
                <input type="hidden" id="app" name="app" value="<?=$app?>">
                <div class="form-group col-md-6">
                    <label>CPF/CNPJ</label>
                    <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" onblur="verificaEmp(this.value)" required>
                </div>
                <div class="form-group col-md-6">
                  <label>Inscrição Estadual</label>
                  <input type="text" class="form-control" id="inscricaoEstadual" name="inscricaoEstadual">
                </div>
                <div class="form-group col-md-6">
                  <label>Razão Social</label>
                  <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" required>
                </div>
                <div class="form-group col-md-6">
                  <label>Nome Fantasia</label>
                  <input type="text" class="form-control" id="nomeFantasia" name="nomeFantasia" required>
                </div>
                <div class="form-group col-md-6">
                  <label>Nome Responsavel </label>
                  <input type="text" class="form-control" id="nomeResponsavel" name="nomeResponsavel" required>
                </div>
                <div class="form-group col-md-3   ">
                  <label>Celular/Telefone</label>
                  <input type="text" class="form-control" id="celular" name="celular" required>
                </div>
                <div class="form-group col-md-3">
                  <label>CEP</label>
                  <input type="text" class="form-control" id="cep" name="cep" required>
                </div>
                <div class="form-group col-md-10">
                  <label>Endereço</label>
                  <input type="text" class="form-control" id="endereco" name="endereco" required>
                </div>
                <div class="form-group col-md-2">
                  <label>Numero</label>
                  <input type="text" class="form-control" id="numero" name="numero" required>
                </div>
                <div class="form-group col-md-6">
                  <label>Bairro</label>
                  <input type="text" class="form-control" id="bairro" name="bairro" required>
                </div>
                <div class="form-group col-md-6">
                  <label>Complemento</label>
                  <input type="text" class="form-control" id="complemento" name="complemento">
                </div>
                 <div class="form-group col-md-4">
                  <label>Cidade</label>
                  <input type="text" class="form-control" id="cidade" name="cidade" required>
                </div>
                <div class="form-group col-md-2">
                  <label>Estado</label>
                  <select type="text" class="form-control" id="estado" name="estado" required>
                    <option value=""></option>
                    <option value="AC">AC</option>
                    <option value="AL">AL</option>
                    <option value="AP">AM</option>
                    <option value="AM">AM</option>
                    <option value="BA">BA</option>
                    <option value="CE">CE</option>
                    <option value="DF">DF</option>
                    <option value="ES">ES</option>
                    <option value="GO">GO</option>
                    <option value="MA">MA</option>
                    <option value="MT">MT</option>
                    <option value="MS">MS</option>
                    <option value="MG">MG</option>
                    <option value="PA">PA</option>
                    <option value="PB">PB</option>
                    <option value="PR">PR</option>
                    <option value="PE">PE</option>
                    <option value="PI">PI</option>
                    <option value="RJ">RJ</option>
                    <option value="RN">RN</option>
                    <option value="RS">RS</option>
                    <option value="RO">RO</option>
                    <option value="RR">RR</option>
                    <option value="SC">SC</option>
                    <option value="SP">SP</option>
                    <option value="SE">SE</option>
                    <option value="TO">TO</option>
                  </select>
                </div>
               
                <!-- <div class="form-group col-md-6">
                  <label>Site</label>
                  <input type="text" class="form-control" id="site" name="site">
                </div> -->
                <div class="form-group col-md-6">
                  <label>E-mail</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                      </div>
                    <input type="text" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group col-md-12">
                
                </div>
                
              </div>
              
              <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>

            </form>
          </div>
        </div>
      </div>
      <script src="js/jquery-3.4.1.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/mCustomScrollbar.concat.min.js"></script>
      <script src="js/jquery.mask.min.js"></script>

      <script> 
        // form#cad = bloquear enter
        $(document).ready(function(){
          
          $("form#cad").keypress(function(e){
            if((e.keyCode == 10)||(e.keyCode == 13)){
              e.preventDefault();
            }
          })
          var tamanho = $('#cpf_cnpj').val().length;
            if(tamanho < 11){
            $("#cpf_cnpj").mask("999.999.999-99");
            } else {
              $("#cpf_cnpj").mask("99.999.999/9999-99");
            }
          $("#cep").mask("99999-999");
          $("#celular").mask("(99)99999-9999");
          $("#telefone").mask("(99)9999-9999");
        })

        $("#cpf_cnpj").keypress(function(){
          try {
            $("#cpf_cnpj").ummask()
          } catch (e) {}
          var tamanho = $('#cpf_cnpj').val().length;
            
          if(tamanho < 11){
            $("#cpf_cnpj").mask("999.999.999-99");
          } else {
            $("#cpf_cnpj").mask("99.999.999/9999-99");
          }
        })

        $("#cep").blur(function(){
          var cep = $("#cep").val();
          $.ajax({
            method: "GET",
            url:"https://viacep.com.br/ws/"+cep+"/json/",
            dataType: "json",
          }).done(function(data){
            $("#endereco").val(data.logradouro);
            $("#bairro").val(data.bairro);
            $("#cidade").val(data.localidade);
            $("#estado").val(data.uf);
            $("#numero").focus();
          })
        })
        function buscaCnpj(e){

          $.ajax({
            method: "GET",
            url: './services/api/pesquisaCNPJ.php?cnpj=' +e,
            dataType: "json",
          }).done(function(buscaCnpj){
            $('#razaoSocial').val(buscaCnpj.nome);
            $('#nomeFantasia').val(buscaCnpj.fantasia);
            $("#cep").focus();       
          });
                       
        }
        function verificaEmp(e){

          $.ajax({
            method: "GET",
            url: './services/api_existente/consultaEmp',
            data: {
              cnpj:e,
            },
            dataType: "json",
          }).done(function(result){
             
            if (result[0].retorno=='SUCCESS') {
            console.log(result);
            $(".alert").css("display", "none");
            } else {
              $(".alert").css("display", "block");
              // $(".alert").animate({
              //   height: 'toggle'
              // });
              $('#cpf_cnpj').val(null);
              }     
          });
                      
          }

        
        </script>

    <body>
</html>


