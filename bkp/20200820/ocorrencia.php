<?php
//    include 'conecta.php';

    
      function ocorrencia($conexao, $empresa_matriz,$empresa_filial){

        if ($empresa_filial == 0) {
            $empresa_filial = $empresa_matriz;
        }

        $sqlSelect = "SELECT * FROM zmpro.doctos WHERE dc_empresa=$empresa_filial;";
        $querySelect=mysqli_query($conexao, $sqlSelect);

        $row = mysqli_num_rows($querySelect);
        
        if ($row <= 0) {
            $sql = "INSERT INTO doctos (dc_ocorrencia, dc_matriz, dc_empresa) VALUE(1, $empresa_matriz, $empresa_filial);";
        
            $query=mysqli_query($conexao, $sql);
        
            if (mysqli_affected_rows($conexao) <= 0) {
                //echo 0;
            } else {
                //echo 1;
        
            }
          
        }else{
            $sql = "UPDATE doctos set dc_ocorrencia = (SELECT max(dc_ocorrencia)+1) where dc_empresa=$empresa_filial and dc_id >0;";
            $query=mysqli_query($conexao, $sql);
            
            if (mysqli_affected_rows($conexao) <= 0) {
                //echo 0;
            } else {
                //echo 1;
            }
            
        }

    }

    function getOcorrencia($conexao, $empresa_matriz,$empresa_filial){
            
        $sqlSelect = "SELECT * FROM zmpro.doctos WHERE dc_empresa=$empresa_filial;";
        $querySelect=mysqli_query($conexao, $sqlSelect);

        $row = mysqli_fetch_assoc($querySelect);

        return $row;
    }


    function codProduto($conexao, $empresa_matriz,$empresa_filial){

        if ($empresa_filial == 0) {
            $empresa_filial = $empresa_matriz;
        }

        $sqlSelect = "SELECT * FROM zmpro.doctos WHERE dc_matriz=$empresa_matriz and dc_empresa = $empresa_matriz;";
        $querySelect=mysqli_query($conexao, $sqlSelect);

        $row = mysqli_num_rows($querySelect);
        
        if ($row <= 0) {
            $sql = " INSERT INTO doctos (dc_produto, dc_ocorrencia, dc_matriz, dc_empresa) 
                        VALUE((select max(pd_cod) as pd_cod from produtos where pd_matriz = $empresa_matriz),1,$empresa_matriz, $empresa_matriz);";

           
        
            $query=mysqli_query($conexao, $sql);
        
            if (mysqli_affected_rows($conexao) <= 0) {
                //echo 0;
            } else {
                //echo 1;
        
            }
          
        }else{
            $sql = "UPDATE doctos set dc_produto = (SELECT max(dc_produto)+1) where dc_matriz=$empresa_matriz and dc_empresa=$empresa_matriz and dc_id >0;";
            $query=mysqli_query($conexao, $sql);
            
            if (mysqli_affected_rows($conexao) <= 0) {
                //echo 0;
            } else {
                //echo 1;
            }
            
        }

    }

    function getCodProduto($conexao, $empresa_matriz,$empresa_filial){
            
        $sqlSelect = "SELECT * FROM zmpro.doctos WHERE  dc_matriz=$empresa_matriz and dc_empresa=$empresa_matriz;";
        $querySelect=mysqli_query($conexao, $sqlSelect);

        $row = mysqli_fetch_assoc($querySelect);

        return $row;
    }
