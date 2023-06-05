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

    
    mysqli_close($bdc);
    ?>
</body>
</html>