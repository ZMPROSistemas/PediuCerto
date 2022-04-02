<?php
    include 'conectaPDO.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    if(isset($_GET['numero'])){
        $dados['numero'] = $_GET['numero'];      
    } else {
        $dados['numero'] = '0';    
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
        $sql="select cv_numero, cv_nome, cv_data from conversa_arquivada";
        $sql=$sql." where cv_data between '".$dados['dataI']."' and '".$dados['dataF']."'";
        if ($dados['numero'] != '0'){
            $sql=$sql." and ((cv_numero like '%".$dados['numero']."%') or (cv_nome like '%".$dados['numero']."%'))";
        }
        if ($dados['usuario'] != '0'){
            $sql=$sql." and cv_usuario=".$dados['usuario'];
        }
        $sql=$sql." group by cv_numero, cv_nome, cv_data";
        $sql=$sql." order by cv_data, cv_nome;";
        $pedido =$pdo->prepare($sql);
        $pedido->execute();
        $row= $pedido->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pdo->query($sql) as $row) {
            array_push($resultado, array(
                'data' => $row['cv_data'],
                'nome' => $row['cv_nome'],
                'numero' => $row['cv_numero']
            ));
        }
        return $resultado;
    }