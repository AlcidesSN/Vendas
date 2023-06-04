<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Vendas</title>
</head>
<body>
    <div>
    <h1>Seletor de Itens de Compra</h1>


    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
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
    </div>


    <div>
    <?php
    // Inicializa ou recupera o carrinho de compras da sessão
    session_start();

    if (!isset($_SESSION['final'])) {
        $_SESSION['final'] = array();
    }
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

    }



    // Verifica se o carrinho não está vazio
    if (!empty($_SESSION['carrinho'])) {
 
        $query = "SELECT * FROM products WHERE id = 0";//Codigo em SQL
        //Realiza a requisição para o bando de dados
        
        echo "<h1>Carrinho de Compras</h1>";
        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $query = $query . ' or' . ' id= ' . $item['item'] . ' ' ;
        }
        $query = $query . ' ;';
        $data = mysqli_query($bdc, $query)
        or die('Erro ao consultar o banco de dados.');
        $check;
        echo '<table>';
        echo '<tr><td><strong>Nome</strong></td><td><strong>Preço</strong></td><td><strong>Quantidade</strong></td></tr>';
        while ($row = mysqli_fetch_array($data)) {
            echo '<tr><td>' . $row['name'] . '</td>';
            echo '<td>' . $row['price'] . ':</td>';
            $cont = [$row['id']];
            $cont = 0;
            foreach ($_SESSION['carrinho'] as $item) {
                if($item['item'] == $row['id']){
                    $cont += $item['quantidade'];
                    $check[$row['id']] = [$row['id'], $row['name'], $row['price'], $cont];
                }
            }
            echo '<td>'. $cont . '</td>';
            echo '</td></tr>';  
            $total =  $total + ($cont * $row['price']);

        }
        echo '</table>';
        echo "<p><strong>Valor Total: </strong><em>$total</em></p>";


        // Verifica se o formulário de finalizar compra foi enviado
        if (isset($_POST['checkout'])) {
            // Aqui você pode adicionar a lógica para finalizar a compra, como calcular o total, processar o pagamento, etc.
            $query = "SELECT * FROM salemans;";//Codigo em SQL

            //Realiza a requisição para o bando de dados
            $data = mysqli_query($bdc, $query)
            or die('Erro ao consultar o banco de dados.');
            echo '<form method="post" action="sale.php">';
            echo '<label for="saleman" name="saleman" id="saleman"><strong>Vendedor:</strong></label>';
            echo '<select for="saleman" name="saleman" id="saleman">';

            while($row = mysqli_fetch_array($data)){
         
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';

            }
            echo '</select><br><br>';
            $query = "SELECT * FROM client;";//Codigo em SQL

            //Realiza a requisição para o bando de dados
            $data = mysqli_query($bdc, $query)
            or die('Erro ao consultar o banco de dados.');
            echo '<label for="client" name="client"><strong>Cliente:</strong></label>';
            echo '<select for="client" name="client" id="client">';

            while($row = mysqli_fetch_array($data)){

            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            } 

            echo '</select><br>';

            echo '<input type="hidden" name="total" id="total" value="' . $total . '"></input>';

            echo '<input type="submit" name="finish" value="Registrar">';
            echo "</form>";
            // Após finalizar a compra, você pode limpar o carrinho da sessão com unset($_SESSION['carrinho'])
            //unset($_SESSION['carrinho']);
            $_SESSION['final'] = array($check);
        }
    } else {
        echo "<p>O carrinho de compras está vazio.</p>";
    }
    if (isset($_POST['finish'])) { 
        unset($_SESSION['carrinho']);
        foreach($_SESSION['final'] as $i){
            foreach($i as $item){
                $product[] = $item[0];
                $amount[] = end($item);
            } 

        }
        $j = 0;
        foreach($product as $venda){
           
            $query = "INSERT INTO vendas(id, id_product, id_saleman, id_client, sale_value, amount, discount, total) VALUES ('',";

            
            $query .=" '$venda','". $_POST['saleman'] ."', '" . $_POST['client'] . "', '" . $_POST['total'] . "'," . $amount[$j] . " , 0, '" . $_POST['total'] . "')";

            $data = mysqli_query($bdc, $query)
            or die('Erro ao consultar o banco de dados.');
            
            
            $j++;
         
        }
        echo '<p>Venda cadastrada</p>';
        unset($_SESSION['final']);

    }
    mysqli_close($bdc);
    ?>
    </div>
</body>
</html>