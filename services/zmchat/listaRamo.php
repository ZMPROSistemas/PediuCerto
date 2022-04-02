<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['descricao'])){
        $ramo = $_GET['descricao'];
    } else {
        $ramo = '';
    }
    
    $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados,$ramo)) . '}';
    echo $retorno;

    function buscaDados($pdo, $dados, $ramo){
        $resultado = array();
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            if ($ramo!=''){
                $sql="select * from ramos where rm_empresa=".$dados['cod_empresa']." and (rm_descricao LIKE '%$ramo%') order by rm_descricao";
            }else{
                $sql="select * from ramos where rm_empresa=".$dados['cod_empresa']." order by rm_descricao";
            }
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['rm_id'],
                    'codigo' => $row['rm_cod'],
                    'descricao' => $row['rm_descricao']
                ));
            }
        }
        return $resultado;
    }

