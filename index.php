<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora IMC</title>
    <!-- Link para o Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="d-flex justify-content-center align-items-center vh-100">
        <div class="container">
            <h1 class="text-center mt-md-2">Calculadora IMC</h1>
            <p>Insira seu peso e altura nos campos abaixo para calcular o seu IMC.</p>
            
            <div class="row g-2">
                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <img src="altura.png" alt="ícone de altura" width="23" height="24">
                            </span>
                        </div>
                        <input type="number" class="form-control" id="valor-altura" placeholder="Altura (ex.: 1,70)" required>
                    </div>
                </div>

                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <img src="escalas.png" alt="ícone de peso" width="23" height="24">
                            </span>
                        </div>
                        <input type="number" class="form-control" id="valor-peso" placeholder="Peso (ex.: 69,2)" required>
                    </div>
                </div>

                <div class="col-5">
                    <button class="btn btn-primary" id="btn-calcular" onclick="processar();">Calcular</button>
                </div>

                <!-- Botão Limpar -->
                <div class="col-3">
                    <button class="btn btn-warning" id="btn-limpar" onclick="limpar();">Limpar</button>
                </div>

                <div class="col-8">
                    <div id="resultado" class="resultado"></div>
                </div>

            </div>

            <!-- Tabela com os intervalos de IMC -->
            <h3 class="text-center mt-3">Tabela de IMC</h3>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Intervalo de IMC</th>
                        <th>Classificação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="baixo-peso">
                        <td>Abaixo de 18,5</td>
                        <td>Você está abaixo do peso</td>
                    </tr>
                    <tr id="peso-normal">
                        <td>18,5 a 24,9</td>
                        <td>Peso normal</td>
                    </tr>
                    <tr id="sobrepeso">
                        <td>25 a 29,9</td>
                        <td>Sobrepeso</td>
                    </tr>
                    <tr id="obesidade">
                        <td>30 a 39,9</td>
                        <td>Obesidade</td>
                    </tr>
                    <tr id="obesidade-grave">
                        <td>Acima de 40</td>
                        <td>Obesidade Grave</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Inclusão do Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function processar() {
            const valorAltura = parseFloat(document.getElementById('valor-altura').value);
            const valorPeso = parseFloat(document.getElementById('valor-peso').value);

            if (valorAltura <= 0 || valorPeso <= 0) {
                alert("Por favor, insira valores válidos para altura e peso.");
                return;
            }

            const dados = {
                valorAltura: valorAltura,
                valorPeso: valorPeso
            };

            fetch('calculo.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                const resultado = document.getElementById('resultado');
                resultado.className = 'resultado';

                if (data.erro) {
                    resultado.innerHTML = `<div class="alert alert-danger">${data.erro}</div>`;
                } else {
                    resultado.innerHTML = `
                        <div>Seu IMC é: ${data.imc}</div>
                        <div>${data.classificacao}</div>
                    `;
                    resultado.classList.add(data.classe);
                }
            })
            .catch(error => {
                alert("Ocorreu um erro ao processar os dados.");
            });
        }

        function limpar() {
            document.getElementById('valor-altura').value = '';
            document.getElementById('valor-peso').value = '';

            const resultado = document.getElementById('resultado');
            resultado.innerHTML = '';
            resultado.className = 'resultado';
        }
    </script>
</body>
</html>
