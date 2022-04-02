<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['nome'])){
        $desc = $_GET['nome'];
    } else {
        $desc = '';
    }
    if(isset($_GET['cod_empresa'])){
        $dados['cod_empresa'] = $_GET['cod_empresa'];
    } else {
        $dados['cod_empresa'] = '';
    }
    if ($dados['cod_empresa'] == ''){
        $retorno = '{"lista":[{""}]}';
        echo $retorno;
    }else{    
        if(isset($_GET['id'])){
            $ID = $_GET['id'];
        } else {
            $ID = '';
        };
        $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados,$desc,$ID)) . '}';
        echo $retorno;
    }

    function buscaDados($pdo, $dados, $desc, $ID){
        $resultado = array();
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){  
            if ($desc!=''){
                $sql="select * from vendas where vd_empr=".$dados['cod_empresa'];
            }else{
                if ($ID!=''){
                    $sql="select * from vendas where vd_empr=".$dados['cod_empresa'];    
                }else{
                    $sql="select * from vendas where vd_empr=".$dados['cod_empresa'];
                }
            }
            
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['vd_id'],
                    'codigo' => $row['vd_doc'],
                    'nome' => $row['vd_nome'],
                    'total' => $row['vd_total'],
                    'tipo' => $row['vd_tipolancto'],
                    'emissao' => $row['vd_emis']
                ));
            }
        }
        return $resultado;
    }
