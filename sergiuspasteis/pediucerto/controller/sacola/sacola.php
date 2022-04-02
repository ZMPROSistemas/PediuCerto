<?php  
    include_once 'resources/views/sacola.html';

    include 'resources/footer.php';
?>
<script>
<?php 
    include_once 'controller/sacola/sacola.js';
    include_once 'controller/app/funcoesBasicas.js';
?>


var input = document.querySelector('#senha input');
var img = document.querySelector('#senha button');
var icon = document.querySelector('#senha .fas');

img.addEventListener('click', function () {
 
  input.type = input.type == 'text' ? 'password' : 'text';
  if (input.type == 'text') {
   
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');

  }else if(input.type == 'password'){
    
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
   

  }
});
</script>

</body>
</html>