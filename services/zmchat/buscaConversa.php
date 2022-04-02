<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['id'])){
        $dados['id'] = $_GET['id'];      
    } else {
        $dados['id'] = '0';    
    }
    if(isset($_GET['enviado_por'])){
        $dados['enviado_por'] = $_GET['enviado_por'];      
    } else {
        $dados['enviado_por'] = 'Todos';    
    }

    $retorno = '{"lista":' . json_encode(buscaDados($pdo,$dados)) . '}';
    echo $retorno;

    function buscaDados($pdo, $dados){
        $resultado = array();
//        $sql="select * from conversa where cv_numero='".$dados['numero']."' and cv_empresa=".$dados['cod_empresa']." and cv_usuario=".$dados['usuario'];
        $sql="select * from conversa where cv_numero='".$dados['numero']."' and cv_empresa=".$dados['cod_empresa'];
        if ($dados['id'] <> '0'){
            $sql=$sql." and cv_id>".$dados['id'];    
        }
        if ($dados['enviado_por'] <> 'Todos'){
            $sql=$sql." and cv_enviado_por='".$dados['enviado_por']."'";    
        }
        $sql=$sql." order by cv_id";
        $pedido =$pdo->prepare($sql);
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pdo->query($sql) as $row) {
            array_push($resultado, array(
                'id' => $row['cv_id'],
                'data' => $row['cv_data'],
                'hora' => $row['cv_hora'],
                'enviado_por' => $row['cv_enviado_por'],
                'mensagem' => $row['cv_mensagem']
            ));
        }
        return $resultado;
    }