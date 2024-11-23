<?php
// Definindo o cabeçalho para informar que a resposta será em formato JSON
header('Content-Type: application/json');

// Recebendo os dados enviados pelo JavaScript no corpo da requisição
$dados = json_decode(file_get_contents('php://input'), true);

// Verificando se os dados foram recebidos corretamente
if (isset($dados['valorAltura']) && isset($dados['valorPeso'])) {
    $altura = $dados['valorAltura'];
    $peso = $dados['valorPeso'];

    // Calculando o IMC
    if ($altura > 0 && $peso > 0) {
        $imc = $peso / ($altura * $altura);
        
        // Definindo a classificação do IMC e a classe CSS
        $classificacao = '';
        $classe = ''; // Variável para armazenar a classe CSS
        if ($imc < 18.5) {
            $classificacao = "Você está abaixo do peso.";
            $classe = "baixo-peso"; // Classe CSS para baixo peso
        } elseif ($imc >= 18.5 && $imc < 24.9) {
            $classificacao = "Peso normal.";
            $classe = "peso-normal"; // Classe CSS para peso normal
        } elseif ($imc >= 25 && $imc < 29.9) {
            $classificacao = "Sobrepeso.";
            $classe = "sobrepeso"; // Classe CSS para sobrepeso
        } elseif ($imc >= 30 && $imc < 39.9) {
            $classificacao = "Obesidade.";
            $classe = "obesidade"; // Classe CSS para obesidade
        } else {
            $classificacao = "Obesidade Grave.";
            $classe = "obesidade-grave"; // Classe CSS para obesidade grave
        }

        // Retornando o IMC, a classificação e a classe CSS como resposta JSON
        echo json_encode([
            'imc' => number_format($imc, 2),
            'classificacao' => $classificacao,
            'classe' => $classe // Incluindo a classe CSS no JSON
        ]);
    } else {
        echo json_encode([
            'erro' => 'Valores de altura ou peso inválidos.'
        ]);
    }
} else {
    echo json_encode([
        'erro' => 'Dados não recebidos corretamente.'
    ]);
}
?>
