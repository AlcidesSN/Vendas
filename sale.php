<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vendas</title>
</head>
<body>
<h2>Seletor de Itens de Compra</h2>


<form method="post" action="sale.php">
    <label for="item">Selecione um item:</label>
    <select name="item" id="item">
    <?php
    require_once('vars/conection.php');

    $bdc = mysqli_connect(BD_HOST,BD_USER, BD_PASSWORD, BD_NAME)
    or die('Erro ao conectar ao banco de dados.');
    
    
    //Escreve um comando SQL para requisitar os infrmações do banco de dados
    $query = "SELECT * FROM products;";//Codigo em SQL

    //Realiza a requisição para o bando de dados
    $data = mysqli_query($bdc, $query)
    or die('Erro ao consultar o banco de dados.');
    while($row = mysqli_fetch_array($data)){
        echo '<option value="'. $row['id'] .'">'.$row['name'].'</option>';
    }

    ?>
    </select>


    <br><br>


    <label for="quantidade">Quantidade:</label>
    <input type="number" name="quantidade" id="quantidade" min="1" value="1">


    <br><br>


    <input type="submit" name="submit" value="Adicionar ao Carrinho">
    <input type="submit" name="checkout" value="Finalizar Compra">
</form>


<?php
// Inicializa ou recupera o carrinho de compras da sessão
session_start();
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}


// Verifica se o formulário foi enviado
if(isset($_POST['submit'])) {
    // Recupera os valores do formulário
    $item = $_POST['item'];
    $quantidade = $_POST['quantidade'];


    // Adiciona o item ao carrinho
    $_SESSION['carrinho'][] = array(
        'item' => $item,
        'quantidade' => $quantidade
    );


    // Exibe a seleção do usuário
    echo "<p>Você adicionou o item $item ao carrinho.</p>";
}


// Verifica se o carrinho não está vazio
if (!empty($_SESSION['carrinho'])) {
    
    $query = "SELECT * FROM products WHERE id = 0";//Codigo em SQL
    //Realiza a requisição para o bando de dados
    
    echo "<h3>Carrinho de Compras</h3>";
    echo "<ul>";
    $total = 0;
    foreach ($_SESSION['carrinho'] as $item) {
        $query = $query . ' or' . ' id= ' . $item['item'] . ' ' ;
    }
    $query = $query . ' ;';
    $data = mysqli_query($bdc, $query)
    or die('Erro ao consultar o banco de dados.');
    echo "</ul>";
    echo '<table>';
    echo '<tr><td><strong>Nome</strong></td><td><strong>Preço</strong></td><td><strong>Quantidade</strong></td></tr>';
    while ($row = mysqli_fetch_array($data)) {
        echo '<tr><td>' . $row['name'] . '</td>';
        echo '<td>' . $row['price'] . ':</td>';
        $cont = [$row['id']];
        $cont[$row['id']] = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            if($item['item'] == $row['id'])
                $cont[$row['id']] = $cont[$row['id']] + $item['quantidade'];
        }
        echo '<td>'. $cont[$row['id']] . '</td>';
        echo '</td></tr>';  
        $total =  $total + ($cont[$row['id']] * $row['price']);
    }
    echo '</table>';
    echo "<p><strong>Valor Total: </strong><em>$total</em></p>";


    // Verifica se o formulário de finalizar compra foi enviado
    if (isset($_POST['checkout'])) {
        // Aqui você pode adicionar a lógica para finalizar a compra, como calcular o total, processar o pagamento, etc.
        // Após finalizar a compra, você pode limpar o carrinho da sessão com unset($_SESSION['carrinho'])
        unset($_SESSION['carrinho']);
        echo "<p>Compra finalizada! Obrigado!</p>";
    }
} else {
    echo "<p>O carrinho de compras está vazio.</p>";
}
mysqli_close($bdc);
?>
</body>
</html>