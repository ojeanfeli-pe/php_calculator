<?php
    session_start();

    if (!isset($_SESSION['alternancia'])) {
        $_SESSION['alternancia'] = 0;
    }    

    if (!isset($_SESSION['historico'])) {
        $_SESSION['historico'] = array();
    }

    if(isset($_POST['apagarHistorico'])) {
        $_SESSION['historico'] = array();
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

    if(isset($_POST['salvar'])) {
        $numero1 = $_POST["numero1"];
        $operacao = $_POST["operacao"];
        $numero2 = $_POST["numero2"];

        $_SESSION['valores_salvos'] = array(
            'numero1' => $numero1,
            'operacao' => $operacao,
            'numero2' => $numero2
        );
    }

    if(isset($_POST['pegarValores'])) {
        if(isset($_SESSION['valores_salvos'])) {
            $valores_salvos = $_SESSION['valores_salvos'];
            $numero1_salvo = $valores_salvos['numero1'];
            $operacao_salva = $valores_salvos['operacao'];
            $numero2_salvo = $valores_salvos['numero2'];
        } else {
            $numero1_salvo = '';
            $operacao_salva = '';
            $numero2_salvo = '';
        }
    }

    if (isset($_POST['memoria'])) {
        if ($_SESSION['alternancia'] % 2 == 0) {
            $numero1 = $_POST["numero1"];
            $operacao = $_POST["operacao"];
            $numero2 = $_POST["numero2"];
    
            $_SESSION['valores_salvos'] = array(
                'numero1' => $numero1,
                'operacao' => $operacao,
                'numero2' => $numero2
            );
        } else {
            if (isset($_SESSION['valores_salvos'])) {
                $valores_salvos = $_SESSION['valores_salvos'];
                $numero1_salvo = $valores_salvos['numero1'];
                $operacao_salva = $valores_salvos['operacao'];
                $numero2_salvo = $valores_salvos['numero2'];
            } else {
                $numero1_salvo = '';
                $operacao_salva = '';
                $numero2_salvo = '';
            }
        }
    
        $_SESSION['alternancia']++;
    }
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <style>
        body{
        background-color:darkblue;
        font-weight: 400;
        font-style: normal;
        }

        h1{
            text-align: center;
            font-size: 70px;
            margin: 0px;
            padding: 0px;
        }

        .calculadora {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-left: 20%;
            margin-right: 20%;
            margin-top: 5%;
            background-color: gray;
        }

        .historico, .resposta, input, option, select{
            color: black;
            background-color:white;
            border-radius: 10px;
            padding: 10px;
            margin: 10px;
        }
        label{
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="calculadora">
        <h1>Calculadora PHP</h1>

        <form action="calculadora.php" method="POST">

            <br><label for="numero1"> Numero 1: </label>
            <input type="number" name="numero1" id="numero1" style="font-family: Rationale, sans-serif;" value="<?php echo isset($numero1_salvo) ? $numero1_salvo : ''; ?>">

            <label for="operacao">Operação:</label>
            <select name="operacao" id="operacao">
                <option value="+" <?php echo (isset($operacao_salva) && $operacao_salva == '+') ? 'selected' : ''; ?>>+</option>
                <option value="-" <?php echo (isset($operacao_salva) && $operacao_salva == '-') ? 'selected' : ''; ?>>-</option>
                <option value="*" <?php echo (isset($operacao_salva) && $operacao_salva == '*') ? 'selected' : ''; ?>>*</option>
                <option value="/" <?php echo (isset($operacao_salva) && $operacao_salva == '/') ? 'selected' : ''; ?>>/</option>
                <option value="^" <?php echo (isset($operacao_salva) && $operacao_salva == '^') ? 'selected' : ''; ?>>^</option>
                <option value="!" <?php echo (isset($operacao_salva) && $operacao_salva == '!') ? 'selected' : ''; ?>>!</option>
            </select>

            <label for="numero2"> Numero 2: </label>
            <input type="number" name="numero2" id="numero2" style="font-family: Rationale, sans-serif;" value="<?php echo isset($numero2_salvo) ? $numero2_salvo : ''; ?>">

            <button type="submit" name="calcular" style=" background-color:lightgreen;  border-radius: 10px; font-size:20px;">CALCULAR</button>

            <?php
                include 'funcoes.php';

                $resposta = '';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $numero1 = $_POST["numero1"];
                    $operacao = $_POST["operacao"];
                    $numero2 = $_POST["numero2"];

                    $resultado = calcular($numero1, $numero2, $operacao);

                    if (isset($_POST['calcular'])){

                        if ($operacao == '!') {
                            $resposta = "{$numero1}! = {$resultado}";
                        } else {
                            $resposta = "{$numero1} {$operacao} {$numero2} = {$resultado}";
                        }

                        $_SESSION['historico'][] = $resposta;
                    }  
                }

                echo "<div class='resposta'><p>{$resposta}</p></div>";
            ?>
        
            <div>
                <button type="submit" name="salvar" style=" background-color:yellow;  border-radius: 10px; font-size:20px;">SALVAR</button>
                <button type="submit" name="pegarValores" style=" background-color:white;  border-radius: 10px; font-size:20px;">PEGAR VALORES</button>
                <button type="submit" name="memoria" style=" background-color:blue;  border-radius: 10px; font-size:20px;">M</button>
                <button type="submit" name="apagarHistorico" style=" background-color:blue;  border-radius: 10px; font-size:20px;">APAGAR HISTORICO</button>
            </div>
        
        </form>

        <h2>Histórico</h2>

        <div class="historico">
            <?php
                if(isset($_SESSION['historico'])) {
                    echo "<ul>";
                    foreach($_SESSION['historico'] as $item) {
                        echo "<li>{$item}</li>";
                    }
                    echo "</ul>";
                }
            ?>
        </div>
    </div>
</body>
</html>