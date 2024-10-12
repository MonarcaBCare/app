<?php
session_start(); // Iniciar a sessão

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'meu_banco');
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Atualizar perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    
    // Atualizar o nome no banco de dados
    $sql = "UPDATE usuarios SET nome = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $nome, $_SESSION['usuario_id']);

    if ($stmt->execute()) {
        // Atualizar a sessão com o novo nome
        $_SESSION['usuario_nome'] = $nome;
        header("Location: fy.php"); // Redirecionar de volta à página principal
        exit();
    } else {
        echo "Erro ao atualizar perfil: " . $stmt->error;
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
    <title>Completar Perfil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Completar Perfil</h1>

    <form action="completar_perfil.php" method="POST">
        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>" required>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
