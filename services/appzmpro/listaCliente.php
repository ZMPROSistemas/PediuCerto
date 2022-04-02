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
                $sql="select * from pessoas where pe_empresa=".$dados['cod_empresa']." and pe_cliente='S' and (pe_nome LIKE '%$desc%') order by pe_nome";
            }else{
                if ($ID!=''){
                    $sql="select * from pessoas where pe_empresa=".$dados['cod_empresa']." and pe_cliente='S' and pe_id=$ID order by pe_nome";    
                }else{
                    $sql="select * from pessoas where pe_empresa=".$dados['cod_empresa']." and pe_cliente='S' order by pe_nome";
                }
            }
            
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['pe_id'],
                    'codigo' => $row['pe_cod'],
                    'nome' => $row['pe_nome'],
                    'endereco' => $row['pe_endereco'],
                    'end_num' => $row['pe_end_num'],
                    'complemento' => $row['pe_end_comp'],
                    'bairro' => $row['pe_bairro'],
                    'cidade' => $row['pe_cidade'],
                    'uf' => $row['pe_uf'],
                    'cep' => $row['pe_cep'],
                    'rg_ie' => $row['pe_rgie'],
                    'cpf_cnpj' => $row['pe_cpfcnpj'],
                    'fone' => $row['pe_fone'],
                    'email' => $row['pe_email']
                ));
            }
        }
        return $resultado;
    }
