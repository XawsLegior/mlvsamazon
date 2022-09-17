<?php
  $ml = 'none';
  $amazon = 'hidden';
  $indexando = 'hidden';
  class anim{
      function hidden_ml(){
        global $ml, $amazon, $indexando;
        $ml = 'hidden';
        $amazon = 'visibility';
        $indexando = 'hidden';
        $this->mostrar();
      }

      function show_indexs(){
        global $ml, $amazon, $indexando;
        $ml = 'hidden';
        $amazon = 'hidden';
        $indexando = 'visibility';
        $this->mostrar();
      }

      function mostrar(){
        global $ml, $amazon, $indexando;
        $searching = "'<center> <i class=\"icon_inicial bi-search\"></i>
            <h1> Aguarde enquanto buscamos as informações nos sites!</h1>
            <p id=\'ml_busc\' $ml> Buscando informações no Mercado Livre...</p>
            <p id=\'amazon_busc\' $amazon> Buscando informações na Amazon...</p>
            <p $indexando> Indexando...</p>
            <div class=\"load\">
              <div class=\"styl1\"></div>
              <div class=\"styl2\"></div>
              <div class=\"styl3\"></div>
            </div>
            <center>
        '";
      $searching = str_replace("\n", "", $searching);
      $searching = str_replace("  ", "", $searching);
      $searching = str_replace("\r", "", $searching);
      echo $searching;
      }
  }
?>
