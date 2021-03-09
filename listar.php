<?php
session_start();
include_once("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8"/>
<title>CRUD - Listar</title>
</head>
<body>
    <a href="index.php">Cadastrar</a><br>
    <a href="listar.php">Listar</a><br>
<h1> listar usuário</h1>
<?php

    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    //Receber o númeroda pagina 
    $pagina_atual = filter_input(INPUT_GET,'pagina', 
    FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual: 1;

    //Setar a quantidade de itens por pagina
    $qnt_result_pg = 1;

    //Calcular o inicio visualização
    $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

   $result_usuarios = "SELECT * FROM usuarios LIMIT $inicio,
   $qnt_result_pg";
   $resultado_usuarios = mysqli_query($conn,  $result_usuarios );
   while($row_usuario = mysqli_fetch_assoc($resultado_usuarios)){
       echo "ID:" . $row_usuario['id']. "<br>";
       echo "Nome:" . $row_usuario['nome']. "<br>";
       echo "E-mail:" . $row_usuario['email']. "<br><hr>";

   }

   //Paginaçaõ  - Somar a quantidade de usuários
   $result_pg = "SELECT COUNT(id) AS num_result FROM usuarios";
   $resultado_pg = mysqli_query($conn, $result_pg);
   $row_pg = mysqli_fetch_assoc($resultado_pg);
  // echo $row_pg['num_result'];

  //Quantidade de paginas
  $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

  //Limitar os links antes depois
  $max_links = 2;
  echo "<a href='listar.php?pagina=1'>Primeira </a>";

 for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant
  ++){
      if($pag_ant>=1){
     echo "<a href='listar.php?pagina=$pag_ant'>$pag_ant</a>";
    }
  }
  echo "$pagina";
  for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep
  ++){
    echo "<a href='listar.php?pagina=$pag_dep'>$pag_dep</a>";
  }
  echo "<a href='listar.php?pagina=$pag_ant'>$pag_ant </a>";
  echo "<a href='listar.php?pagina=1'>Ultima </a>";
   ?>

</body>
</html>