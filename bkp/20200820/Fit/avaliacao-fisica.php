<?php

$Novo = false;
$Edicao = false;
$idacademia = 4;
$idaluno=0;
$carregado = false;
$ativarBotoes = false;

?>

<html lang="pt-br" ng-app="ZMFit" >
  
  <head>

    <title>ZM Fit - Personal</title>
    
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msapplication-square310x310logo" content="icon_largetile.png">
    
    <link rel="icon" href="https://zmfit.com.br/wp-content/uploads/2020/02/logo1-1.png" sizes="32x32" />
    <link rel="icon" href="https://zmfit.com.br/wp-content/uploads/2020/02/logo1-1.png" sizes="192x192" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap">
    <link rel="stylesheet" href="css/angular-material.css">
    <link rel="stylesheet" href="css/docs.css">
    <link rel="apple-touch-icon" href="ios-icon.png">
    <link rel="icon" sizes="192x192" href="icon.png">

    <script src="js/iframeConsoleRunner-dc0d50e60903d6825042d06159a8d5ac69a6c0e9bcef91e3380b17617061ce0f.js"></script>
    <script src="js/iframeRefreshCSS-d00a5a605474f5a5a14d7b43b6ba5eb7b3449f04226e06eb1b022c613eabc427.js"></script>
    <script src="js/iframeRuntimeErrors-29f059e28a3c6d3878960591ef98b1e303c1fe1935197dae7797c017a3ca1e82.js"></script>
    <script src="js/screenfull.min.js"></script>
    <style type="text/css">
      
      html, body {
         
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Baloo Chettan 2', cursive;

      }

      input {

        background: #80808032 !important;

      }

      md-divider {

        border-color: red !important;

      }

      md-progress-circular {

        height: 10em;
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);

      }

    </style>  

  </head>

  <body layout="column" ng-controller="ZMFitCtrl as ctrl" md-theme-watch md-theme="default" ng-cloak ng-init="carregando = true">

    <div layout="column" layout-align="space-around" ng-if="carregando">
      <md-progress-circular md-mode="indeterminate"></md-progress-circular>
    </div>
    
    <div ng-if="carregado">
<!--          <section layout="row" flex>-->
      <md-toolbar layout="row" class="layout-align-end-center layout-row" md-theme="site-toolbar">
        <div class="md-toolbar-tools">
          <md-button
            class="md-icon-button"
            aria-label="Configurações"
            ng-click="toggleSidenav('left')"
            hide-gt-sm>
            <md-icon md-svg-icon="img/icons/menu.svg"></md-icon>
          </md-button>
          <h2 flex="" md-truncate="">Avaliação Física</h2>
          <md-button
            class="md-icon-button"
            aria-label="Mais"
            ng-click="ctrl.showToolbarMenu($event, ctrl.more)">
            <md-icon md-svg-icon="img/icons/more_vert.svg"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
<!--        <md-backdrop class="md-sidenav-backdrop md-opaque ng-scope" ></md-backdrop>-->
      <div layout="row" flex>

        <md-sidenav layout="column" md-is-locked-open="$mdMedia('gt-sm')" md-component-id="left" class="md-sidenav-left md-whiteframe-z2">

          <md-toolbar md-theme="dark" class="md-hue-1 md-whiteframe-z2">
            <h1 class="md-toolbar-tools">ZM Fit</h1>
          </md-toolbar>

            <md-content layout-margin="">
              <p>Início</p>
              <p>Cadastros</p>
              <p>Avaliações</p>
              <p>Financeiro</p>
              <p>Treinos</p>
              <md-divider></md-divider>
              <p>Ajuda</p>
              <p>Sobre</p>

            </md-content>


        </md-sidenav>
      
        <md-content layout="column" flex class="md-padding">

          <div class="row">

            <md-input-container class="md-block" flex-gt-sm="">
              <label>Selecione um Cliente</label>
              <md-select ng-model="idaluno">
                <md-option ng-repeat="user in dadosAlunoSimplificado" value="{{user.idaluno}}" ng-bind="user.nome" ng-click="setarCliente(user.idaluno, user.genero, user.data_nascimento, user.matricula, user.email, user.celular)"></md-option>
              </md-select>
            </md-input-container>
            
            <div layout="row">

              <md-input-container flex-gt-sm>
                <label>Sexo</label>
                <input type="text" ng-value="genero">
              </md-input-container>
              <md-input-container flex-gt-sm>
                <label>Idade Atual</label>
                <input type="number" ng-value="idade">
              </md-input-container>
              <md-input-container flex-gt-sm>
                <label>Matrícula</label>
                <input type="number" ng-value="matricula">
              </md-input-container>

            </div>
            
            <div layout="row">

              <md-input-container flex-gt-sm>
                <label>E-mail</label>
                <input type="text" ng-value="email">
              </md-input-container>
              <md-input-container flex-gt-sm>
                <label>Celular</label>
                <input type="text" ng-value="celular">
              </md-input-container>

            </div>
            
            <md-button class="md-raised md-warn" ng-click="buscaAvaliacaoSimplificada(idaluno)">Consultar</md-button>

            <md-button class="md-raised md-primary" ng-click="Novo = true && Edicao = false">Nova</md-button>

          </div>

<!--
            OPÇÃO DE CONSULTAR OU ALTERAR AVALICAO FISICA
-->
          <div class="row " ng-if="Edicao">
            
            <md-divider></md-divider>
              
            <div class="row">
              
              <md-input-container class="md-block" flex-gt-sm>
                <label>Escolha a avaliação</label>
                <md-select ng-model="idavaliacao_fisica" required >
                  <md-option ng-repeat="dados in dadosAvaliacaoSimplificada" value="{{dados.idavaliacao_fisica}}" ng-click="setarAvaliacao(dados.numero_avaliacao, dados.data, dados.idade_atual, dados.peso_atual, dados.altura, dados.protocolo, dados.idavaliacao_fisica)"><span ng-bind="dados.idavaliacao_fisica"></span> - Realizada em <span ng-bind="dados.data|date:'dd/MM/yyyy'"></span></md-option>
                </md-select>
              </md-input-container>

              <div layout="row">
             
                <md-input-container  flex-gt-sm=20>
                  <label>Número Avaliação</label>
                  <input type="number" ng-value="numero_avaliacao">
                </md-input-container>    

                <md-input-container  flex-gt-sm=40>
                  <label>Data da Avaliação</label>
                  <input type="date" ng-value="data_avaliacao">
                </md-input-container>    

                <md-input-container  flex-gt-sm=20>
                  <label>Idade</label>
                  <input type="number" ng-value="idade_atual">
                </md-input-container>

                <md-input-container  flex-gt-sm=20>
                  <label>Peso</label>
                  <input type="number" ng-value="peso_atual">
                </md-input-container>    

              </div>

              <div layout="row">

                <md-input-container  flex-gt-sm=30>
                  <label>Altura</label>
                  <input type="number" ng-value="altura">
                </md-input-container>

                <md-input-container  flex-gt-sm=70>
                  <label>Protocolo</label>
                  <input type="text" ng-value="protocolo">
                </md-input-container>

              </div>

            </div>

            <div layout="row">

              <div class="tabsdemoDynamicTabs" flex ng-repeat="avaliacao in dadosAvaliacao">

                <md-tabs md-dynamic-height="" md-selected="selectedIndex" md-border-bottom="" md-autoselect="" md-swipe-content="" flex>

                  <md-tab label="Dobras Cutâneas">
                    <div class="demo-tab tab[0]">
                      <label>Espessuras em milímetros (mm)</label>
                      <div layout="row">
                        <md-input-container flex >
                          <label>Bíceps</label>
                          <input type="number" ng-value="avaliacao.biceps_media"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Tríceps</label>
                          <input type="number" ng-value="avaliacao.triceps_media"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Tórax</label>
                          <input type="number" ng-value="avaliacao.torax_media"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Subescapular</label>
                          <input type="number" ng-value="avaliacao.subescapular_media"></input>
                        </md-input-container>
                      </div>
                      <div layout="row">
                        <md-input-container flex >
                          <label>Axilar Média</label>
                          <input type="number" ng-value="avaliacao.axilar_media_media"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Supra Ilíaca</label>
                          <input type="number" ng-value="avaliacao.supra_iliaca_media"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Abdominal</label>
                          <input type="number" ng-value="avaliacao.abdominal_media"></input>
                        </md-input-container>
                      </div>
                      <div layout="row">
                        <md-input-container flex >
                          <label>Coxa Medial</label>
                          <input type="number" ng-value="avaliacao.coxa_medial_media"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Panturrilha Medial</label>
                          <input type="number" ng-value="avaliacao.pantu_medial_media"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Supra Espinal</label>
                          <input type="number" ng-value="avaliacao.supra_espinal_media"></input>
                        </md-input-container>                          
                      </div>                        
                    </div>
                  </md-tab>

                  <md-tab label="Diâmetros">
                    <div class="demo-tab tab[1]">
                      <label>Valores em centímetros (cm)</label>
                      <div layout="row">
                        <md-input-container flex >
                          <label>Biestilóide</label>
                          <input type="number" ng-value="avaliacao.biestiloide"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Bimaleolar</label>
                          <input type="number" ng-value="avaliacao.bimaleolar"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Biepicôndilo Umeral</label>
                          <input type="number" ng-value="avaliacao.biepicondilo_umeral"></input>
                        </md-input-container>
                      </div>
                      <div layout="row">
                        <md-input-container flex >
                          <label>Biepicôndilo Femural</label>
                          <input type="number" ng-value="avaliacao.biepicondilo_femural"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Biacromial</label>
                          <input type="number" ng-value="avaliacao.biacromial"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Tórax Ântero-Posterior</label>
                          <input type="number" ng-value="avaliacao.torax_antero_posterior"></input>
                        </md-input-container>
                      </div>
                      <div layout="row">
                        <md-input-container flex >
                          <label>Tórax Transverso</label>
                          <input type="number" ng-value="avaliacao.torax_transverso"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Crista Ilíaca</label>
                          <input type="number" ng-value="avaliacao.crista_iliaca"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Bitrocantérica</label>
                          <input type="number" ng-value="avaliacao.bitrocanterica"></input>
                        </md-input-container>                        
                      </div>
                    </div> 
                  </md-tab>

                  <md-tab label="Perímetros">
                    <div class="demo-tab tab[2]">
                      <label>Valores em centímetros (cm)</label>
                      <div layout="row">
                        <md-input-container flex >
                          <label>Pescoço</label>
                          <input type="number" ng-value="avaliacao.pescoço"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Ombro</label>
                          <input type="number" ng-value="avaliacao.ombro"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Tórax Relaxado</label>
                          <input type="number" ng-value="avaliacao.torax"></input>
                        </md-input-container>
                      </div>
                      <div layout="row">
                        <md-input-container flex >
                          <label>Tórax Inspirado</label>
                          <input type="number" ng-value="avaliacao.toraxInspirado"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Cintura</label>
                          <input type="number" ng-value="avaliacao.cintura"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Abdomen</label>
                          <input type="number" ng-value="avaliacao.abdominal"></input>
                        </md-input-container>

                        <md-input-container flex >
                          <label>Quadril</label>
                          <input type="number" ng-value="avaliacao.quadril"></input>
                        </md-input-container>                          
                      </div>
                      <div layout="row">
                          <label>Braço Relaxado</label>
                        <md-input-container flex >
                          <label>Esquerdo</label>
                          <input type="number" ng-value="avaliacao.braco_esquerdo_relaxado"></input>
                        </md-input-container>
                        <md-input-container flex >
                          <label>Direito</label>
                          <input type="number" ng-value="avaliacao.braco_direito_relaxado"></input>
                        </md-input-container>
                      </div>
                      <md-divider></md-divider>
                      <div layout="row">
                          <label>Braço Contraído</label>
                        <md-input-container flex >
                          <label>Esquerdo</label>
                          <input type="number" ng-value="avaliacao.braco_esquerdo_contraido"></input>
                        </md-input-container>                        
                        <md-input-container flex >
                          <label>Direito</label>
                          <input type="number" ng-value="avaliacao.braco_direito_contraido"></input>
                        </md-input-container>                        
                      </div>
                      <md-divider></md-divider>
                      <div layout="row">
                          <label>Antebraço</label>
                        <md-input-container flex >
                          <label>Esquerdo</label>
                          <input type="number" ng-value="avaliacao.antebraco_esquerdo"></input>
                        </md-input-container>                        
                        <md-input-container flex >
                          <label>Direito</label>
                          <input type="number" ng-value="avaliacao.antebraco_direito"></input>
                        </md-input-container>                        
                      </div>
                      <md-divider></md-divider>
                      <div layout="row">
                          <label>Coxa</label>
                        <md-input-container flex >
                          <label>Esquerdo</label>
                          <input type="number" ng-value="avaliacao.coxa_esquerda"></input>
                        </md-input-container>                        
                        <md-input-container flex >
                          <label>Direito</label>
                          <input type="number" ng-value="avaliacao.coxa_direita"></input>
                        </md-input-container>                        
                      </div>
                      <md-divider></md-divider>
                      <div layout="row">
                          <label>Panturrilha</label>
                        <md-input-container flex >
                          <label>Esquerdo</label>
                          <input type="number" ng-value="avaliacao.perna_esquerda"></input>
                        </md-input-container>                        
                        <md-input-container flex >
                          <label>Direito</label>
                          <input type="number" ng-value="avaliacao.perna_direita"></input>
                        </md-input-container>                        
                      </div>                        
                    </div>
                  </md-tab>

                  <md-tab label="Anamnese">
                    <div class="demo-tab tab[3]">
                      <label>Questionário</label>
                      <div layout="row">        
                        <md-input-container flex>
                          <label>Qual sua meta com a prática de atividade física?</label>
                          <input type="text" ng-value="avaliacao.meta"></input>
                        </md-input-container>
                      </div>
                      <md-divider></md-divider>
                      <div layout="row">
                        <md-input-container flex>
                          <label>Pratica ou já praticou alguma atividade física?</label>
                          <input type="text" ng-value="avaliacao.praticaExercicios"></input>
                        </md-input-container>
                        <md-input-container flex>
                          <label>Atividade</label>
                          <input type="text" ng-value="avaliacao.praticaExercicios_quais"></input>
                        </md-input-container>                            
                        <md-input-container flex>
                          <label>Frequência Semanal</label>
                          <input type="number" ng-value="avaliacao.praticaExercicios_frequencia"></input>
                        </md-input-container>
                      </div>
                      <md-divider></md-divider>                        
                      <div layout="row">                          
                        <md-input-container flex>
                          <label>Tem ou teve o hábito de fumar?</label>
                          <input type="text" ng-value="avaliacao.habitoFumar"></input>
                        </md-input-container>
                        <md-input-container flex>
                          <label>Tempo</label>
                          <input type="text" ng-value="avaliacao.habitoFumar_tempo"></input>
                        </md-input-container>                            
                        <md-input-container flex>
                          <label>Cigarros por dia</label>
                          <input type="number" ng-value="avaliacao.habitoFumar_qtd_dia"></input>
                        </md-input-container>
                      </div>
                      <md-divider></md-divider>                                                
                      <div layout="row">                          
                        <md-input-container flex>
                          <label>Possui restrições à atividades físicas?</label>
                          <input type="text" ng-value="avaliacao.restricoesAtividades"></input>
                        </md-input-container>                        
                      </div>
                      <md-divider></md-divider>                                                
                      <div layout="row">                          
                        <md-input-container flex>
                          <label>Utiliza algum medicamento?</label>
                          <input type="text" ng-value="avaliacao.utilizaMedicamento"></input>
                        </md-input-container>                        
                      </div>
                      <md-divider></md-divider>                                                
                      <div layout="row">                          
                        <md-input-container flex>
                          <label>Sente dores no corpo?</label>
                          <input type="text" ng-value="avaliacao.senteDores"></input>
                        </md-input-container>                        
                      </div>
                      <md-divider></md-divider>                                                
                      <div layout="row">                          
                        <md-input-container flex>
                          <label>Sofreu algum acidente osteo-muscular recentemente?</label>
                          <input type="text" ng-value="avaliacao.sofreuAcidente"></input>
                        </md-input-container>                        
                      </div>
                      <md-divider></md-divider>                                                
                      <div layout="row">                          
                        <md-input-container flex>
                          <label>Está em dieta para ganhar ou perder peso?</label>
                          <input type="text" ng-value="avaliacao.estaemDieta"></input>
                        </md-input-container>                        
                      </div>
                      <md-divider></md-divider>                                                
                      <div layout="row">                          
                        <md-input-container flex>
                          <label>Possui algum tipo de alergia?</label>
                          <input type="text" ng-value="avaliacao.possuiAlergia"></input>
                        </md-input-container>                        
                      </div>
                    </div>
                  </md-tab>

                  <md-tab label="Teste Abdominal">
                    <div class="demo-tab tab[4]">
                      <label>Informações na Tabela</label>
                      <div layout="row">
                        <md-card flex>
                          <img ng-src="images/FazerAbdominal.jpeg" class="md-card-image" alt="Washed Out">
                          <img ng-src="images/TesteAbdominaisMulheres.png" class="md-card-image" alt="Washed Out" ng-if="genero == 'Feminino'">
                          <img ng-src="images/TesteAbdominaisHomens.png" class="md-card-image" alt="Washed Out" ng-if="genero == 'Masculino'">
                          <md-card-content>
                            <label>Quantidade de Abdominais</label>
                            <input type="number" ng-value="avaliacao.teste_abdominal"></input>
                          </md-card-content>
                        </md-card>                        
                      </div>
                    </div>
                  </md-tab>
                  
                  <md-tab label="Flexão de Braço">
                    <div class="demo-tab tab[5]">
                      <label>Informações na Tabela</label>
                      <div layout="row">
                        <md-card flex>
                          <img ng-src="images/FazerFlexao.jpeg" class="md-card-image" alt="Washed Out">
                          <img ng-src="images/TesteAbdominaisMulheres.png" class="md-card-image" alt="Washed Out" ng-if="genero == 'Feminino'">
                          <img ng-src="images/TesteAbdominaisHomens.png" class="md-card-image" alt="Washed Out" ng-if="genero == 'Masculino'">
                          <md-card-content>
                            <label>Quantidade de Flexões</label>
                            <input type="number" ng-value="avaliacao.teste_flexao_braco"></input>
                          </md-card-content>
                        </md-card>                        
                      </div>
                    </div>
                  </md-tab>

                  <md-tab label="Sentar e Alcançar">
                    <div class="demo-tab tab[6]">
                      <label>Informações na Tabela</label>
                      <div layout="row">
                        <md-card flex>
                          <img ng-src="images/FazerSentarAlcancar.jpeg" class="md-card-image" alt="Washed Out">
                          <img ng-src="images/TesteSentarAlcancarMulheres.png" class="md-card-image" alt="Washed Out" ng-if="genero == 'Feminino'">
                          <img ng-src="images/TesteSentarAlcancarHomens.png" class="md-card-image" alt="Washed Out" ng-if="genero == 'Masculino'">
                          <md-card-content>
                            <label>Centímetros Alcançados</label>
                            <input type="number" ng-value="avaliacao.teste_sentar_alcancar"></input>
                          </md-card-content>
                        </md-card>                        
                      </div>
                    </div>
                  </md-tab>

                  <md-tab label="Observações">
                    <div class="demo-tab tab[0]">
                      <label>Informe suas observações</label>
                      <div layout="row">
                        <md-input-container flex>
                          <br>
                          <br>
                          <br>
                          <br>
                          <input type="text" ng-value="avaliacao.observacoes" aria-label="Observações"></input>
                        </md-input-container>                        
                      </div>
                    </div>
                  </md-tab>
                </md-tabs>
              </div>
            </div>


            <div layout = "row" layout-align="top center" ng-if="Novo1">

              <section layout="row" layout="column">

                <md-datepicker required ng-model="dataAvaliacao" md-placeholder="Informe a Data"></md-datepicker>
                <md-select required type="text" ng-model="user.idaluno" md-placeholder="Informe a Data">
                  <md-option ng-repeat="user in dadosAlunoSimplificado" value="{{user.idaluno}}" ng-bind="user.nome" ></md-option>
                </md-select>

              </section>

              <section layout="row" layout="column" layout-wrap>

                <md-input-container flex>
                <label>Sexo</label>                
                  <md-select required type="text" step="any" name="rate" ng-model="user.genero">
                    <md-option value="F">Feminino</md-option>
                    <md-option value="M">Masculino</md-option>
                  </md-select>
                </md-input-container>                    

                <md-input-container flex>
                  <label>Idade</label>
                  <input required type="number" step="any" name="rate" ng-model="user.idade">
                </md-input-container>

                <md-input-container flex>
                  <label>Peso</label>              
                  <input required type="number" step="any" name="rate" ng-model="user.peso">
                </md-input-container>

                <md-input-container flex>
                  <label>Altura</label>                
                  <input required type="number" step="any" name="rate" ng-model="user.altura">
                </md-input-container>

              </section>

              <div layout="row">

                <md-input-container flex>
                  <label>Protocolo</label>
                  <input ng-model="avaliacao.protocolo">
                </md-input-container>
              </div>
            </div>
          </div>
        </md-content>
      </div>
    </div>

    <script src="js/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>
    <script src="js/angular/angular.js"></script>
    <script src="js/angular/angular-animate.min.js"></script>
    <script src="js/angular/angular-route.min.js"></script>
    <script src="js/angular/angular-aria.min.js"></script>
    <script src="js/angular/angular-messages.min.js"></script>
    <script src="js/angular/moment.js"></script>
    <script src="js/angular/svg-assets-cache.js"></script>
    <script src="js/angular/angular-material.js"></script>
    <script type="text/javascript">

      angular.

      module('ZMFit', ['ngMaterial', 'ngMessages', 'material.svgAssetsCache']).
      
      config(function($mdThemingProvider){
        $mdThemingProvider.enableBrowserColor({
          theme: 'default',
          palette: 'grey'});
        $mdThemingProvider.theme('default')
          .primaryPalette('grey',{
          'default': '900'})
          .accentPalette('grey',{
          'default': '700'})
          .backgroundPalette('grey',{
          'default': '50'})
//          .dark()
        $mdThemingProvider.alwaysWatchTheme(true);

          ;


//          .primaryPalette('indigo')
//          .dark();
      }).

      controller('ZMFitCtrl', ZMFitCtrl);

      $scope.appname = "ZM Fit - Cliente";
      $scope.caminhoVideo="../AcademiaNova/videos/";
      $scope.dadosAluno=[];
      $scope.dadosAvaliacao=[];
      $scope.dadosAvaliacaoSimplificada=[];
      $scope.resultado=[];
      $scope.actve=1;

      var edicao = false;

      var state='C';
      var ativo="S";


      function ZMFitCtrl($scope, $http, $timeout, $mdSidenav) {


        $scope.toggleSidenav = function (menuId) {
            $mdSidenav(menuId).toggle();
        };


        document.documentElement.requestFullscreen();


        var dadosAlunoSimplificado = function (){
          $http({
            method: 'GET',
            url: 'services/alunos.php?dadosAlunoSimplificado=S&idacademia='+<?=$idacademia?>
            }).then(function onSuccess(response){
            $scope.dadosAlunoSimplificado=response.data.result[0];
//            alert("entrou");
            mudarVisibilidade();
            }).catch(function onError(response){
            $scope.resultado=response.data;
            alert("Erro ao carregar seus treinos. Caso este erro persista, contate o suporte.");              
    //        alert("idtreinoAluno");
          });
        }

        dadosAlunoSimplificado()


        var buscaAvaliacao = function(idavaliacao){
           $http({
            method: 'GET',
            url: 'services/busca_avaliacao.php?buscaAvaliacao=S&idavaliacao='+idavaliacao
          }).then(function onSuccess(response){
            $scope.dadosAvaliacao=response.data.result[0];
            if ($scope.dadosAvaliacao == "") {alert("Não há avaliações realizadas para este cliente.")};
          }).catch(function onError(response){
            $scope.resultado=response.data;
            alert("Erro ao carregar avaliações. Caso este erro persista, contate o suporte.");
          });
        }

        $scope.buscaAvaliacaoSimplificada = function(idaluno){
           //alert('entrou',);
           $http({
            method: 'GET',
            url: 'services/busca_avaliacao.php?buscaAvaliacaoSimplificada=S&idaluno='+idaluno
          }).then(function onSuccess(response){
            $scope.Novo = false;
            $scope.Edicao = true;
            $scope.dadosAvaliacaoSimplificada=response.data.result[0];
            if ($scope.dadosAvaliacaoSimplificada == "") {$scope.Edicao = false; alert("Não há avaliações realizadas para este cliente.");};
          }).catch(function onError(response){
            $scope.resultado=response.data;
            alert("Erro ao carregar avaliações. Caso este erro persista, contate o suporte.");
          });
        }


        $scope.dobraCutanea = [
          {nomeDB: 'avaliacao.biceps_media', descricao: "Bíceps" },
          {nomeDB: 'avaliacao.triceps_media', descricao: "Tríceps" },
          {nomeDB: 'avaliacao.torax_media', descricao: "Tórax" },
          {nomeDB: 'avaliacao.subescapular_media', descricao: "Subescapular" },
          {nomeDB: 'avaliacao.axilar_media_media', descricao: "Axilar Média" },
          {nomeDB: 'avaliacao.supra_iliaca_media', descricao: "Supra Ilíaca" },
          {nomeDB: 'avaliacao.abdominal_media', descricao: "Abdominal" },
          {nomeDB: 'avaliacao.coxa_medial_media', descricao: "Coxa Medial" },
          {nomeDB: 'avaliacao.pantu_medial_media', descricao: "Panturrilha Medial" },
          {nomeDB: 'avaliacao.supra_espinal_media', descricao: "Supra Medial" }
        ];

        $scope.diametros = [
          {nomeDB: 'avaliacao.biestiloide', descricao: "Biestilóide" },
          {nomeDB: 'avaliacao.bimaleolar', descricao: "Bimaleolar" },
          {nomeDB: 'avaliacao.biepicondilo_umeral', descricao: "Biepicôndilo Umeral" },
          {nomeDB: 'avaliacao.biepicondilo_Femural', descricao: "Biepicôndilo Femural" },
          {nomeDB: 'avaliacao.biacromial', descricao: "Biacromial" },
          {nomeDB: 'avaliacao.torax_antero_posterior', descricao: "Tórax Ântero Posterior" },
          {nomeDB: 'avaliacao.torax_transverso', descricao: "Tórax Transverso" },
          {nomeDB: 'avaliacao.crista_iliaca', descricao: "Crista Ilíaca" },
          {nomeDB: 'avaliacao.bitrocanterica', descricao: "Bitrocantérica" }
        ];

        $scope.perimetros = [
          {nomeDB: 'avaliacao.pescoco', descricao: "Pescoço" },
          {nomeDB: 'avaliacao.ombro', descricao: "Ombro" },
          {nomeDB: 'avaliacao.torax', descricao: "Tórax Relaxado" },
          {nomeDB: 'avaliacao.toraxInspirado', descricao: "Tórax Inspirado" },
          {nomeDB: 'avaliacao.cintura', descricao: "cintura" },
          {nomeDB: 'avaliacao.abdominal', descricao: "Abdomem" },
          {nomeDB: 'avaliacao.quadril', descricao: "Quadril" },
          {nomeDB: 'avaliacao.braco_direito_relaxado', descricao: "Braço Relaxado - Lado Direito" },
          {nomeDB: 'avaliacao.braco_esquerdo_relaxado', descricao: "Braço Relaxado - Lado Esquerdo" },
          {nomeDB: 'avaliacao.braco_direito_contraido', descricao: "Braço Contraído - Lado Direito" },
          {nomeDB: 'avaliacao.braco_esquerdo_contraido', descricao: "Braço Contraído - Lado Esquerdo" },
          {nomeDB: 'avaliacao.antebraco_direito', descricao: "Antebraço - Lado Direito" },
          {nomeDB: 'avaliacao.antebraco_esquerdo', descricao: "Antebraço - Lado Esquerdo" },
          {nomeDB: 'avaliacao.coxa_direita', descricao: "Coxa - Lado Direito" },
          {nomeDB: 'avaliacao.coxa_esquerda', descricao: "Coxa - Lado Esquerdo" },       
          {nomeDB: 'avaliacao.perna_direita', descricao: "Perna - Lado Direito" },
          {nomeDB: 'avaliacao.perna_esquerda', descricao: "Perna - Lado Esquerdo" }
        ];

        var tabs = [
          {id: 0, title: 'Dobras Cutâneas', content: "Espessuras em milímetros (mm)"},
          {id: 1, title: 'Diâmetros', content: "Valores em centímetros (cm)"},
          {id: 2, title: 'Perímetros', content: "Valores em centímetros (cm)"},
          {id: 3, title: 'Anamnese', content: "Questionário"},
          {id: 4, title: 'Teste Abdominal', content: "Informações na Tabela"},
          {id: 5, title: 'Flexão de Braço', content: "Informações na Tabela"},
          {id: 6, title: 'Sentar e Alcançar', content: "Informações na Tabela"},
          {id: 8, title: 'Observações', content: "Informe suas observações"}
        ],

        selected = null,
        previous = null;
        $scope.tabs = tabs;
        $scope.selectedIndex = 0;
        $scope.$watch('selectedIndex', function(newVal, oldVal) {
          previous = selected;
          selected = tabs[newVal];
          if (oldVal + 1 && !angular.equals(oldVal, newVal)) {
            $log.log('Tchau ' + previous.title + '!');
          }
          if (newVal + 1 > 0) {
            $log.log('Oi ' + selected.title + '!');
          }
        });

        var mudarVisibilidade = function() {

          $scope.carregando = false;
          $scope.carregado = true;

        }



        $scope.setarCliente = function(idaluno,genero,idade,matricula,email,celular){

          $scope.Novo = false;
          $scope.Edicao = false;           

          $scope.idaluno = "";
          $scope.genero = "";
          $scope.idade = "";
          $scope.matricula = "";
          $scope.celular = "";
          $scope.email = "";
          $scope.numero_avaliacao = "";
          $scope.data_avaliacao = "";
          $scope.idade_atual = "";
          $scope.peso_atual = "";
          $scope.altura = "";
          $scope.protocolo = "";


          $scope.idaluno = idaluno;
          $scope.genero = genero;
          $scope.idade = idade;
          $scope.matricula = matricula;
          $scope.celular = celular;
          $scope.email = email;
        }



        $scope.setarAvaliacao= function(numero_avaliacao, data_avaliacao, idade_atual, peso_atual, altura, protocolo, idavaliacao_fisica){

          $scope.numero_avaliacao = numero_avaliacao;
          $scope.data_avaliacao = data_avaliacao;
          $scope.idade_atual = idade_atual;
          $scope.peso_atual = peso_atual;
          $scope.altura = altura;
          $scope.protocolo = protocolo;
          buscaAvaliacao(idavaliacao_fisica);

        }




      };

 
    </script>

  </body>

</html>
