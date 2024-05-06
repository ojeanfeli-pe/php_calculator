<?php 
function calcular($numero1, $numero2, $operacao){
    
    if(isset($_POST['calcular'])){
        switch($operacao){
            case '+':
                return $numero1 + $numero2;
                break;
            case '-':
                return $numero1 - $numero2;
                break;
            case '*':
                return $numero1 * $numero2;
                break;             
            case '/':
                return $numero1 / $numero2;
                break;
             case '^':
                return pow($numero1, $numero2);
                break;
            case '!':
                if($numero1 == 0){
                    return 1;
                }elseif ($numero1 < 0){
                    return '∄';
                } else{
                    return fatorial($numero1);
                    break;
                }
        }
    }
}

function fatorial($numero1){
    $fatorial = 1;
    $total = "";

    for ($i = 1; $i <= $numero1; $i++){
        $fatorial *= $i;
        $total .= "$i";
        if($i != $numero1){
            $total .= " * ";
        }
    }
    $total .= " = $fatorial";

    return $total;
}
?>