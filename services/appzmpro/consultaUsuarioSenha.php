<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = buscaDados($pdo, $dados);
    echo $retorno;

    function buscaDados($pdo, $dados){
        $passou = 'T';
        //if((!isset($_GET['email'])) || (!isset($_GET['senha']))    ){  // || = ou
        if($dados['email']=='' || $dados['senha']==''){
        //if(!(isset($_GET['email']) or isset($_GET['senha']))){
            $passou='F';
            $retorno='{"status":"ERRO","mensagem":"faltam parametros"}';
        }
        
        if ($passou=='T'){
            $sql = "select us_id, us_empresa, us_nome, us_status, us_nivel, us_depto from usuarios where us_email=:email and us_senha=:senha";
            $pedido =$pdo->prepare($sql);
            $pedido->bindValue(":email", $dados['email']);
            $pedido->bindValue(":senha", $dados['senha']);
            $pedido->execute();
            $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
            if ($pedido->rowCount()== 0 ){
                $retorno='{"status":"ERRO","mensagem":"usuario nao encontrado"}';
            } else {
                $teste=array();
                // $teste=json_encode(buscaPerfil($pdo,$row[0]['us_nivel']));
                $nome_depto=buscaDepto($pdo,$row[0]['us_depto'],$row[0]['us_empresa']);
                // $retorno='{"status":"OK","empresa":"'.$row[0]['us_empresa'].'","usuario":"'.$row[0]['us_id'].'","nome":"'.$row[0]['us_nome'].'","status":"'.$row[0]['us_status'].'","nome_depto":"'.$row[0]['us_depto'].'","perfil":'.$teste.'}';
                $retorno='{"status":"OK","empresa":"'.$row[0]['us_empresa'].'","usuario":"'.$row[0]['us_id'].'","nome":"'.$row[0]['us_nome'].'","status":"'.$row[0]['us_status'].'","nome_depto":"'.$row[0]['us_depto'].'"}';
            }
        }
        return $retorno;
    }

    function buscaDepto($pdo,$depto,$empresa){
        $sql = "select dp_nome from departamentos where dp_nome=:nome and dp_empresa=:empresa";
        $pedido =$pdo->prepare($sql);
        $pedido->bindValue(":nome", $depto);
        $pedido->bindValue(":empresa", $empresa);
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        if ($pedido->rowCount()== 0 ){
            $resultado='';
        } else {
            $resultado='';
        }
        return $resultado;
    }

    // function buscaPerfil($pdo,$nivel){
    //     $resultado = array();   
    //     $sql = "select * from perfil where pe_id = $nivel";
    //     foreach ($pdo->query($sql) as $row) {
    //         array_push($resultado, array(
    //             'ramo' => $row['pe_ramo'].$row['pe_ramo_i'].$row['pe_ramo_a'].$row['pe_ramo_e'],
    //             'mensagem' => $row['pe_mensagem'].$row['pe_mensagem_i'].$row['pe_mensagem_a'].$row['pe_mensagem_e'],
    //             'usuario' => $row['pe_usuario'].$row['pe_usuario_i'].$row['pe_usuario_a'].$row['pe_usuario_e'],
    //             'perfil' => $row['pe_perfil'].$row['pe_perfil_i'].$row['pe_perfil_a'].$row['pe_perfil_e'],
    //             'campanha' => $row['pe_campanha'].$row['pe_campanha_i'].$row['pe_campanha_a'].$row['pe_campanha_e'],
    //             'depto' => $row['pe_depto'].$row['pe_depto_i'].$row['pe_depto_a'].$row['pe_depto_e'],
    //             'cliente' => $row['pe_cliente'].$row['pe_cliente_i'].$row['pe_cliente_a'].$row['pe_cliente_e'],
    //             'log_mens' => $row['pe_log_mens'],
    //             'chatbot' => utf8_encode($row['pe_chatbot'])
    //         ));
    //     }
    //     return $resultado;
    // }