<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }
    
    $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados)) . '}';
    echo $retorno;

    function buscaDados($pdo, $dados){
        $resultado = array();
        $sql="select * from espera where es_depto='".$dados['depto']."' and es_empresa=".$dados['cod_empresa']." and ((es_status='Em Espera' and es_usuario=0) or (es_usuario=".$dados['usuario']."))";
        $sql=$sql." order by es_data, es_hora";
        $pedido =$pdo->prepare($sql);
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pdo->query($sql) as $row) {
            array_push($resultado, array(
                'id' => $row['es_id'],
                'data' => $row['es_data'],
                'hora' => $row['es_hora'],
                'numero' => $row['es_numero'],
                'nome' => $row['es_nome'],
                'status' => $row['es_status']
            ));
        }
        return $resultado;
    }