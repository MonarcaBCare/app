<?php   
session_start(); // Iniciar a sessão

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirecionar para o login se não estiver logado
    exit();
}

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'meu_banco');
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter o ID do usuário logado da sessão
$usuario_id = $_SESSION['usuario_id'];

// Verificar se o perfil do usuário está completo
$sql = "SELECT nome, email, pic_perfil FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Erro na preparação da declaração: " . $conn->error);
}

$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close(); // Fechar a declaração

// Verifica se o nome ou o email está vazio
$perfilIncompleto = empty($usuario['nome']) || empty($usuario['email']);

if ($perfilIncompleto) {
    header("Location: completar_perfil.php"); // Redirecionar para completar o perfil
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="manifest" href="../manifest.json">
    <link rel="stylesheet" href="../fy.css">
    <title>For You - App Monarca</title>
</head>
<body>
    <header>
        <div class="header-title">MONARCA</div>
        <div>
            <a href="PHP/logout.php" class="header-menu">SAIR</a>
        </div>
    </header>

    <main>
        <!-- Exibir as postagens do banco de dados -->
        <?php
        // Buscar as postagens com informações do usuário
        $sql = "SELECT posts.*, usuarios.nome, usuarios.pic_perfil FROM posts 
        JOIN usuarios ON posts.usuario_id = usuarios.id 
        ORDER BY data_postagem DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<div class='post-header'>";
        echo "<img src='uploads/" . htmlspecialchars($row['pic_perfil']) . "' alt='Foto de Perfil' class='post-icon' width='50' height='50'>";
        echo "<span class='post-username'>" . htmlspecialchars($row['nome']) . "</span>";
        echo "</div>";
        echo "<div class='post-body'>";
        echo "<p>" . htmlspecialchars($row['texto']) . "</p>";

        // Exibir foto se existir
        if (!empty($row['foto'])) {
            $fotoPath = 'uploads/' . htmlspecialchars($row['foto']);
            if (file_exists($fotoPath)) {
                echo "<img src='" . $fotoPath . "' alt='Postagem' class='post-img' style='max-width: 100%; height: auto;'>";
            } else {
                echo "<p>Imagem não encontrada no caminho: " . $fotoPath . "</p>";
            }
        } else {
            echo "<p>Nenhuma imagem encontrada para esta postagem.</p>";
        }

        // Exibir vídeo se existir
        if (!empty($row['video'])) {
            echo "<video width='300' controls>
                    <source src='uploads/" . htmlspecialchars($row['video']) . "' type='video/mp4'>
                    Seu navegador não suporta vídeos.
                  </video>";
        }

        echo "</div>"; // End post-body
        echo "</div>"; // End post
    }
} else {
    echo "<div>Nenhuma postagem encontrada.</div>";
}

$conn->close();
        ?>
    </main>

    <nav class="bottom-nav">
        <a href="fy.php">
            <i class="fa-solid fa-house" style="color: #FF9A00;"></i>
        </a>

        <a href="../videos.html">
            <i class="fa-solid fa-magnifying-glass fa-lg"></i>
        </a>

        <a href="../post/form.html">
            <i class="fa-solid fa-plus fa-xl"></i> 
        </a>

        <a href="../quiz.html">
            <i class="fa-solid fa-book-open fa-sm"></i>
        </a>

        <a href="perfil.php">
            <i class="fa-solid fa-user fa-lg"></i>
        </a>
    </nav>

    <script src="../app.js"></script>
</body>
</html>
