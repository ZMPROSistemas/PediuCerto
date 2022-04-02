<?php
    include 'conecta.php';
    include 'conectaPDO.php';
    include 'log.php';
    include 'ocorrencia.php';
    include 'getIp.php';
    include 'atualizaCache.php';

    date_default_timezone_set('America/Bahia');

    $data = date('Y-m-d'); 
    $hora = date('H:i:s');
    $ip = get_client_ip();
    
    $empresaMatriz = base64_decode($_GET['matriz']);

    $empresaAcesso = base64_decode($_GET['empresa']);
    
    if ($empresaAcesso == 0) {
        $empresaAcesso =  $empresaMatriz;
    }

   
    if (isset($_GET['dadosSubGrupo'])) {
        
        if (isset($_GET['lista'])) {
 
            if (isset($_GET['descricao'])) {
                $descricao = $_GET['descricao'];
            
                if ($descricao == null) {
                    $sbp_descricao = '';
            
                } else {
                    $sbp_descricao = ' and sbp_descricao like "%' . $descricao . '%"';
                }
            
            } else {
                $sbp_descricao = '';
            }

            if (isset($_GET['grupo'])) {
                $grupo = $_GET['grupo'];
            
                if ($grupo == null) {
                    $grp_descricao = '';
            
                } else {
                    $grp_descricao = ' and sbp_grupo = ' . $grupo;
                }
            
            } else {
                $grp_descricao = '';
            }

            $lista = '{"result":[' . json_encode(listaSubGrupoProduto($conexao, $pdo, $empresaMatriz, $sbp_descricao, $grp_descricao)). ']}';
            echo $lista;
        }
        if (isset($_GET['buscar'])) {
            $sub_id = $_GET['sub_id'];
            
            $lista = '{"result":[' . json_encode(subGrupoProduto($conexao, $empresaMatriz, $sub_id)). ']}';
            echo $lista;
        }
        if (isset($_GET['editar'])) {
           
           $sbp_id = $_GET['sbp_id'];
           $sbp_desc = ucwords(strtolower($_GET['sbp_desc']));
           $sbp_Grup = $_GET['sbp_Grup'];
           $getImage = trim($_GET['imageSub']);
           $imageSub = strstr($getImage, 'imag');
           $lancarSite = $_GET['lancarSite'];
           $DestacarSite = $_GET['DestacarSite'];


            $editar = editarGrupoProduto($conexao, $empresaMatriz, $empresaAcesso, $sbp_id, $sbp_desc, $sbp_Grup , $imageSub, $lancarSite, $DestacarSite);
        }
        if (isset($_GET['salvar'])) {
            $sbp_desc = ucwords(strtolower(utf8_decode($_GET['sbp_desc'])));
            $sbp_Grup = $_GET['sbp_Grup'];
            $getImage = trim($_GET['imageSub']);
            $imageSub = strstr($getImage, 'imag');
            $lancarSite = $_GET['lancarSite'];
            $DestacarSite = $_GET['DestacarSite'];

           $salvar = salvarSubGrupo($conexao, $empresaMatriz, $empresaAcesso, $sbp_desc, $sbp_Grup, $imageSub, $lancarSite, $DestacarSite);
        }
        if (isset($_GET['excluir'])) {
            
            $sbp_id = $_GET['sbp_id'];

            $excluir = excluirGrupoProduto($conexao, $empresaMatriz, $empresaAcesso, $sbp_id);
        }
    }

    function listaSubGrupoProduto($conexao, $pdo, $empresaMatriz, $sbp_descricao, $grp_descricao){
        $resultado = array();

        $sql = "SELECT sbp_id, sbp_codigo, sbp_empresa, sbp_matriz, sbp_descricao, sbp_grupo, 
        (select grp_descricao from grupo_prod where sbp_grupo = grp_codigo and grp_empresa = sbp_matriz) as sbp_grupo_desc
        FROM subgrupo_prod where sbp_empresa = :empresa $sbp_descricao $grp_descricao  and sbp_deletado = 'N' order by sbp_descricao;";

        
        $listacx = $pdo->prepare($sql);
        $listacx->bindValue(":empresa", $empresaMatriz);
        $listacx->execute();
        $resultado = $listacx->fetchAll(PDO::FETCH_ASSOC);
        
/*
        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($resultado, array(
                'sbp_id' => $row['sbp_id'],
                'sbp_codigo' => $row['sbp_codigo'],
                'sbp_empresa' => $row['sbp_empresa'],
                'sbp_matriz' => $row['sbp_matriz'],
                'sbp_descricao' => utf8_encode(ucwords($row['sbp_descricao'])),
                'sbp_grupo' => $row['sbp_grupo'],
                'sbp_grupo_desc' => utf8_encode($row['sbp_grupo_desc']),
            ));
        }
        //echo $sql;

    */
        return $resultado;
    }

    function subGrupoProduto($conexao, $empresaMatriz, $sub_id){
        $resultado = array();

        $sql = "SELECT sbp_id, sbp_empresa, (select em_fanta from empresas where em_cod = sbp_empresa) as pe_empresa, 
        sbp_matriz, sbp_codigo, sbp_descricao, sbp_grupo, sbp_imagem,sbp_lanca_site, sbp_destaca_site
        FROM zmpro.subgrupo_prod where sbp_empresa = $empresaMatriz and sbp_id = $sub_id;";

        $query = mysqli_query($conexao,$sql);

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($resultado, array(
                'sbp_id' => $row['sbp_id'],
                'sbp_empresa' => $row['sbp_empresa'],
                'pe_empresa' =>utf8_encode($row['pe_empresa']),
                'sbp_matriz' => $row['sbp_matriz'],
                'sbp_codigo' => $row['sbp_codigo'],
                'sbp_grupo' => $row['sbp_grupo'],
                'sbp_descricao' => utf8_encode(ucwords(strtolower($row['sbp_descricao']))),
                'sbp_imagem' => utf8_encode($row['sbp_imagem']),
                'sbp_lanca_site'=> verifica($row['sbp_lanca_site']),
                'sbp_destaca_site' => verifica($row['sbp_destaca_site']),


            ));
        }
        //echo $sql;
        return $resultado;
    }

    function verifica($situacao){
        
        if($situacao == 'S'){
            $situacao = true;
        }else if($situacao == ''){
            $situacao = false;
        }else{
            $situacao = false;
        }
    
        return $situacao;

    }

    function editarGrupoProduto($conexao, $empresaMatriz, $empresaAcesso, $sbp_id, $sbp_desc, $sbp_Grup, $imageSub, $lancarSite, $DestacarSite){

        $retorno = array();
        

        if ($lancarSite == 'true') {
            $lancarSite = 'S';
        }else{
            $lancarSite = 'N';
        }

        if ($DestacarSite == 'true') {
            $DestacarSite = 'S';
        }else{
            $DestacarSite = 'N';
        }

        $sql = "UPDATE subgrupo_prod SET sbp_descricao = '$sbp_desc', sbp_grupo = $sbp_Grup, 
        sbp_imagem ='$imageSub', sbp_lanca_site = '$lancarSite', 
        sbp_destaca_site = '$DestacarSite' WHERE sbp_id = $sbp_id;";
        
        $query = mysqli_query($conexao,$sql);

        $row = mysqli_affected_rows($conexao);

        if ($row <= 0) {
            array_push($retorno, array(
                'status'=> 'ERROR',
            ));
        }
        else if($row >= 1){

            array_push($retorno, array(
                'status'=>'SUCCESS',
               
            ));
            atualizaCache($conexao, $empresaMatriz, $empresaAcesso, 'subgrupo');
        }
        

        echo '{"result":[' . json_encode($retorno). ']}';

        return $retorno;
        

    }

    function salvarSubGrupo($conexao, $empresaMatriz, $empresaAcesso, $sbp_desc, $sbp_Grup, $imageSub, $lancarSite, $DestacarSite){

        $retorno = array();

        if ($empresaAcesso == 0) {
            $empresaAcesso = $empresaMatriz;
        }
        if ($lancarSite == true) {
            $lancarSite = 'S';
        }else{
            $lancarSite = 'N';
        }

        if ($DestacarSite == true) {
            $DestacarSite = 'S';
        }else{
            $DestacarSite = 'N';
        }

        codSubGrupo($conexao, $empresaMatriz, $empresaMatriz);
        $sbp_cod = getCodSubGrupo($conexao, $empresaMatriz,$empresaMatriz);
        

        $sql = "INSERT INTO subgrupo_prod (sbp_codigo, sbp_empresa, sbp_matriz, sbp_descricao, sbp_grupo, sbp_grade, sbp_tipo, sbp_desc, 
        sbp_comis,sbp_imagem, sbp_lanca_site, sbp_destaca_site, sbp_deletado)
        value(".$sbp_cod['dc_subgrupo'].", $empresaMatriz, $empresaAcesso, '$sbp_desc',$sbp_Grup,0,'N',0,0,'$imageSub','$lancarSite','$DestacarSite','N');";

        $query = mysqli_query($conexao, $sql);

        $row = mysqli_affected_rows($conexao);

        if ($row <= 0) {
            array_push($retorno, array(
                'status'=> 'ERROR',
            ));
        }
        else if($row >= 1){

            array_push($retorno, array(
                'status'=>'SUCCESS',
               
            ));
            atualizaCache($conexao, $empresaMatriz, $empresaAcesso, 'subgrupo');
        }

       // echo $sql;
        echo '{"result":[' . json_encode($retorno). ']}';

        return $retorno;
      
        

    }

    function excluirGrupoProduto($conexao, $empresaMatriz, $empresaAcesso, $sbp_id){
        $retorno = array();

        if($empresaAcesso == 0){
            $empresaAcesso = $empresaMatriz;
        }
        $sql = "UPDATE subgrupo_prod SET sbp_deletado = 'S' WHERE sbp_id = $sbp_id";
        $query = mysqli_query($conexao,$sql);
        
        $row = mysqli_affected_rows($conexao);
        
        if ($row < 0) {
            array_push($retorno, array(
                'status'=> 'ERROR',
            ));
        }
        else if($row >= 0){

            array_push($retorno, array(
                'status'=>'SUCCESS',
               
            ));

            atualizaCache($conexao, $empresaMatriz, $empresaAcesso, 'subgrupo');
        }

        echo '{"result":[' . json_encode($retorno). ']}';

        return $retorno;
      
    }


?>