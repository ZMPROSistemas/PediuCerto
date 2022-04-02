<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['tpd'])){
        $dados['tpd'] = $_GET['tpd'];      
    } else {
        $dados['tpd'] = '';    
    }
    // if(isset($_GET['enviado_por'])){
    //     $dados['enviado_por'] = $_GET['enviado_por'];      
    // } else {
    //     $dados['enviado_por'] = 'Todos';    
    // }

    $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados)) . '}';
    echo $retorno;

    function buscaDados($pdo, $dados){
        $resultado = array();
        if ($dados['tpd']==''){
            $sql="select * from conversa_arquivada where cv_numero='".$dados['numero']."' and cv_empresa=".$dados['cod_empresa']." and cv_data>='".$dados['data']."'";
        }else{
            $sql="select * from conversa_arquivada where cv_numero='".$dados['numero']."' and cv_empresa=".$dados['cod_empresa']." and cv_data='".$dados['data']."'";
        }
        $sql=$sql." order by cv_id";
        $pedido =$pdo->prepare($sql);
        $pedido->execute();
        //echo $sql;
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pdo->query($sql) as $row) {
            array_push($resultado, array(
                'id' => $row['cv_id'],
                'data' => $row['cv_data'],
                'hora' => $row['cv_hora'],
                'enviado_por' => $row['cv_enviado_por'],
                'nome_atendente' => $row['cv_nome_atendente'],
                'mensagem' => $row['cv_mensagem']
            ));
        }
        return $resultado;
    }