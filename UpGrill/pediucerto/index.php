<!DOCTYPE html>

<?php

session_name('http://localhost/pediucerto');

session_start();


/*
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST');
*/
    include_once("services/conn.php");
    include_once("confg/conf.php");

     $url= str_replace(''.$estabelecimento.'/pediucerto/','', $_SERVER['REQUEST_URI']);
    
     //$route = array();

     $route1 = explode('/',$url);

     if (!array_key_exists(1, $route1)) {
        $route1[1] = 0;
     }
     if (!array_key_exists(2, $route1)) {
        $route1[2] = 0;
     }

    

     include_once("confg/router.php");
    /* 
  
    var_dump($route1);

    echo '<br><br>';
    var_dump($route);
    
    

    echo $dir;
*/
     function buscaDadosEmpresa($conexao,$id){
        $dados = array();
        $resultado = mysqli_query($conexao,"select * from empresas where em_cod=$id");
        $dados = mysqli_fetch_assoc($resultado);
        return $dados;
    }

     ?>

<html lang="pt-br" ng-app="PediuCerto" ng-cloak>
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=0.75">

        <meta name="msapplication-square310x310logo" content="<?=$urlAssets?>assets/images/Favicon.png">
        <meta name="msapplication-TileImage" content="<?=$urlAssets?>assets/images/Favicon.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <link rel="icon" href="<?=$urlAssets?>assets/images/Favicon.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="<?=$urlAssets?>assets/images/Favicon.png" />

        <meta name="google-signin-client_id" content="921121352932-alvivh8sthstjh4ia4c7crvdujrcum0t.apps.googleusercontent.com">

        <meta name="msapplication-square310x310logo" content="<?=$urlAssets?>assets/images/Favicon.png">
        
        

        <?php if(($route1[1] != 'verifica') 
                && ($route1[1] != 'codigo') 
                && ($route1[1] != 'endereco') 
                && ($route1[1] != 'fPagamento') 
                && ($route1[1] != 'perfil') 
                && ($route1[1] != 'meus_pedidos') 
                && ($route1[1] != 'login_celular')
                && ($route1[1] != 'codigo-verifica')
                && ($route1[1] != 'criar-conta')
                && ($route1[1] != '')){
            echo '<meta name="description" content="Pedidos Delivery Pediu Certo - '. $empresa['em_fanta'].'">';
        } else{
            echo '<meta name="description" content="Pedidos Delivery Pediu Certo - Verificação da conta">';
        } ?>
       
        <meta name="author" content="ZM Sistemas">
        <meta name="keywords" content="App, Delivery, Sistemas">
        <meta name="robot" content="index, follow" >

        <?php if(($route1[1] != 'verifica') 
        && ($route1[1] != 'codigo') 
        && ($route1[1] != 'endereco') 
        && ($route1[1] != 'fPagamento') 
        && ($route1[1] != 'perfil') 
        && ($route1[1] != 'meus_pedidos') 
        && ($route1[1] != 'login_celular')
        && ($route1[1] != 'codigo-verifica')
        && ($route1[1] != 'criar-conta')
        && ($route1[1] != '')){
            echo '<meta property="og:title" content="Pedidos Delivery Pediu Certo - '. $empresa['em_fanta'].'" />';
        } else{
            echo '<meta property="og:title" content="Pedidos Delivery Pediu Certo - Verificação da conta" />';
        }?>    
        
        <meta property="og:type" content="Pedidos Delivery Pediu Certo" />
        <meta property="og:url" content="https://zmsys.com.br/" />
        <meta property="og:image" content="https://zmsys.com.br/images/LogoZMPro11.png" />

        <?php if(($route1[1] != 'verifica') 
                && ($route1[1] != 'codigo') 
                && ($route1[1] != 'endereco') 
                && ($route1[1] != 'fPagamento') 
                && ($route1[1] != 'perfil') 
                && ($route1[1] != 'meus_pedidos') 
                && ($route1[1] != 'login_celular')
                && ($route1[1] != 'codigo-verifica')
                && ($route1[1] != 'criar-conta')
                && ($route1[1] != '')){
            echo '<title>Pediu Certo - '. $empresa['em_fanta'].'</title>';
        } else{
            echo '<title>Pediu Certo - Verificação da conta </title>';
        }?>   
          

        <link rel="icon" href="" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="" />
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.24/angular-material.min.css">
        <!--link href="https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css" rel="stylesheet"-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&display=swap">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"/>
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <?php if(($route1[1] != 'verifica') 
                && ($route1[1] != 'codigo') 
                && ($route1[1] != 'endereco') 
                && ($route1[1] != 'fPagamento') 
                && ($route1[1] != 'perfil') 
                && ($route1[1] != 'meus_pedidos') 
                && ($route1[1] != 'login_celular')
                && ($route1[1] != 'codigo-verifica')
                && ($route1[1] != 'criar-conta')
                && ($route1[1] != '')){
            echo '<link rel="manifest" href="'.$urlAssets.'manifest.json">';
        }?>

        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        
        <!--script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgLml81x6vcnvePo90lmrKoeptkaKC2lY&callback=initMap&libraries=places&v=weekly" defer></script-->
        
        <?php
            if(($route1[1] != 'verifica') 
            && ($route1[1] != 'codigo') 
            && ($route1[1] != 'endereco') 
            && ($route1[1] != 'fPagamento') 
            && ($route1[1] != 'perfil') 
            && ($route1[1] != 'meus_pedidos') 
            && ($route1[1] != 'login_celular')
            && ($route1[1] != 'codigo-verifica')
            && ($route1[1] != 'criar-conta')
            && ($route1[1] != '')){

    
            echo  '<script>';
        
             include_once './serviceWorker.js';
            
            echo '</script>';

            }
        ?>
        
        <style>
            .container-app{
                background-color: rgb(255,255,255) !important;
                overflow: hidden;
            }
            @media (min-width: 576px) and (max-width: 992px){
                body{
                    background-color: rgb(215,215,215) !important;
                }
                .container-app{
                    margin:0 auto;
                    width:450px;
                }
                .emp {
                    font-size: 27px !important;
                }
            }
            .md-button.md-default-theme.md-fab, .md-button.md-fab {
                background-color: rgba(152,152,152,1);
                color: rgb(0 0 0);
            }

            .md-button.md-default-theme.md-fab:not([disabled]).md-focused, .md-button.md-fab:not([disabled]).md-focused, .md-button.md-default-theme.md-fab:not([disabled]):hover, .md-button.md-fab:not([disabled]):hover {
                background-color:rgba(152,152,152,1);
            }
            .swal-overlay--show-modal .swal-modal{
                width:100%;
            }
            * {
                touch-action: manipulation;
            }
            
        </style>
        


    </head>
    <body>
        
        <div ng-controller="PediuCertoCtrl" class="container-app">

            <div class="menu-top" style="width:100%; height:60px; background-color:rgba(183,183,183,41%);position: fixed; top: 0;" ng-if="perfil != null">
                <md-button href="<?=$urlAssets?>{{perfil[0].pe_site}}" class="md-fab md-fab-top-right" style="margin-top:-18px; stop: 5px; padding: 0;" >
                    <i class="fas fa-user" style="border-radius: 50%; width: 100%;" ng-if="perfil[0].pe_foto_perfil == null || perfil[0].pe_foto_perfil == ''"></i>
                    <img ng-src="{{perfil[0].pe_foto_perfil}}" class="md-avatar" style="border-radius: 50%; width: 100%;" ng-if="perfil[0].pe_foto_perfil != null || perfil[0].pe_foto_perfil != ''"/>
                </md-button>
            </div>

            <noscript>
                Para completa funcionalidade deste site é necessário habilitar o JavaScript.
                Aqui estão as <a href="https://www.enable-javascript.com/pt/">
                instruções de como habilitar o JavaScript no seu navegador</a>.
            </noscript>
           
            <div class="modal fade" id="app" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="app">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnAddApp" class="btn btn-primary">Instalar APP</button>
                    </div>
                    </div>
                </div>
            </div>


<?php
   
     if($route['page'] == ''){
       echo 'certo';
       //include_once "./resources/views/Splash.html";
     }

     if($route['page'] == 'ERRO 404'){
       
      }
     else if($route['page'] == 'estabelecimento'){
        
        //var_dump($route1);
        
        if(in_array('pc', $route1)){
        
            include_once "controller/estabelecimento/estabelecimento.php";
           echo 222;
        }else{

            $useragent=$_SERVER['HTTP_USER_AGENT'];
            if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
                
               include_once "controller/estabelecimento/estabelecimento.php";
            }else{
                echo '<script>
                    window.location.href = "https://zmsys.com.br/'.$estabelecimento.'";
                </script>';
            
            }
           
        }
        
         
        
     }else if($route['page'] == 'sacola'){
        include_once "controller/sacola/sacola.php";

     }
     else if($route['page'] == 'login'){
        include_once "controller/login/login.php";

     }

     else if($route['page'] == 'login_celular'){
        include_once "controller/login_celular/login_celular.php";
     }

     else if($route['page'] == 'verifica'){
        include_once "controller/verifica/verificaNumero.php";
     }

     else if($route['page'] == 'codigo'){
        //echo $_SESSION['cod'];
        include_once "controller/codigo/codigoNumero.php";
     }
     else if($route['page'] == 'codigo-verifica'){
        //echo $_SESSION['cod'];
        include_once "controller/codigo/codigo-verifica.php";
     }
     else if($route['page'] == 'endereco'){
        
        if ($route['subPage'] == 'cadastrar') {
            include_once "controller/endereco/cadEndereco.php";
        }

        else if($route['subPage'] == 'local_entrega'){
            include_once "controller/endereco/listaEndereco_entrega.php";
        }
        else if($route['subPage'] == 'lista'){
            include_once "controller/endereco/listaEndereco.php";
        }
        
     }

     else if($route['page'] == 'fPagamento'){
        include_once "controller/pagamento/fPagamento.php";
     }

     else if($route['page'] == 'perfil'){
        include_once "controller/perfil/perfil.php";
     }
     else if($route['page'] == 'meus_pedidos'){
        include_once "controller/meus_pedidos/meus_pedidos.php";
     }

     else if($route['page'] == 'criar-conta'){
        //$_SESSION['criarConta'] = true;
        if(!isset($_SESSION['criarConta'])){
            
        }
        
        include_once "controller/criar-conta/criar-conta.php";
     }

     else if($route['page'] == 'teste'){

        
        include_once "resources/views/teste.html";
       

        $final = "</body>
        </html>";
        echo $final;

     }
?>