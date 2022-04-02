<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['descricao'])){
        $desc = $_GET['descricao'];
    } else {
        $desc = '';
    }

    if(isset($_GET['id'])){
        $ID = $_GET['id'];
    } else {
        $ID = '';
    }
    
    $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados,$desc,$ID)) . '}';
    echo $retorno;

    function buscaDados($pdo, $dados, $desc, $ID){
        $resultado = array();
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            if ($desc!=''){
                $sql="select * from perfil where pe_empresa=".$dados['cod_empresa']." and (pe_descricao LIKE '%$desc%') order by pe_descricao";
            }else{
                if ($ID!=''){
                    $sql="select * from perfil where pe_empresa=".$dados['cod_empresa']." and pe_id=$ID order by pe_descricao";    
                }else{
                    $sql="select * from perfil where pe_empresa=".$dados['cod_empresa']." order by pe_descricao";
                }
            }
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['pe_id'],
                    'codigo' => $row['pe_cod'],
                    'descricao' => $row['pe_descricao'],
                    'ramo' => $row['pe_ramo'],
                    'ramo_i' => $row['pe_ramo_i'],
                    'ramo_a' => $row['pe_ramo_a'],
                    'ramo_e' => $row['pe_ramo_e'],
                    'mensagem' => $row['pe_mensagem'],
                    'mensagem_i' => $row['pe_mensagem_i'],
                    'mensagem_a' => $row['pe_mensagem_a'],
                    'mensagem_e' => $row['pe_mensagem_e'],
                    'usuario' => $row['pe_usuario'],
                    'usuario_i' => $row['pe_usuario_i'],
                    'usuario_a' => $row['pe_usuario_a'],
                    'usuario_e' => $row['pe_usuario_e'],
                    'perfil' => $row['pe_perfil'],
                    'perfil_i' => $row['pe_perfil_i'],
                    'perfil_a' => $row['pe_perfil_a'],
                    'perfil_e' => $row['pe_perfil_e'],
                    'campanha' => $row['pe_campanha'],
                    'campanha_i' => $row['pe_campanha_i'],
                    'campanha_a' => $row['pe_campanha_a'],
                    'campanha_e' => $row['pe_campanha_e'],
                    'depto' => $row['pe_depto'],
                    'depto_i' => $row['pe_depto_i'],
                    'depto_a' => $row['pe_depto_a'],
                    'depto_e' => $row['pe_depto_e'],
                    'cliente' => $row['pe_cliente'],
                    'cliente_i' => $row['pe_cliente_i'],
                    'cliente_a' => $row['pe_cliente_a'],
                    'cliente_e' => $row['pe_cliente_e'],
                    'chatbot' => $row['pe_chatbot'],  
                    'log_mens' => $row['pe_log_mens']
                ));
            }
        }
        return $resultado;
    }

