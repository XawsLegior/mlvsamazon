<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Bem-Vindo</title>
    <?php
        include('Css/menu.php');
        include('Css/Animacoes/anim_buscando_prod.php');
        $anim = new anim();
    ?>
  </head>
  <body>
    <center>
      <h1 class="titulo"> Vamos começar? </h1>
      <input class="busca" type="text" placeholder="Digite aqui sua busca."><i class="lupa_inicial bi-search"></i>
    </center>
      <div class="fundo_inicial">
        <center><i class="icon_inicial bi-journal-code"></i></center>
        <div class="space_top_20"></div>
        <p> Esse projeto foi criado para portfólio, nele é possível ver conhecimentos em: </p>
        <p> • Html, Css, Php, Javascript, Ajax e Banco de dados.</p>
        <p> • Python. </p>
        <p> • WebScrapping. </p>
        <p> • Requisições HTTPs. </p>
        <p> • URL Amigável. </p>
        <p> • Boas práticas. </p>
        <p> • Veja outros projetos <a target="_blank" href="https://welson.tk">clicando aqui!</a> </p>
        <br>
      </div>
  </body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    var dados = {};

    function reset_titulo(){
      document.getElementsByClassName('titulo')[0].innerHTML = "Vamos começar?";
      document.getElementsByClassName('titulo')[0].style.color = "darkorange";
    }

    /* CHAMAR BUSCA */
    $(".lupa_inicial").click(function(e){
        e.preventDefault(true);
        var buscar = document.getElementsByClassName('busca')[0].value;
        if(buscar.length < 3){
          document.getElementsByClassName('titulo')[0].innerHTML = "Informe um produto válido.";
          document.getElementsByClassName('titulo')[0].style.color = "red";
          setTimeout(reset_titulo, 5000);
          return false;
        }
        $(".fundo_inicial").html(<?php $anim->mostrar(); ?>);
        processar('{"area": "mercado_livre", "buscar": "' + buscar + '"}');
    });

    /* PROCESSAR */
    function processar(data){
      data = JSON.parse(data);
      var area = data['area'];
      var buscar = document.getElementsByClassName('busca')[0].value;
      $.ajax({
        url: 'Buscador/buscador.php',
        method: 'post',
        data: {data},
        success: function(data){
          if(data == "Um erro ocorreu."){
            $(".fundo_inicial").html("<h1> Ocorreu um erro, tente novamente! </h1>");
            return false;
          }
          if(area == "mercado_livre"){
            data = data.replaceAll("'", '"');
            data = data.replace("mercado_livre", "");
            dados = {"ml" : JSON.parse(data)};

            $(".fundo_inicial").html(<?php $anim->hidden_ml(); ?>);
            processar('{"area": "amazon", "buscar": "' + buscar + '", "ml":' + data + '}');
            return true;
          }
          else if(area == "amazon"){
            data = data.replaceAll("'", '"');
            data = JSON.parse(data);
            dados["amazon"] = data;
          }
          $(".fundo_inicial").html(<?php $anim->show_indexs(); ?>);
          mostrar_resultados(dados);
        },
      });
    }

    function mostrar_resultados(dados){
      $.ajax({
        url: 'resultado.php',
        method: 'post',
        data: {dados},
        success: function(data){
          $(".fundo_inicial").html(data);
        }
      });
    }

</script>
</html>
