<?php
    error_reporting(E_ALL);
    require_once 'conectaPDO.php';

    date_default_timezone_set('America/Bahia');
    $array = json_decode(file_get_contents("php://input"), true);
    if ($array == null){
      $array=$_REQUEST;  
    }

    //    echo '<pre>';
    //    print_r($array);
    //    echo '</pre>';
    // //$empresa = base64_decode($array['matriz']);
    // print_r($array['lista']);
    
    

    if (isset($array['lista'])){
        $grade123 = json_encode(grades_foods($pdo, base64_decode($array['matriz'])));
        echo $grade123;
    }

    if (isset($array['excluir'])){
        $grade123 = json_encode(excluirGrade($pdo, $array['id']));
        echo $grade123;
    }

    function grades_foods($pdo, $empresa){

        $sql = "select gr_id, gr_empresa, gr_cod, gr_desc, gr_qnt1, gr_qnt2, gr_qnt3, gr_qnt4, gr_qnt5, gr_qnt6, gr_qnt7, gr_qnt8, gr_qnt9, gr_qnt10, gr_qnt11, gr_qnt12, gr_qnt13, gr_qnt14, gr_qnt15, gr_qnt16, gr_qnt17, gr_qnt18 from grade_foods where gr_empresa = :empr";
        $sql .=" and gr_deletado='N'";
        $smtp = $pdo->prepare($sql);
        $smtp->bindParam(":empr", $empresa);
        $smtp->execute();
        $retorno = $smtp->fetchAll(PDO::FETCH_ASSOC);

        return $retorno;
    }

    function excluirGrade($pdo, $ct_id){
        $sim = "S";
        $sqlExcluir = "update grade_foods set grade_foods.gr_deletado = :deletado where grade_foods.gr_id = $ct_id";
        $queryPDO = $pdo->prepare($sqlExcluir);
        $queryPDO->bindParam(":deletado", $sim);
        $queryPDO->execute();
        $retorno = $queryPDO->rowCount();
        
    
        if ($retorno > 0) {

            // if ($ct_rateia == 'S') {
            //     $queryRateia = $pdo->prepare("DELETE FROM rateio_contas where rc_idconta = $ct_id;");
            //     $queryRateia->execute();
            //     $retorno = $queryRateia->rowCount();
            // }
        }
        //logSistema_Baixar_Conta_Pagar_forOcorrencia($conexao, $data, $hora, $ip, $us_id, 'Conta Excluida Ocorrencia N ', $empresa_matriz, $empresa_matriz);
    
        return $retorno;
    }

    


