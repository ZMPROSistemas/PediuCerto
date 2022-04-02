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
                $sql="select * from view_usuarios where us_empresa=".$dados['cod_empresa']." and (us_nome LIKE '%$desc%') order by us_nome";
            }else{
                if ($ID!=''){
                    $sql="select * from view_usuarios where us_empresa=".$dados['cod_empresa']." and us_id=$ID order by us_nome";    
                }else{
                    $sql="select * from view_usuarios where us_empresa=".$dados['cod_empresa']." order by us_nome";
                }
            }
            foreach ($pdo->query($sql) as $row) {
                array_push($resultado, array(
                    'id' => $row['us_id'],
                    'codigo' => $row['us_cod'],
                    'nome' => $row['us_nome'],
                    'email' => $row['us_email'],
                    'senha' => $row['us_senha'],
                    'depto' => $row['us_depto'],
                    'nivel' => $row['us_nivel'],
                    'ativo' => $row['us_ativo'],
                    'nome_depto' => $row['nome_depto'],
                    'desc_perfil' => $row['desc_perfil']
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
                    'email' => '',
                    'senha' => '',
                    'depto' => '',
                    'nivel' => '',
                    'ativo' => '',
                    'nome_depto' => '',
                    'desc_perfil' => '',
                    'departamentos' => buscaDepartamentos($pdo,$dados['cod_empresa']),
                    'niveis' => buscaNiveis($pdo,$dados['cod_empresa'])
                ));
            }else{
                $sql="select * from view_usuarios where us_empresa=".$dados['cod_empresa']." and us_id=$ID order by us_nome";    
                foreach ($pdo->query($sql) as $row) {
                    array_push($resultado, array(
                        'id' => $row['us_id'],
                        'codigo' => $row['us_cod'],
                        'nome' => $row['us_nome'],
                        'email' => $row['us_email'],
                        'senha' => $row['us_senha'],
                        'depto' => $row['us_depto'],
                        'nivel' => $row['us_nivel'],
                        'ativo' => $row['us_ativo'],
                        'nome_depto' => $row['nome_depto'],
                        'desc_perfil' => $row['desc_perfil'],
                        'departamentos' => buscaDepartamentos($pdo,$dados['cod_empresa']),
                        'niveis' => buscaNiveis($pdo,$dados['cod_empresa'])
                    ));
                }
            }
        }
        return $resultado;
    }

    function buscaDepartamentos($pdo, $cod_empresa){
        $retorno = array();   
        $sql = "select * from departamentos where dp_empresa = $cod_empresa order by dp_nome";
        foreach ($pdo->query($sql) as $row) {
            array_push($retorno, array(
                'id' => $row['dp_id'],    
                'codigo_depto' => $row['dp_cod'],
                'nome_depto' => utf8_encode($row['dp_nome'])
            ));
        }
        return $retorno;
    }

    function buscaNiveis($pdo, $cod_empresa){
        $retorno = array();   
        $sql = "select * from perfil where pe_empresa = $cod_empresa order by pe_descricao";
        foreach ($pdo->query($sql) as $row) {
            array_push($retorno, array(
                'id' => $row['pe_id'],    
                'codigo_nivel' => $row['pe_cod'],
                'descricao_nivel' => utf8_encode($row['pe_descricao'])
            ));
        }
        return $retorno;
    }
