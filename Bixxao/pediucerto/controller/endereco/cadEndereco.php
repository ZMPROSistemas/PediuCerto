<?php  

    $sql = "select distinct ba_nomebairro from bairro_atendido where ba_matriz = :ba_matriz order by ba_nomebairro";

    $pdo_endereco = $pdo->prepare($sql);
    $pdo_endereco -> bindParam(":ba_matriz", $_SESSION['codEmpresa']);
    $pdo_endereco -> execute();
    $listaBairrosAtendidos = $pdo_endereco->fetchAll(PDO::FETCH_ASSOC);

    //echo $sql.' '.$_SESSION['codEmpresa'];
    
    
    //  foreach ( $retorno as $e ){ 
    //      $listaBairrosAtendidos = $e->ba_nomebairro;
    //  } 
     
    
    // $listaBairrosAtendidos = [
    //     'Centro',
    //     'Jardim Europa',
    //     'Jardim Centauro',
    //     'Jardim Novo Centauro',
    //     'Vila Agari',
    //     'Vila Aparecida',
    //     'Nucleo Habitacional Joao Fiqueiredo',
    //     'Joao Paulo',
    //     'Nucleo Habitacional Joao Paulo',
    //     'Condominio Gran Residence'
    // ];

     
    //$erro = $pdo_endereco->errorInfo();
    //echo 'Bairros: ';
    //console.log($listaBairrosAtendidos); 

    //echo $_SESSION['codEmpresa'] ;
    include_once 'resources/views/C_endereco.html';

    include 'resources/footer.php';

    
?>
<script>
<?php 
    include_once 'controller/endereco/cadEndereco.js';
    include_once 'controller/app/funcoesBasicas.js';
?>

</script>

</body>
</html>