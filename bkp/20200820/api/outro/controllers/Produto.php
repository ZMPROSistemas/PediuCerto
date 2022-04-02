<?php
namespace controllers{
    
    class Produto{

        private $PDO;

        function __construct(){
            $this->PDO = new \PDO('mysql:host=db-brasilmobile.caungtcgcwfr.sa-east-1.rds.amazonaws.com;dbname=zmpro', 'root', 'lxmcz2016'); //Conexão
			$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); //habilitando erros do PDO
        }

        public function getListaProduto(){
            global $app;
            $sth = $this->PDO->prepare("select 	pd_id, 
            pd_cod, 
            pd_marca, 
            (select em_fanta from empresas where em_cod = pd_empresa) as pd_empresa, 
            pd_desc, 
            pd_vista, 
            pd_prazo, 
            (select sbp_descricao from subgrupo_prod where sbp_codigo = pd_subgrupo
            and sbp_empresa = pd_empresa and sbp_matriz = pd_matriz) as pd_subgrupo	
            from produtos where pd_deletado != 'S'  and pd_matriz = 1 and pd_empresa= 1
            ORDER BY pd_desc;");

            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            $app->render('default.php',["data"=>$result],200); 
         
        }

    }
}