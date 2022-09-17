<head>
    <link rel="stylesheet" href="Css/Resultado/visual.css">
</head>
<?php
  function reduzir($nome){
    if(strlen($nome) > 25){
      return substr($nome, 0, 25) . "...";
    }
    return $nome;
  }

  function mostrar_areas($dados){
    $areas = "<center>";
    $tam = count($dados);
    $index_atual = 1;
    foreach ($dados as $area => $value) {
        if($area == "ml"){$area = "Mercado Livre";}
        $area = ucfirst($area);
        $areas .= "<h2 class='result_vs'> $area </h2>";
        if($index_atual < $tam){
          $areas .= " <i class=\"result_separator bi-boxes\"></i> ";
        }
        $index_atual+=1;
    }
    echo $areas . "</center>";
  }
  $dados = $_POST['dados'];

  $area_anterior = "ml";
  $lista = "<div class='listagem_produtos'>";
  mostrar_areas($dados);

  foreach ($dados as $area => $dado) {
    if($area == "ml"){$area="Mercado Livre";}
    foreach ($dado as $index => $dado) {
      if($area_anterior != $area){
        $area_anterior = $area;
        $index = 0;
        $lista.="</ul><ul>";
      }
      $nome = reduzir($dado["nome"]);

      $link = $dado["capa"];
      $preco = $dado["preco"];
      $link_prod = $dado["link"];
      $lista.="
        <ul>
          <img src='$link'>
          <li class='result_title'> $nome </li>
          <li class='result_price'> $preco </li>
          <center><a class='result_acessar' target='_blank' href='$link_prod'> Acessar </a></center>
          <br>
        </ul>
      ";
    }

  }
  $lista .= "</div>";
  echo $lista;
?>
