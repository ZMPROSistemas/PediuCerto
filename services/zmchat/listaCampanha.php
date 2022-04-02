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
                $sql="select * from view_campanhas where ca_empresa=".$dados['cod_empresa']." and (ca_nome LIKE '%$desc%') order by ca_nome";
            }else{
                if ($ID!=''){
                    $sql="select * from view_campanhas where ca_empresa=".$dados['cod_empresa']." and ca_id=$ID order by ca_nome";    
                }else{
                    $sql="select * from view_campanhas where ca_empresa=".$dados['cod_empresa']." order by ca_nome";
                }
            }
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['ca_id'],
                    'codigo' => $row['ca_cod'],
                    'nome' => $row['ca_nome'],
                    'ramo' => $row['ca_ramo'],
                    'usuario' => $row['ca_usuario'],
                    'genero' => $row['ca_genero'],
                    'cod_cli1' => $row['ca_cod_cli1'],
                    'cod_cli2' => $row['ca_cod_cli2'],
                    'cidade' => $row['ca_cidade'],
                    'uf' => $row['ca_uf'],
                    'imagem' => $row['ca_imagem'],
                    'mensagem' => $row['ca_mensagem'],
                    'desc_ramo' => $row['desc_ramo'],
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
                    'ramo' => '',
                    'usuario' => '',
                    'genero' => '',
                    'cod_cli1' => '',
                    'cod_cli2' => '',
                    'cidade' => '',
                    'uf' => '',
                    'imagem' => '',
                    'mensagem' => '',
                    'desc_ramo' => '',
                    'nome_usuario' => '',
                    'lista_ramos' => buscaRamos($pdo,$dados['cod_empresa']),
                    'lista_usuarios' => buscaUsuarios($pdo,$dados['cod_empresa'])
                ));
            }else{
                $sql="select * from view_campanhas where ca_empresa=".$dados['cod_empresa']." and ca_id=$ID order by ca_nome";    
                foreach ($pdo->query($sql) as $row) {
                    array_push($resultado, array(
                        'id' => $row['ca_id'],
                        'codigo' => $row['ca_cod'],
                        'nome' => $row['ca_nome'],
                        'ramo' => $row['ca_ramo'],
                        'usuario' => $row['ca_usuario'],
                        'genero' => $row['ca_genero'],
                        'cod_cli1' => $row['ca_cod_cli1'],
                        'cod_cli2' => $row['ca_cod_cli2'],
                        'cidade' => $row['ca_cidade'],
                        'uf' => $row['ca_uf'],
                        'imagem' => $row['ca_imagem'],
                        'mensagem' => $row['ca_mensagem'],
                        'desc_ramo' => $row['desc_ramo'],
                        'nome_usuario' => $row['nome_usuario'],
                        'lista_ramos' => buscaRamos($pdo,$dados['cod_empresa']),
                        'lista_usuarios' => buscaUsuarios($pdo,$dados['cod_empresa'])
                    ));
                }
            }
        }
        return $resultado;
    }

    function buscaRamos($pdo, $cod_empresa){
        $retorno = array();   
        $sql = "select * from ramos where rm_empresa = $cod_empresa order by rm_descricao";
        foreach ($pdo->query($sql) as $row) {
            array_push($retorno, array(
                'id' => $row['rm_id'],    
                'codigo_ramo' => $row['rm_cod'],
                'descricao_ramo' => utf8_encode($row['rm_descricao'])
            ));
        }
        return $retorno;
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
