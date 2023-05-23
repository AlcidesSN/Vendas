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
    $query = "SELECT * FROM client;";//Codigo em SQL


    $data = mysqli_query($bdc, $query)
    or die('Erro ao consultar o banco de dados.');

    echo '<table>';
    echo '<h1>Lista de Clientes</h1>';
    //mostra a lista de cliente cadastrados
    while ($row = mysqli_fetch_array($data)) {
      echo '<tr><td><strong>' . $row['id'] . '</strong></td>';
      echo '<td>' . $row['name'] . '</td>';
      echo '<td>'. $row['cpf'] . '</td>';
      echo '<td>' . $row['cell'] . '</td>';
      if($row['premium'] == 1){
        echo '<td>Sim </td>';
      }else{
        echo '<td>Não </td>';
      }
      echo '</td></tr><br>';   
    }
    echo '</table>';
    echo '<hr>';

    //Obtem os dados do banco de dados
    $query = "SELECT * FROM salemans;";//Codigo em SQL


    $data = mysqli_query($bdc, $query)
    or die('Erro ao consultar o banco de dados.');

    echo '<table>';
    echo '<h1>Lista de Vendedores</h1>';
    //mostra a lista de cliente cadastrados
    while ($row = mysqli_fetch_array($data)) {
      echo '<tr><td><strong>' . $row['id'] . '</strong></td>';
      echo '<td>' . $row['name'] . '</td>';
      echo '<td>'. $row['cpf'] . '</td>';
      echo '<td>' . $row['rg'] . '</td>';
      echo '<td>' . $row['code'] . '</td>';
      echo '<td>' . $row['comition'] . '</td>';
      echo '</td></tr><br>';   
    }
    echo '</table>';
    echo '<hr>';

    $query = "SELECT * FROM products;";//Codigo em SQL


    $data = mysqli_query($bdc, $query)
    or die('Erro ao consultar o banco de dados.');

    echo '<table>';
    echo '<h1>Lista de Produtos</h1>';
    //mostra a lista de cliente cadastrados
    while ($row = mysqli_fetch_array($data)) {
      echo '<tr><td><strong>' . $row['id'] . '</strong></td>';
      echo '<td>' . $row['name'] . '</td>';
      echo '<td>'. $row['amount'] . '</td>';
      echo '<td>' . $row['price'] . '</td>';
      echo '</td></tr><br>';   
    }
    echo '</table>';
    echo '<hr>';
    
    
    mysqli_close($bdc);
    ?>
</body>
</html>