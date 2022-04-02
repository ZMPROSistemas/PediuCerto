<?php
    include 'conecta.php';

    include 'log.php';
    include 'ocorrencia.php';
    include 'getIp.php';
    
    $empresaMatriz = base64_decode($_GET['matriz']);

    $empresaAcesso = base64_decode($_GET['empresa']);

    if (isset($_GET['dadosgrupo'])) {
        if (isset($_GET['lista'])) {
  
            $lista = '{"result":[' . json_encode(listaGrupoProduto($conexao, $empresaMatriz)). ']}';
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

            $editar = editarGrupoProduto($conexao, $empresaMatriz, $grp_id, $grp_desc);
        }
        if (isset($_GET['salvar'])) {
            $grp_desc = ucwords(strtolower($_GET['grp_desc']));

            $salvar = salvarGrupoProduto($conexao, $empresaMatriz, $grp_desc);
        }
        if (isset($_GET['excluir'])) {
            $grp_id = $_GET['grp_id'];
            $excluir = excluirGrupoProduto($conexao, $empresaMatriz, $grp_id);
        }
    }

    function listaGrupoProduto($conexao, $empresaMatriz){
        $resultado = array();

        $sql = "SELECT grp_id, grp_empresa, (select em_fanta from empresas where em_cod = grp_empresa) as pe_empresa,
        grp_matriz, grp_codigo, grp_descricao, grp_teste, grp_imagem
        FROM zmpro.grupo_prod where grp_matriz = $empresaMatriz and grp_deletado <> 'S';";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($resultado, array(
                'grp_id' => $row['grp_id'],
                'grp_empresa' => $row['grp_empresa'],
                'pe_empresa' => utf8_decode(ucwords(strtolower($row['pe_empresa']))),
                'grp_matriz' => $row['grp_matriz'],
                'grp_codigo' => (int)$row['grp_codigo'],
                'grp_descricao' => utf8_decode(ucwords(strtolower($row['grp_descricao']))),
                'grp_teste' => $row['grp_teste'],
                'grp_imagem' => $row['grp_imagem'],

            ));
        }
        //echo $sql;
        return $resultado;
    }

    function grupoProduto($conexao, $empresaMatriz, $grp_id){
        $resultado = array();

        $sql = "SELECT grp_id, grp_empresa, (select em_fanta from empresas where em_cod = grp_empresa) as pe_empresa,
        grp_matriz, grp_codigo, grp_descricao, grp_teste, grp_imagem
        FROM zmpro.grupo_prod where grp_matriz = $empresaMatriz and grp_id = $grp_id;";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($resultado, array(
                'grp_id' => $row['grp_id'],
                'grp_empresa' => $row['grp_empresa'],
                'pe_empresa' => utf8_decode(ucwords(strtolower($row['pe_empresa']))),
                'grp_matriz' => $row['grp_matriz'],
                'grp_codigo' => (int)$row['grp_codigo'],
                'grp_descricao' => utf8_decode(ucwords(strtolower($row['grp_descricao']))),
                'grp_teste' => $row['grp_teste'],
                'grp_imagem' => $row['grp_imagem'],

            ));
        }
        return $resultado;
    }

    function editarGrupoProduto($conexao, $empresaMatriz, $grp_id, $grp_desc){

        $sql = "UPDATE grupo_prod SET grp_descricao = '$grp_desc' where grp_id = $grp_id;";
        
        $query = mysqli_query($conexao,$sql);

        $retorno = mysqli_affected_rows($conexao);

        if ($retorno <= 0) {
            echo 0;
        }else if($retorno >= 1){
            echo 1;
        }
        

    }

    function salvarGrupoProduto($conexao, $empresaMatriz, $grp_desc){

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
        }
        
      

    }

    function excluirGrupoProduto($conexao, $empresaMatriz, $grp_id){
        $sql = "UPDATE grupo_prod SET grp_deletado = 'S' WHERE grp_id = $grp_id;";
        $query = mysqli_query($conexao,$sql);
        
        $retorno = mysqli_affected_rows($conexao);

        if ($retorno <= 0) {
            echo 0;
        }else if($retorno >= 1){
            echo 1;
        }
    }


?>