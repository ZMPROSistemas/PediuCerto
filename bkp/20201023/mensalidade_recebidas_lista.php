<?php
include 'var-inicio.php';
include 'conecta.php';
include 'busca-dados-login.php';
include 'cabecalho.php';

date_default_timezone_set('America/Bahia');

$idacademia = $dados_usuario['academia'];

$data = date("d/m/Y H:i:s");

?>

<script>
  angular.module("AppMegaTreino",["ngMessages","angularUtils.directives.dirPagination"]);
  angular.module("AppMegaTreino").controller("AppMegaTreinoCtrl",function ($scope, $http) {
    // body...
    $scope.currentPage = 1;
    $scope.pageSize = 20;
    $scope.dados = [];
    $scope.alunos = [];
    $scope.turma = [];
    $scope.total = [];
    $scope.dataI = dataHoje();
    $scope.dataF = dataHoje();
    //$scope.idade = s();
  
    $scope.company="Grupo Brasil Mobile";
    //$scope.urlBase="http://localhost/novo%20mega%20treino/services/";
    $scope.urlBase="https://www.megatreino.com.br/AcademiaNova/services/";

    //$scope.cont = 0;

    var state='C';
    var totalT=0;
   
    //$scope.hoje=new Date();

    $scope.ordenar = function(keyname){
      $scope.sortKey = keyname;
      $scope.reverse = !$scope.reverse;
    };

    var carregaDados = function function_name(dataI,dataF){

      $http({
        method: 'GET',
        url: $scope.urlBase+'pagarReceber_relatorio.php?id='+<?=$idacademia?>+'&state='+state
      }).then(function onSuccess(response){
        $scope.dados=response.data.result[0];
      }).catch(function onError(response){
        $scope.resultado=response.data.result[0];
      });
    }

    carregaDados();    

    var carregaDadosModalidade = function function_name(){
      $http({
        method: 'GET',
        url: $scope.urlBase+'modalidade.php?id='+<?=$idacademia?>+'&state='+state
      }).then(function onSuccess(response){
        $scope.modalidades=response.data.result[0];
      }).catch(function onError(response){
        $scope.resultado=response.data.result[0];
      });
    }

    carregaDadosModalidade();

    var carregaProfessores = function function_name(){
      $http({
        method: 'GET',
        url: $scope.urlBase+'professores.php?id='+<?=$idacademia?>+'&state='+state
      }).then(function onSuccess(response){
        $scope.professores=response.data.result[0];
      }).catch(function onError(response){
        $scope.resultado=response.data.result[0];
      });
    }

    carregaProfessores();

     var carregaDadosTurma = function function_name(){
      $http({
        method: 'GET',
        url: $scope.urlBase+'turmas.php?id='+<?=$idacademia?>+'&state='+state
      }).then(function onSuccess(response){
        $scope.turma=response.data.result[0];
      }).catch(function onError(response){
        $scope.resultado=response.data.result[0];
      });
    }

    carregaDadosTurma();

    var carregaFormaDePagamento = function function_name(){
      $http({
        method: 'GET',
        url: $scope.urlBase+'forma_de_pagamento_lista.php?id='+<?=$idacademia?>+'&state='+state
      }).then(function onSuccess(response){
        $scope.formaPagamento=response.data.result[0];
      }).catch(function onError(response){
        $scope.resultado=response.data.result[0];
      });
    }
    carregaFormaDePagamento();

    var carregaDadosTotais = function function_name(){
      $http({
        method: 'GET',
        url: $scope.urlBase+'pagarReceber_relatorio_total.php?id='+<?=$idacademia?>+'&state='+state
      }).then(function onSuccess(response){
        $scope.total=response.data.result[0];
      }).catch(function onError(response){
        $scope.resultado=response.data.result[0];
      });
    }
    carregaDadosTotais();

    $scope.busca = function(dataI,dataF){
     // alert('entrou');

       $http({
        method: 'GET',
        url: $scope.urlBase+'pagarReceber_relatorio.php?id='+<?=$idacademia?>+'&state='+state+'&dataI='+dataI+'&dataF='+dataF
      }).then(function onSuccess(response){
        $scope.dados=response.data.result[0];
      }).catch(function onError(response){
      
      });

       $http({
        method: 'GET',
        url: $scope.urlBase+'pagarReceber_relatorio_total.php?id='+<?=$idacademia?>+'&state='+state+'&dataI='+dataI+'&dataF='+dataF
      }).then(function onSuccess(response){
        $scope.total=response.data.result[0];
      }).catch(function onError(response){
        
      });
  }
    
    function dataHoje(soma=0) {
            var data = new Date();
            data.setDate(data.getDate() );
            var dia = data.getDate();
            var mes = data.getMonth()+1;
            var ano = data.getFullYear();
            if (dia<=9){
              dia='0'+dia;
            }
            if (mes<=9){
              mes='0'+mes;
            }
            //return [dia, mes, ano].join('/');

            return [ano, mes, dia].join('-');
    }
 
});


</script>

<style type="text/css">
  .table th{background-color: }
  .relatorio {display: none;}
  .pesquisa{margin-right: -20px;}
  .lg{width: 100%;}
  select{margin-left:3px;}
  .th{font-weight: bold; align-items: center;}

  @media print {
    .relatorio{display: block;}
    .no-print{display: none;}
    td{font-size: 12px !important; height: 4px !important; padding: 0 !important;}
    tr:nth-child(even) td:nth-child(odd){background-color:#BEBDBD !important; }
    tr:nth-child(even) td:nth-child(even){background-color:#BEBDBD !important; }
  }

</style>

<div>
  <div class="content-wrapper">
  <!-- Cabeçalho da Página -->
    <section class="content-header">
      <h1>
        Mensalidades Recebidas
        <small>Listagem</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
        <li class="active">Mensalidades Recebidas</li>
      </ol>
    </section>
    <!-- Conteúdo Principal -->
    <section class="content"  ng-controller="AppMegaTreinoCtrl">
      <div class="row">
        <div class="col-md-12">
          <!-- Cabeçalho do Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="row">
                <div class="col-md-3 pesquisa" >
                  <label for="professor" class="no-print">Por Professor</label>
                  <select id="professor" name="professor" class="form-control no-print" ng-model="filtrar.professor" >
                    <option value="">Todos os Professores</option>
                    <option ng-repeat="option in professores" value="{{option.idcolaborador}}">{{option.nomecolaborador}}</option>
                  </select>
                </div>
                <div class="col-md-3 pesquisa">
                  <label for="modalidade" class="no-print">Por Modalidade</label>
                  <select id="modalidade"  name="modalidade" class="form-control no-print" ng-model="filtrar.historico" >
                    <option value="">Todas as Modalidades</option>
                    <option ng-repeat="option in modalidades" value="{{option.nome}}">{{option.nome}}</option>
                  </select>
                </div>
                <div class="col-md-3 pesquisa">
                  <label for="pagamento" class="no-print">Por pagamento</label>
                  <select id="pagamento" name="pagamento" class="form-control no-print" ng-model="filtrar.canc" ng-click= "busca(dataI | date:'yyyy-MM-dd',dataF | date:'yyyy-MM-dd')">
                    <option value="">Todas os Pagamentos</option>
                    <option ng-repeat="option in formaPagamento" value="{{option.sigla}}" ng-if="option.descricao != 'BOLETO'" >{{option.descricao}}</option>
                  </select>
                </div>
                <div class="col-md-3 pesquisa" >
                  <label for="turma" class="no-print">Por Turma</label>
                  <select id="turma" name="turma" class="form-control no-print" ng-model="filtrar.turma" disabled>
                    <option value="">Todas as Turmas</option>
                    <option ng-repeat="option in turma" value="{{option.nome}}">{{option.nome}}</option>
                  </select>
                </div>
                <div class="col-md-3 pesquisa">
                  <label for="" class="no-print">Emitidas de </label>
                  <input id="DataInicial" type="date" class="form-control no-print" ng-model="dataI" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-3 pesquisa">
                  <label for="" class="no-print">Até</label>
                  <input id="DataFinal" type="date" class="form-control no-print" ng-model="dataF" value="<?php echo date('Y-m-d'); ?>">
                </div>                
                <div class="col-md-3">
                  <label for=" "></label>
                    <button class="btn btn-success no-print" ng-click= "busca(dataI | date:'yyyy-MM-dd',dataF | date:'yyyy-MM-dd')" style="margin-left: 5px; position: relative; top: 25px;"><i class="fa fa-search"></i> Buscar</button>
                    <label for=""></label> 
                    <button onclick="gerarpdf()"; class="btn btn-primary no-print" ng-value="Print this page" style="margin-left: 15px; position: relative; top: 25px"><i class="fa fa-print"></i> Imprimir</button>
                </div>
              </div>
            </div>
            <!--<form role="form"> -->
            <div class="box-body">
              <div>
                <table id="tabela" class="table table-bordered table-striped no-print" >
                  <thead>
                    <tr>
                      <th ng-click="ordenar('matricula')">Matricula</th>
                      <th ng-click="ordenar('nome')">Aluno</th>
                      <th ng-click="ordenar('historico')">Histórico</th>
                      <th ng-click="ordenar('pagamento')">Data Pagto</th>
                      <th ng-click="ordenar('valpago')">Valor Pago</th>
                    </tr>
                  </thead>
                  <tbody ng-repeat="_ in [ [filtrar, dados] ]" ng-init="total = 0">
                    <tr ng-repeat="linha in dados | filter: filtrar | orderBy:sortKey:reverse" >
                      <td>{{linha.matricula}}</td>
                      <td>{{linha.nome}}</td>
                      <td>{{linha.historico}}</td>
                      <td>{{linha.pagamento|date:'dd/MM/yyyy'}}</td>
                      <td>{{linha.valpago}}</td>              
                    </tr>
                  </tbody>
                </table>
              </div>
              <div>
                <table id="tabela2" style="left: 650px; width: 200px; "class="table table-bordered table-striped no-print" >
                  <thead>
                    <tr>
                      <th><b>Resumo</b></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody ng-repeat="_ in [ [filtrar, total] ]">
                    <tr ng-repeat="linha in total | filter: filtrar" >
                      <td>
                        <span ng-if="linha.canc == 'DN'" >Dinheiro</span>
                        <span ng-if="linha.canc == 'CH'" >Cheque</span>
                        <span ng-if="linha.canc == 'CT'" >Cartão</span>
                        <span ng-if="linha.canc == 'SV'" >Serviços</span>
                        <span ng-if="linha.canc == 'PZ'" >Boleto</span>
                        <span ng-if="linha.canc == 'REC'">Recorrente</span>
                      </td>
                      <td ng-init="$parent.totalT = $parent.totalT ++ linha.total">{{linha.total | currency:"R$ "}}</td>
                    </tr>
                    <tr>
                      <th><b>Total</b></th>
                      <th><b>{{totalT | currency:"R$ "}}</b></th>
                    </tr>                    
                  </tbody>
                </table>                
              </div>
              <dir-pagination-controls max-size="7" boundary-links="true" class="no-print"></dir-pagination-controls>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<script src="js/jspdf.min.js"></script>
<script src="js/jspdf.plugin.autotable.js"></script>
<script>

  function gerarpdf() {    
    
    var LogoAcademia = new Image();
    LogoAcademia.src = 'logo_academia/<?=$idacademia?>/<?=$idacademia?>.gif';

    var doc = new jsPDF('p', 'pt', 'a4');
      
    var data1 = doc.autoTableHtmlToJson(document.getElementById("tabela")); 
    var rows = data1.rows;
//    rows.splice(0,1);

    var ModalidadeT = document.getElementById('modalidade').options[document.getElementById('modalidade').selectedIndex].innerText;
    var TurmaT = document.getElementById('turma').options[document.getElementById('turma').selectedIndex].innerText;
    var ProfessorT = document.getElementById('professor').options[document.getElementById('professor').selectedIndex].innerText;
    var PagamentoT = document.getElementById('pagamento').options[document.getElementById('pagamento').selectedIndex].innerText;
    var DataInicio = document.getElementById("DataInicial").value;
    var DataFim = document.getElementById("DataFinal").value;
    
    var Tab = document.getElementById("tabela");
    var linhas = Tab.getElementsByTagName('tr');

    var arrData = DataInicio.split('-');
    var InicioPesquisa = (arrData[2] + '/' + arrData[1] + '/' + arrData[0]);
    
    var arrDataF = DataFim.split('-');
    var FimPesquisa = (arrDataF[2] + '/' + arrDataF[1] + '/' + arrDataF[0]);    

    var header = function (data) {
        // Header
        doc.addImage(LogoAcademia, 'GIF', 10, 15, 50, 50);
        doc.setTextColor(40);
        doc.setFontSize(16);
        doc.setFontStyle('bold');
        doc.text("Relatório de Mensalidades Recebidas", 85, 27);
        doc.setFontSize(12);
        doc.setTextColor(40);
        doc.setFontStyle('normal');
        doc.text("<?=utf8_encode($dados_academia['nome'])?>", 85, 42);
        doc.setFontSize(8);
        doc.setFontStyle('normal');
        doc.text("Emitido em <?=$data?>", 460, 20);
        doc.text("Total de Mensalidades: " + (linhas.length - 1), 460, 75);
        doc.setFontSize(9);
        doc.text("Professor: " + ProfessorT + " :: Turma: " + TurmaT , 85, 53);
        doc.text("Modalidade: " + ModalidadeT + " :: Forma Pagto: " + PagamentoT , 85, 64);
        doc.text("Período: De " + InicioPesquisa + " até " + FimPesquisa , 85, 75);
      };

    doc.autoTable(data1.columns, data1.rows, {
        beforePageContent: header,
//        afterPageContent: "Ola!",
        margin: {top: 80, right: 10, bottom: 20, left: 10}, 
        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
        columnStyles: {1: {halign: 'left'}},
        rowStyles: {1: {fontSize: (number = 11)}},
        tableLineColor: [189, 195, 199],
        tableLineWidth: 0.75,
        headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
        bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
        alternateRowStyles: {fillColor: [250, 250, 250]},
//        startY: 100,
        drawRow: function (row, data) {
            // Colspan
            doc.setFontStyle('bold');
            doc.setFontSize(8);
            if ($(row.raw[0]).hasClass("innerHeader")) {
                doc.setTextColor(200, 0, 0);
                doc.setFillColor(110,214,84);
                doc.rect(data.settings.margin.left, row.y, data.table.width, 20, 'F');
                doc.autoTableText("", data.settings.margin.left + data.table.width / 2, row.y + row.height / 2, {
                    halign: 'center',
                    valign: 'middle'
                });
               /*  data.cursor.y += 20; */
            };

            if (row.index % 5 === 0) {
                var posY = row.y + row.height * 6 + data.settings.margin.bottom;
                if (posY > doc.internal.pageSize.height) {
                    data.addPage();
                }
            }
        },

        drawCell: function (cell, data) {
            // Rowspan
            console.log(cell);
            if ($(cell.raw).hasClass("innerHeader")) {
            doc.setTextColor(200, 0, 0);
                    doc.autoTableText(cell.text + '', data.settings.margin.left + data.table.width / 2, data.row.y + data.row.height / 2, {
                    halign: 'center',
                    valign: 'middle'
                });
               
                return false;
            }
        }
    });

//  Tabela de Totais
    var data2 = doc.autoTableHtmlToJson(document.getElementById("tabela2"));
    var rows = data2.rows;
//    rows.splice(0,1);

    doc.autoTable(data2.columns, data2.rows, {
        startY: doc.autoTable.previous.finalY + 10,
        margin: {top: 80, right: 10, bottom: 20, left: 450}, 
        styles: {halign: 'center', theme: 'grid', fontSize: (number = 7), font: 'helvetica', lineColor: [44, 62, 80], lineWidth: 0.55},
        columnStyles: {0: {halign: 'rigth'}},
        rowStyles: {1: {fontSize: (number = 11)}},
        tableLineColor: [189, 195, 199],
        tableLineWidth: 0.75,
        headerStyles: {fillColor: [100, 100, 100], fontSize: 10},
        bodyStyles: {fillColor: [216, 216, 216], textColor: 50},
        alternateRowStyles: {fillColor: [250, 250, 250]},

    });

    window.open(doc.output('bloburl'),'_blank');
}

//    doc.save('table.pdf');

</script>

<?php
include 'rodape_form.php';
?>
</div>

<?php
include 'rodape.php';
?>
