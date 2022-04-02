<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['codigo'])){
        $codigo = $_GET['codigo'];
    } else {
        $codigo = '';
    }

    if(isset($_GET['id'])){
        $ID = $_GET['id'];
    } else {
        $ID = '';
    }
    
    $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados,$codigo,$ID)) . '}';
    echo $retorno;

    function buscaDados($pdo, $dados, $codigo, $ID){
        $resultado = array();
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            if ($codigo!=''){
                $sql="select * from mensagens_whats where mw_empresa=".$dados['cod_empresa']." and mw_cod=$codigo";
            }else{
                if ($ID!=''){
                    $sql="select * from mensagens_whats where mw_empresa=".$dados['cod_empresa']." and mw_id=$ID";    
                }else{
                    $sql="select * from mensagens_whats where mw_empresa=".$dados['cod_empresa'];
                }
            }
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['mw_id'],  
                    'codigo' => $row['mw_cod'],
                    'saudacao' => $row['mw_saudacao'],
                    'menu_departamentos' => $row['mw_menu_departamentos'],
                    'mensagem' => $row['mw_principal']
                ));
            }
        }
        return $resultado;
    }

