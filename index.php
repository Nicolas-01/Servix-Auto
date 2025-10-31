<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Servix Auto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="Docs/calendario.ico" rel="shortcut icon">
    <link href="style.css" rel="stylesheet">

</head>

<body>

    <div class="main-login">
        <div class="left-login">
            <h1>Faça login na Servix Auto<br>E agende sua manutenção com um clique!</h1>
            <img src="docs/novalogo.png" class="left-login-image" alt="Logo">
        </div>

        <form action="" method="post" class="right-login">
            <div class="card-login">

                <?php
                require_once('conexao.php');

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    try {
                        $email = $_POST['email'];
                        $password = $_POST['senha'];
                        $stmt = $pdo->prepare('SELECT * FROM cliente WHERE email = ?');
                        $stmt->execute([$email]); // recebe os dados
                        $usuario = $stmt->fetch(PDO::FETCH_ASSOC); // retornar dados
                
                        if ($usuario && password_verify($password, $usuario['senha'])) {
                            session_start();
                            $_SESSION['usuario'] = $usuario['nome'];
                            $_SESSION['acesso'] = true;
                            $_SESSION['id'] = $usuario['id_cliente'];
                            header('location: principal.php');
                            //no form, o "action" está vazio, então era para o usuário ficar nessa página.
                            //mas o "header();" pode mudar o cabeçalho, por exemplo, se o usuário estiver as informações corretas, ele pode enviar o usuário para outra página, nesse caso, ele está enviando para "principal.php".
                        } else {
                            $mensagem['erro'] = "Usário e/ou senha incorretos!";
                        }

                    } catch (Exception $e) {
                        echo 'Erro: ' . $e->getMessage();
                        die();
                    }
                }
                ?>

                <?php if (isset($mensagem['erro'])): ?>
                    <div class="alert alert-danger mt-3 mb-3">
                        <?= $mensagem['erro'] ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['mensagem']) && ($_GET['mensagem'] == "acesso_negado")): ?>
                    <div class="alert alert-danger mt-3 mb-3">
                        É necessário fazer login para acessar esse site!
                    </div>
                <?php endif; ?>

                <h1>LOGIN</h1>
                <div class="textfield">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control" placeholder="usuario@gmail.com">
                </div>

                <div class="textfield">
                    <label for="senha" class="form-label">Senha</label>
                    <input id="senha" type="password" name="senha" class="form-control" placeholder="************">
                </div>

                <button class="btn-login">Login</button>
                <div class="textfield">
                    <label>Crie sua conta <a href=novo_usuario.php>aqui!</a></label>
                </div>
            </div>
    </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </div>
</body>

</html>