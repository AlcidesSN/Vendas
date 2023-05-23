<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Vendedor</title>
</head>
<body>

    <?php 
    //verifica se o formulario ja foi submetido alguma vez
    if(isset($_POST['submit'])){
        //Criando as variaveis que serão utilizadas
        $output_form = false;
        $name = $_POST['name'];
        $amount = $_POST['amount'];
        $price = $_POST['price'];


        //verifica se algum dos campos esta vazio e gera uma mensagem de erro
        if((empty($name)) || (empty($amount)) || (empty($price))){
            //gera uma mensagem de erro
            echo '<p class="error">Campos não prenchidos:<br> ';
            $output_form = true;


            if(empty($name)){#Verifica se o campo Nome esta vazio
                echo ' Nome<br>';
            }
            if(empty($amount)){#Verifica se o campo Quantidade esta vazio
                echo ' Quantidade<br>';
            }
            if(empty($price)){#Verifica se o campo Telefone esta vazio
                echo ' Preço';
            }
            echo '</p>';
        }
        else{
            require_once('vars/conection.php');
            //faz a conexão com o banco de dados
            $bdc = mysqli_connect(BD_HOST,BD_USER, BD_PASSWORD, BD_NAME)
            or die('Erro ao conectar ao banco de dados.');

            //Obtem a instrução em SQL para enviar ao banco de dados
            $query = "INSERT INTO `products`(`id`, `name`, `amount`, `price`)".
            " VALUES ('','$name','$amount','$price');";
             //Codigo em SQL

            //Envia o a requisição ao banco de dados
            $data = mysqli_query($bdc, $query)
            or die('Erro ao consultar o banco de dados.');
            

            
            //corfirmação do cadastrado
            echo "<strong>Nome:</strong> $name <br>";
            echo "<strong>CPF:</strong> $amount <br>";
            echo "<strong>RG:</strong> $price <br>";
            //fecha a conexão com o banco de dados
            mysqli_close($bdc);
        } 
      
    }else{
        $output_form = true;
    }


    if($output_form){
        ?>
        <h1>Cadastro de Vendedores</h1>
        <p><strong>Atenção: </strong>Preençer todos os capos com *.</p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="name">Nome:*</label>
        <input type="text" for="name" name="name" id="name"><br>
        <label for="amount">Quantidade:*</label>
        <input type="text" for="amount" name="amount" id="amount"><br>
        <label for="price">Preço:*</label>
        <input type="text" for="price" name="price" id="price"><br>
        <input type="submit" value="submit" name="submit">
        </form>
        <?php
    }
    ?>


</body>
</html>