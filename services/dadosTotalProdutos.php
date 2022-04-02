<?php
    include 'conectaPDO.php';
    include 'analisaToken.php';

    $dados = json_decode(file_get_contents("php://input"), true);

    if($dados == ''){
        $dados = $_REQUEST;
    }

    
    if(empty($dados['empresa'])){
        $retorno = array();
        array_push($retorno , array(
            'ERRO' => 'Empresa deve ser informada',
            'return' => false
        ));

        echo json_encode($retorno);
    }else{
        $lista =         '[{"subgrupos":'. json_encode(buscarSubGrupos($pdo, $dados['empresa'])) . ',';
        $lista = $lista . '"produtos":' . json_encode(buscarProdutos($pdo, $dados['empresa'])) . ',';
        $lista = $lista . '"grades":' . json_encode(buscarGrades($pdo, $dados['empresa'])) . ',';
        $lista = $lista . '"excecoes":' . json_encode(buscarExcecoes($pdo, $dados['empresa'])) . '}]';
        echo $lista;
    
    }

    function buscarExcecoes($pdo, $idempresa){
        $retorno = array();
        $sql = "SELECT * FROM excecoes where ex_empresa = $idempresa order by ex_desc";
        foreach ($pdo->query($sql) as $row) {
            array_push($retorno, array(
                'ex_cod' => $row['ex_cod'],
                'ex_desc' => utf8_encode($row['ex_desc']),
                'ex_valor' => $row['ex_valor'],
                'ex_tipo' => utf8_encode($row['ex_tipo'])
            ));
        }
        return $retorno;
    }

    function buscarGrades($pdo, $idempresa){
        $retorno = array();
        $sql = "SELECT * FROM grade_foods where gr_empresa = $idempresa order by gr_desc";
        foreach ($pdo->query($sql) as $row) {
            array_push($retorno, array(
                'gr_cod' => $row['gr_cod'],
                'gr_desc' => utf8_encode($row['gr_desc']),
                'gr_grade1' => utf8_encode($row['gr_qnt1']),
                'gr_grade2' => utf8_encode($row['gr_qnt2']),
                'gr_grade3' => utf8_encode($row['gr_qnt3']),
                'gr_grade4' => utf8_encode($row['gr_qnt4']),
                'gr_grade5' => utf8_encode($row['gr_qnt5'])
            ));
        }
        return $retorno;
    }

    function buscarSubGrupos($pdo, $idempresa){
        $retorno = array();
        $sql = "SELECT * FROM subgrupo_prod where sbp_empresa = $idempresa and sbp_deletado='N' order by sbp_descricao";
        foreach ($pdo->query($sql) as $row) {
            array_push($retorno, array(
                'sbp_id' => $row['sbp_id'],
                'sbp_codigo' => $row['sbp_codigo'],
                'sbp_descricao' => utf8_encode($row['sbp_descricao']),
                'sbp_tipo' => utf8_encode($row['sbp_tipo']),
                'sbp_imagem' => utf8_encode($row['sbp_imagem']),
                'sbp_lanca_site' => utf8_encode($row['sbp_lanca_site']),
                'sbp_destaca_site' => utf8_encode($row['sbp_destaca_site'])
            ));
        }
        return $retorno;
    }
    
    function buscarProdutos($pdo, $idempresa){
        $retorno = array();
        $sql = "SELECT * FROM produtos where pd_empresa = $idempresa and pd_deletado='N' and pd_ativo='S' order by pd_desc";
        foreach ($pdo->query($sql) as $row) {
            array_push($retorno, array(
                'pd_id' => $row['pd_id'],
                'pd_cod' => $row['pd_cod'],
                'pd_desc' => utf8_encode($row['pd_desc']),
                'pd_vista' => $row['pd_vista'],
                'pd_codinterno' => utf8_encode($row['pd_codinterno']),
                'pd_subgrupo' => $row['pd_subgrupo'],
                'pd_codgrade' => $row['pd_codgrade'],
                'pd_foto_url' => utf8_encode($row['pd_foto_url']),
                'pd_composicao' => utf8_encode($row['pd_composicao'])
            ));
        }
        return $retorno;
    }
