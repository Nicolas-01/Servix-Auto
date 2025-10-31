<?php
require_once("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
    try {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); //criptografar senha
        $stmt = $pdo->prepare("INSERT INTO cliente(nome, cpf, email, telefone, senha) values (?,?,?,?,?)");
        if ($stmt->execute([$nome, $cpf, $email, $telefone, $senha])) { // inserir dados no banco.
            header("location:index.php?cadastro=true");
        } else {
            echo "<p>Erro ao inserir o usuário!</p>";
        }

    } catch (Exception $e) {
        echo "Erro ao inserir usuário!" . $e->getMessage();
    }
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar - Servix Auto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="Docs/calendario.ico" rel="shortcut icon">
    <link href="style.css" rel="stylesheet">
</head>

<body class="fundoCadastrar">

    <div class="card-cadastrar">
        <h1>CADASTRAR CLIENTE</h1>
        <form method="post" action="">

            <div class="textfieldCadastrar">
                <label for="nome" class="form-label">Nome</label>
                <input id="nome" type="text" name="nome" class="form-control" required=""
                    placeholder="Gustavo Oliveira">
            </div>

            <div class="textfieldCadastrar">
                <label for="cpf" class="form-label">CPF (apenas números)</label>
                <input id="cpf" type="number" name="cpf" class="form-control" required="" placeholder="***.***.***-**">
            </div>

            <div class="textfieldCadastrar">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" class="form-control" required=""
                    placeholder="usuario@gmail.com">
            </div>

            <div class="textfieldCadastrar">
                <label for="telefone" class="form-label">Telefone</label>
                <input id="telefone" type="number" name="telefone" class="form-control" required=""
                    placeholder="18 4002-8922">
            </div>

            <div class="textfieldCadastrar">
                <label for="senha" class="form-label">Senha</label>
                <input id="senha" type="password" name="senha" required="" class="form-control"
                    placeholder="************">
            </div>


            <div class="mb-3 titulo-consultar">
                <button class="btn-cadastrar">Enviar</button>
                <button type="button" class="btn btn-secondary" onclick="history.back();">Voltar</button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>