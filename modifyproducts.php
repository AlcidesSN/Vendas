<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
</head>
<body>
  <?php 
    require_once('vars/conection.php');
    
    //Se o metodo POST foi chamado 
    if(!empty($_POST)){

      //cria um canal com o banco de dados
      $bdc = mysqli_connect(BD_HOST,BD_USER, BD_PASSWORD, BD_NAME)
      or die('Erro ao conectar ao banco de dados.');
      
      //Cria as variaveis que serão utilizadas com a matris POST
      $id = $_POST['id'];
      $name = $_POST['name'];
      $amount = $_POST['amount'];
      $price = $_POST['price'];

      //Comando personalizado para atualização do banco de dados
      $query = "UPDATE products SET amount='$amount',price='$price' WHERE products.id = '$id'";

      //faz a chamada do comando para o banco de dados
      $data = mysqli_query($bdc, $query)
       or die('Erro ao consultar o banco de dados.');

      //Fecha minha conexão com o banco de dados
      mysqli_close($bdc);

      ?>
      <h1>Modificações salvas</h1>
      <p>Para modificar outros produtos clique <a href="<?php echo $_SERVER['PHP_SELF'];?>">aqui</a></p>
      <?php 

   
    //Se não se o Metodo GET foi chamado
    }else if(!empty($_GET)){

      //Cria as variaveis utilizando A matriz GET
      $id = $_GET['id'];
      $name = $_GET['name'];
      $amount = $_GET['amount'];
      $price = $_GET['price'];
      
      //Cria um formulario para a modificação no banco de dados
      ?>
      <h1>Faça suas Alteraçoes?</h1>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <p><strong>Nome: </strong><?php echo $name; ?></p>
      <label for="amount" id="amount" nome="amount"><strong>Quantidade: </strong> </label>
      <input type="number" name="amount" id="amount" value="<?php echo "$amount";?>" ><br>
      <label for="price" id="price" name="price"><strong>Preço: </strong></label>
      <input type="text" name="price" id="price" value="<?php echo "$price";?>">
      <input type="hidden" name="id" value="<?php echo "$id";?>">
      <input type="hidden" name="name" value="<?php echo "$name";?>"><br> 
      <input type="submit" name="submit" id="submit" value="submit">
      </form>
      <?php
    

    //Se nenhuma Requisição GET nem POST
    }else{
      //cria um canal com o banco de dados
      $bdc = mysqli_connect(BD_HOST,BD_USER, BD_PASSWORD, BD_NAME)
      or die('Erro ao conectar ao banco de dados.');
      
      
      //Escreve um comando SQL para requisitar os infrmações do banco de dados
      $query = "SELECT * FROM products;";//Codigo em SQL

      //Realiza a requisição para o bando de dados
      $data = mysqli_query($bdc, $query)
      or die('Erro ao consultar o banco de dados.');

      //mostra a lista de cliente cadastrados atravez de um loop
      echo '<table>';
      while ($row = mysqli_fetch_array($data)) {
        echo '<tr><td><strong>' . $row['id'] . '</strong></td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>'. $row['amount'] . '</td>';
        echo '<td>' . $row['price'] . ':</td>';
        echo '<td><a href="'. $_SERVER['PHP_SELF'] .'?id='. $row['id'] .
        '&amp;name='. $row['name'].
        '&amp;amount='. $row['amount'].
        '&amp;price='. $row['price'].
        '" >Modificar</a></td>';
        echo '</td></tr><br>';   
      }
      echo '</table>';
      echo '<hr>';
      
      //fecha a conexao do banco de dados
      mysqli_close($bdc);
 
    }   
  ?>
    
</body>
</html>