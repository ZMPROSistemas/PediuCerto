<?php
    error_reporting(E_ALL);
    require_once 'conectaPDO.php';

    if(isset($_GET['todosBairros'])){
        $cidade = $_GET['cidade'];
        $bairro = json_encode(bairros($pdo, $cidade));
        print_r($bairro);
    }
    if (isset($_GET['bairroAtendidos'])){
        $matriz = base64_decode($_GET['matriz']);
        $empresa = base64_decode($_GET['empresa']);

        $bairro_atendido = json_encode(bairrosAtendidos($pdo, $matriz, $empresa));
        print_r($bairro_atendido);
    }

    if (isset($_GET['salvarRegiao'])) {
        $array = json_decode(file_get_contents("php://input"), true);

        $matriz = base64_decode($_GET['matriz']);
        $empresa = base64_decode($_GET['empresa']);

        $salvarRegiao = json_encode(salvarRegiao($pdo, $matriz, $empresa, $array));
       print_r($salvarRegiao);
    }

    if (isset($_GET['addNovoBairro'])){
        //$array = json_decode(file_get_contents("php://input"), true);
        //echo "Vai dar certo ";
        $cidade = $_GET['cidade'];
        $nomeBairro = ucfirst(strtolower($_GET['nomeBairro']));
        $matriz = base64_decode($_GET['matriz']);
        $empresa = base64_decode($_GET['empresa']);

        $salvarRegiao = json_encode(salvarNovoBairro($pdo, $matriz, $empresa, $nomeBairro, $cidade));
       print_r($salvarRegiao);
    }
    
    function salvarNovoBairro($pdo, $matriz, $empresa, $nomeBairro, $cidade){
        $br_id = 0;
        $sql = "INSERT INTO bairros (br_id, br_nome, br_cid) VALUES (:br_id, :br_nome, :br_cid)";
        $smtp = $pdo->prepare($sql);
        $smtp->bindParam(":br_id"  , $br_id);
        $smtp->bindParam(":br_nome", $nomeBairro);
        $smtp->bindParam(":br_cid" , $cidade);
        $smtp->execute();
        $bairros = $smtp->fetchAll(PDO::FETCH_ASSOC);

        return $bairros;
    }

    function bairros($pdo, $cidade){

        $sql = "SELECT * FROM zmpro.bairros where br_cid = :br_cid;";
        $smtp = $pdo->prepare($sql);
        $smtp->bindParam(":br_cid", $cidade);
        $smtp->execute();
        $bairros = $smtp->fetchAll(PDO::FETCH_ASSOC);

        return $bairros;
    }


    function bairrosAtendidos($pdo, $matriz, $empresa){

        if ($empresa == 0) {
            $empresa = $matriz;
        }
        $sql = "SELECT * FROM bairro_atendido where ba_empresa = :empresa;";
        $smtp = $pdo->prepare($sql);
        $smtp->bindParam(":empresa", $empresa);
        $smtp->execute();
        $bairros = $smtp->fetchAll(PDO::FETCH_ASSOC);
        
        return $bairros;
    }


    function salvarRegiao($pdo, $matriz, $empresa, $array){

        $retorno = array();

        if($empresa == 0){
            $empresa = $matriz;
        }

        try {
            $sql = "DELETE FROM bairro_atendido WHERE ba_empresa = :empresa;";
            $smtp = $pdo->prepare($sql);
            $smtp->bindParam(":empresa", $empresa);
            $smtp->execute();
        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        
        
        $row = $smtp->rowCount();
        $erro = $smtp->errorInfo();
        
        //print_r($erro);

        $regiao = array();

        try {

            $sql = "INSERT INTO bairro_atendido (ba_matriz, ba_empresa, ba_codcidade, ba_codbairro, ba_nomebairro, 
                                        ba_taxa) VALUES ";
                                        
            foreach ($array['regiao'] as $array){
            $sql .= "(?, ?, ?, ?, ?, ?),";
                array_push($regiao,
                    $matriz,
                    $empresa,
                    $array['ba_codcidade'],
                    $array['ba_codbairro'],
                    $array['ba_nomebairro'],
                    $array['ba_taxa']
                );
            }

            $sql = trim($sql, ','); //remover a última vírgula
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
            $smtp = $pdo->prepare($sql);
            $smtp->execute($regiao);

            $row = $smtp->rowCount();
            $erro = $smtp->errorInfo();

           // print_r($erro);

        }catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        

        if($row >= 0){
            array_push($retorno, array(
                'retorno' => 'SUCCESS'
            ));
        }else{
            array_push($retorno, array(
                'retorno' => 'ERROR'
            ));
        }

        return $retorno;

    }

?>