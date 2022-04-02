<?php
    include '../services/conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['cpf'])){
        $cpf = $_GET['cpf'];
    } else {
        $cpf = '';
    }
    if(isset($_GET['empresa'])){
        $empresa = $_GET['empresa'];
    } else {
        $empresa = '';
    }

    $retorno = '{"lista":' . json_encode(buscaCliente($pdo,$cpf,$empresa)) . '}';
    echo $retorno;

    function buscaCliente($pdo, $cpf, $empresa){
        $resultado = array();
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            $sql="select pe_id, pe_cod, pe_nome, pe_email, pe_celular from pessoas where pe_cpfcnpj='".$cpf."' and pe_matriz=".$empresa;
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['pe_id'],
                    'codigo' => $row['pe_cod'],
                    'nome' => $row['pe_nome'],
                    'email' => $row['pe_email'],
                    'celular' => $row['pe_celular']
                ));
            }
        }
        return $resultado;
    }

