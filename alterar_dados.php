<?php
require_once('cabecalho.php');

function retornaDadosCliente()
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM cliente WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['id']]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$cliente) {
            die("Erro ao consultar o cliente.");
        }
        return $cliente;
    } catch (Exception $e) {
        die("Erro ao consultar o cliente: " . $e->getMessage());
    }
}

function alterarDadosCliente($nome, $cpf, $telefone, $email)
{
    require("conexao.php");
    try {
        $sql = "UPDATE cliente SET nome = ?, cpf = ?, telefone = ?, email = ? WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $cpf, $telefone, $email, $_SESSION['id']])) {
            header('Location: principal.php?edicao=true');
        } else {
            echo "<p class='text-danger'>Erro ao alterar dados!</p>";
        }
    } catch (Exception $e) {
        die("Erro ao alterar dados do cliente: " . $e->getMessage());
    }
}

function alterarSenhaCliente($senhaAntiga, $novaSenha, $novaSenhaConfirm)
{
    require("conexao.php");
    try {
        if ($novaSenha != $novaSenhaConfirm) {
            echo "<p class='text-danger'>Senhas não conferem!</p>";
            return;
        }

        $cliente = retornaDadosCliente();

        if (!password_verify($senhaAntiga, $cliente['senha'])) {
            echo "<p class='text-danger'>Senha antiga incorreta!</p>";
            return;
        }

        $sql = "UPDATE cliente SET senha = ? WHERE id_cliente = ?";
        $stmt = $pdo->prepare($sql);
        $senhaHash = password_hash($novaSenha, PASSWORD_BCRYPT);

        if ($stmt->execute([$senhaHash, $_SESSION['id']])) {
            require("sair.php");
        } else {
            echo "<p class='text-danger'>Erro ao alterar senha!</p>";
        }
    } catch (Exception $e) {
        die("Erro ao alterar senha: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['cpf'], $_POST['telefone'], $_POST['email'])) {
        alterarDadosCliente($_POST['nome'], $_POST['cpf'], $_POST['telefone'], $_POST['email']);
    } elseif (isset($_POST['nova_senha'])) {
        alterarSenhaCliente($_POST['senha_antiga'], $_POST['nova_senha'], $_POST['nova_senha_confirm']);
    }
}

$cliente = retornaDadosCliente();
?>
<div class="container-alterar-dados">
    <div class="bordas-alterar-dados">
        <div class="card-alterar-dados">
            <h3 class="titulo">Alteração de dados pessoais</h3>

            <form method="post">
                <div class="mb-3 card-alt-dados">
                    <label for="nome" class="form-label">Nome do cliente:</label>
                    <input type="text" id="nome" name="nome" class="form-control" required
                        value="<?= htmlspecialchars($cliente['nome']) ?>">
                </div>
                <div class="mb-3 card-alt-dados">
                    <label for="cpf" class="form-label">CPF:</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" maxlength="11" required
                        value="<?= htmlspecialchars($cliente['cpf']) ?>">
                </div>
                <div class="mb-3 card-alt-dados">
                    <label for="telefone" class="form-label">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" maxlength="11" required
                        value="<?= htmlspecialchars($cliente['telefone']) ?>">
                </div>
                <div class="mb-3 card-alt-dados">
                    <label for="email" class="form-label">Email do cliente:</label>
                    <input type="email" id="email" name="email" class="form-control" required
                        value="<?= htmlspecialchars($cliente['email']) ?>">
                </div>

                <div class="mb-3 titulo">
                    <button type="submit" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-secondary"
                        onclick="window.location.href='principal.php';">Voltar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="bordas-alterar-dados">
        <div class="card-alterar-dados">
            <h3 class="titulo">Alteração da Senha</h3>

            <form method="post">
                <div class="mb-3 card-alt-dados">
                    <label for="senha_antiga" class="form-label">Informe a senha atual</label>
                    <input type="password" id="senha_antiga" name="senha_antiga" class="form-control" required
                        placeholder="Informe a senha atual">
                </div>
                <div class="mb-3 card-alt-dados">
                    <label for="nova_senha" class="form-label">Informe a nova senha</label>
                    <input type="password" id="nova_senha" name="nova_senha" class="form-control" required
                        placeholder="Informe a nova senha">
                </div>
                <div class="mb-3 card-alt-dados">
                    <label for="nova_senha_confirm" class="form-label">Repita a nova senha</label>
                    <input type="password" id="nova_senha_confirm" name="nova_senha_confirm" class="form-control"
                        required placeholder="Confirme a nova senha">
                </div>

                <div class="mb-3 titulo">
                    <button type="submit" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-secondary"
                        onclick="window.location.href='principal.php';">Voltar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once('rodape.php');
?>