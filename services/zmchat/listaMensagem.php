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
                $sql="select * from mensagens where me_empresa=".$dados['cod_empresa']." and (me_descricao LIKE '%$desc%') order by me_descricao";
            }else{
                if ($ID!=''){
                    $sql="select * from mensagens where me_empresa=".$dados['cod_empresa']." and me_id=$ID order by me_descricao";    
                }else{
                    $sql="select * from mensagens where me_empresa=".$dados['cod_empresa']." order by me_descricao";
                }
            }
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['me_id'],
                    'codigo' => $row['me_cod'],
                    'descricao' => $row['me_descricao'],
                    'mensagem' => $row['me_mensagem']
                ));
            }
        }
        return $resultado;
    }

