<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['nome'])){
        $depto = $_GET['nome'];
    } else {
        $depto = '';
    }
    
    if(isset($_GET['ordem'])){
        $ordem = $_GET['ordem'];
    } else {
        $ordem = 'dp_nome';
    }

    $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados,$depto,$ordem)) . '}';
    echo $retorno;

    function buscaDados($pdo, $dados, $depto,$ordem){
        $resultado = array();
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            if ($depto!=''){
                $sql="select * from departamentos where dp_empresa=".$dados['cod_empresa']." and (dp_nome LIKE '%$depto%') order by $ordem";
            }else{
                $sql="select * from departamentos where dp_empresa=".$dados['cod_empresa']." order by $ordem";
            }
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['dp_id'],
                    'codigo' => $row['dp_cod'],
                    'descricao' => $row['dp_nome']
                ));
            }
        }
        return $resultado;
    }

