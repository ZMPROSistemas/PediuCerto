<?php
    include 'conecta.php';
    include 'log.php';
    include 'ocorrencia.php';
    include 'getIp.php';
    include 'atualizaCache.php';
    
    $empresaMatriz = base64_decode($_GET['matriz']);

    $empresaAcesso = base64_decode($_GET['empresa']);

    if (isset($_GET['dadosgrupo'])) {
        if (isset($_GET['lista'])) {
            if (isset($_GET['descricao'])) {
                $descricao = $_GET['descricao'];
            
                if ($descricao == null) {
                    $grp_descricao = '';
            
                } else {
                    $grp_descricao = ' and grp_descricao like "%' . $descricao . '%"';
                }
            
            } else {
                $grp_descricao = '';
            }
  
            $lista = '{"result":[' . json_encode(listaGrupoProduto($conexao, $empresaMatriz, $grp_descricao)). ']}';
            echo $lista;
        }
        if (isset($_GET['buscar'])) {
            $grp_id = $_GET['grp_id'];
            
            $lista = '{"result":[' . json_encode(GrupoProduto($conexao, $empresaMatriz, $grp_id)). ']}';
            echo $lista;
        }
        if (isset($_GET['editar'])) {
            $grp_id = $_GET['grp_id'];
            $grp_desc = ucwords(strtolower($_GET['grp_desc']));

            $editar = editarGrupoProduto($conexao, $empresaMatriz, $grp_id, $grp_desc, $empresaAcesso);
        }
        if (isset($_GET['salvar'])) {
            $grp_desc = ucwords(strtolower($_GET['grp_desc']));

            $salvar = salvarGrupoProduto($conexao, $empresaMatriz, $grp_desc, $empresaAcesso);
        }
        if (isset($_GET['excluir'])) {
            $grp_id = $_GET['grp_id'];
            $excluir = excluirGrupoProduto($conexao, $empresaMatriz, $grp_id, $empresaAcesso);
        }
    }

    function listaGrupoProduto($conexao, $empresaMatriz, $grp_descricao){
        $resultado = array();

        $sql = "SELECT grp_id, grp_codigo, grp_descricao
        FROM grupo_prod where grp_matriz = $empresaMatriz $grp_descricao and grp_deletado <> 'S' order by grp_descricao;";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($resultado, array(
                'grp_id' => $row['grp_id'],
                'grp_codigo' => (int)$row['grp_codigo'],
                'grp_descricao' => utf8_decode(ucwords(strtolower($row['grp_descricao']))),

            ));
        }
        //echo $sql;
        return $resultado;
    }

    function grupoProduto($conexao, $empresaMatriz, $grp_id){
        $resultado = array();

        $sql = "SELECT grp_id, grp_codigo, grp_descricao
        FROM grupo_prod where grp_id = $grp_id;";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($resultado, array(
                'grp_id' => $row['grp_id'],
                'grp_codigo' => (int)$row['grp_codigo'],
                'grp_descricao' => utf8_decode(ucwords(strtolower($row['grp_descricao']))),

            ));
        }
        return $resultado;
    }

    function editarGrupoProduto($conexao, $empresaMatriz, $grp_id, $grp_desc, $empresaAcesso){

        $sql = "UPDATE grupo_prod SET grp_descricao = '$grp_desc' where grp_id = $grp_id;";
        
        $query = mysqli_query($conexao,$sql);

        $retorno = mysqli_affected_rows($conexao);

        if ($retorno <= 0) {
            echo 0;
        }else if($retorno >= 1){
            echo 1;
            atualizaCache($conexao, $empresaMatriz, $empresaAcesso, 'grupo');
        }
        
    }

    function salvarGrupoProduto($conexao, $empresaMatriz, $grp_desc, $empresaAcesso){

        codGrupo($conexao, $empresaMatriz, $empresaMatriz);
        $grp_codigo = getCodGrupo($conexao, $empresaMatriz,$empresaMatriz);

        $sql = "INSERT INTO grupo_prod (grp_codigo, grp_empresa, grp_matriz, grp_descricao, grp_deletado) value(
        ". $grp_codigo['dc_grupo'] . ", $empresaMatriz, $empresaMatriz, '$grp_desc','N')";
        
        $query = mysqli_query($conexao,$sql);

        $retorno = mysqli_affected_rows($conexao);

        if ($retorno <= 0) {
            echo 0;
        }else if($retorno >= 1){
            echo 1;
            atualizaCache($conexao, $empresaMatriz, $empresaAcesso, 'grupo');
        }
       

    }

    function excluirGrupoProduto($conexao, $empresaMatriz, $grp_id, $empresaAcesso){
        $sql = "UPDATE grupo_prod SET grp_deletado = 'S' WHERE grp_id = $grp_id;";
        $query = mysqli_query($conexao,$sql);
        
        $retorno = mysqli_affected_rows($conexao);

        if ($retorno <= 0) {
            echo 0;
        }else if($retorno >= 1){
            echo 1;
            atualizaCache($conexao, $empresaMatriz, $empresaAcesso, 'grupo');
        }
    }

?>