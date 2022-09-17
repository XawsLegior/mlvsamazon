<?php
  error_reporting(0);
  $pagina = $_GET['pagina'];

  if(!isset($pagina)){
    $pagina = "principal.php";
  }
  loading($pagina);
  $pastas = ['Principal', 'Principal/Animacoes'];
  $error_404 = true;

  foreach ($pastas as $folder) {
    $path = $folder . '/' . $pagina;
    if(file_exists($path)){
      include($path);
      $error_404 = false;
      break;
    }
  }

  if($error_404 == true){
    include("../404/404.php");
  }

  function loading($pagina){
      $especiais = ['resultado.php', 'Buscador/buscador.php'];

      if(!in_array($pagina, $especiais)){
        include("Css/Animacoes/loading_page.php");

        echo '
            <script type="text/javascript">
                window.onload = function(){
                  document.getElementById("loading").remove();
                  document.getElementById("fundo_paginas").hidden = false;
                }
            </script>
        ';
      }
  }

?>
