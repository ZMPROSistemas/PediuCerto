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

    if(isset($_GET['id'])){
        $ID = $_GET['id'];
        $retorno = '{"lista":' . json_encode(buscaPorID($pdo,$dados,$ID)) . '}';
    } else {
        $ID = '';
        $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados,$desc,$ID)) . '}';
    }
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
                $sql="select * from view_pessoas where pe_empresa=".$dados['cod_empresa']." and (pe_nome LIKE '%$desc%') order by pe_nome";
            }else{
                if ($ID!=''){
                    $sql="select * from view_pessoas where pe_empresa=".$dados['cod_empresa']." and pe_id=$ID order by pe_nome";    
                }else{
                    $sql="select * from view_pessoas where pe_empresa=".$dados['cod_empresa']." order by pe_nome";
                }
            }
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['pe_id'],
                    'codigo' => $row['pe_cod'],
                    'nome' => $row['pe_nome'],
                    'fone' => $row['pe_fone'],
                    'usuario' => $row['pe_usuario'],
                    'genero' => $row['pe_genero'],
                    'cep' => $row['pe_cep'],
                    'end' => $row['pe_end'],
                    'end_num' => $row['pe_end_num'],
                    'bairro' => $row['pe_bairro'],
                    'cidade' => $row['pe_cid'],
                    'uf' => $row['pe_uf'],
                    'nome_usuario' => $row['nome_usuario']
                ));
            }
        }
        return $resultado;
    }

    function buscaPorID($pdo, $dados, $ID){
        $resultado = array();
        $passou = 'T';
        // if( (!isset($_GET['cod_empresa'])) || (!isset($_POST['descricao'])) ){
        //     $passou='F';
        //     $resultado='{"status":"ERRO","mensagem":"faltam parametros"}';
        // }
        if ($passou=='T'){
            if ($ID=='0') {
                array_push($resultado, array(
                    'id' => '',
                    'codigo' => '',
                    'nome' => '',
                    'fone' => '',
                    'usuario' => '',
                    'genero' => '',
                    'cep' => '',
                    'end' => '',
                    'end_num' => '',
                    'bairro' => '',
                    'cidade' => '',
                    'uf' => '',
                    'nome_usuario' => '',
                    'lista_usuarios' => buscaUsuarios($pdo,$dados['cod_empresa'])
                ));
            }else{
                $sql="select * from view_pessoas where pe_empresa=".$dados['cod_empresa']." and pe_id=$ID order by pe_nome";    
                foreach ($pdo->query($sql) as $row) {
                    array_push($resultado, array(
                        'id' => $row['pe_id'],
                        'codigo' => $row['pe_cod'],
                        'nome' => $row['pe_nome'],
                        'fone' => $row['pe_fone'],
                        'usuario' => $row['pe_usuario'],
                        'genero' => $row['pe_genero'],
                        'cep' => $row['pe_cep'],
                        'end' => $row['pe_end'],
                        'end_num' => $row['pe_end_num'],
                        'bairro' => $row['pe_bairro'],
                        'cidade' => $row['pe_cid'],
                        'uf' => $row['pe_uf'],
                        'nome_usuario' => $row['nome_usuario'],
                        'lista_usuarios' => buscaUsuarios($pdo,$dados['cod_empresa'])
                    ));
                }
            }
        }
        return $resultado;
    }

    function buscaUsuarios($pdo, $cod_empresa){
        $retorno = array();   
        $sql = "select * from usuarios where us_empresa = $cod_empresa order by us_nome";
        foreach ($pdo->query($sql) as $row) {
            array_push($retorno, array(
                'id' => $row['us_id'],    
                'codigo_usuario' => $row['us_cod'],
                'nome_usuario' => utf8_encode($row['us_nome'])
            ));
        }
        return $retorno;
    }
