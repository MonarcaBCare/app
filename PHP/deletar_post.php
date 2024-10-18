<?php
session_start();

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

// Obter o ID da postagem a ser deletada
if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Verificar se a postagem pertence ao usuário logado
    $sql = "DELETE FROM posts WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $post_id, $usuario_id);
    
    if ($stmt->execute()) {
        echo "Postagem deletada com sucesso.";
        header("Location: fy.php"); // Redirecionar para a página principal após deletar
    } else {
        echo "Erro ao deletar a postagem: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
