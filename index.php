<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/index.css">
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
          
          echo '</tbody>';
          echo '</table>';
          echo '</div>';

          echo '<div>';;
          echo '<p><strong>Vendedor: </strong>' . $row['saleman'] . 
          ' <strong>Cliente: </strong>' . $row['client'] . '<br>' .
          '<strong>Total: </strong>' . $row['total_venda'] . '</p>';

          echo '<table>';
          echo '<thead>';
          echo '<tr>';
          echo '<th><strong>Produto</strong></th>';
          echo '<th><strong>Valor</strong></th>';
          echo '<th><strong>Quantidade</strong></th>';
          echo '<th><strong>Total</strong></th>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody>';
        }
      }
      if($i==true){
      
        echo '<div>';
        echo '<p><strong>Vendedor: </strong>' . $row['saleman'] . 
        ' <strong>Cliente: </strong>' . $row['client'] . '<br>' .
        '<strong>Total: </strong>' . $row['total_venda'] . '</p>';

        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th><strong>Produto</strong></th>';
        echo '<th><strong>Valor</strong></th>';
        echo '<th><strong>Quantidade</strong></th>';
        echo '<th><strong>Total</strong></th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $sep = $row['date'] ;
        
      }

      echo '<tr>';
      echo '<td>' . $row['product'] . '</td>';
      echo '<td>' . number_format($row['price'],2) . '</td>';
      echo '<td>' . $row['amount'] . '</td>';
      echo '<td>' . number_format($row['total'],2) . '</td>';
      echo '</tr>';


     
      $sep = $row['date'];
      $i = false;
    }
    echo '</table>';
    mysqli_close($bdc);
    ?>
</body>
</html>