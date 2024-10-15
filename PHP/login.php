<?php
session_start(); // Iniciar a sessão

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'meu_banco');
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();

        // Verificar se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            // Armazenar os dados do usuário na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome']; // Alterei de usuario_nome para nome
            $_SESSION['email'] = $usuario['email']; // Alterei de usuario_email para email

            // Redirecionar para a página principal (fy.php)
            header("Location: fy.php");
            exit();
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "E-mail não encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($erro)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Entrar</button>
    </form>

    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
</body>
</html>
