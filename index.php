<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabelas do banco de dados</title>
</head>
<body>
    <?php 
    require_once('vars/conection.php');

    $bdc = mysqli_connect(BD_HOST,BD_USER, BD_PASSWORD, BD_NAME)
      or die('Erro ao conectar ao banco de dados.');

    //Obtem os dados do banco de dados
    $query = "SELECT vendas.id, products.name AS 'product', vendas.amount, products.price, products.price*vendas.amount AS 'total', salemans.name AS 'saleman',client.name AS 'client', vendas.date, vendas.total AS 'total_venda' FROM vendas, products,salemans,client WHERE products.id = vendas.id_product AND
	  salemans.id = vendas.id_saleman AND
	  client.id = vendas.id_client ORDER by vendas.id ASC;";//Codigo em SQL


    $data = mysqli_query($bdc, $query)
    or die('Erro ao consultar o banco de dados.');


    $i = true;
    while($row = mysqli_fetch_array($data)){
     
      if(isset($sep)){
        if(($sep !=  $row['date'] )){
          echo '</table>';
          echo '</tbody>';
          echo '<hr>';

          echo '<p><strong>Vendedor: </strong>' . $row['saleman'] . 
          ' <strong>Cliente: </strong>' . $row['client'] . '<br>' .
          '<strong>Total: </strong>' . $row['total_venda'] . '</p>';

          echo '<table>';
          echo '<thead>';
          echo '<tr>';
          echo '<td><strong>Produto</strong></td>';
          echo '<td><strong>Valor</strong></td>';
          echo '<td><strong>Quantidade</strong></td>';
          echo '<td><strong>Total</strong></td>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody>';
        }
      }
      if($i==true){
      
        echo '<p><strong>Vendedor: </strong>' . $row['saleman'] . 
        ' <strong>Cliente: </strong>' . $row['client'] . '<br>' .
        '<strong>Total: </strong>' . $row['total_venda'] . '</p>';

        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<td><strong>Produto</strong></td>';
        echo '<td><strong>Valor</strong></td>';
        echo '<td><strong>Quantidade</strong></td>';
        echo '<td><strong>Total</strong></td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $sep = $row['date'] ;
      }

      echo '<tr>';
      echo '<td>' . $row['product'] . '</td>';
      echo '<td>' . $row['price'] . '</td>';
      echo '<td>' . $row['amount'] . '</td>';
      echo '<td>' . $row['total'] . '</td>';
      echo '</tr>';


     
      $sep = $row['date'];
      $i = false;
    }
    echo '</table>';
    mysqli_close($bdc);
    ?>
</body>
</html>