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
    
    <!-- Novo título centralizado -->
    <h1 class="header-center-title">Minha Trajetória</h1>
    
    <div>
    <a href="logout.php" class="header-menu">SAIR</a>
    </div>
</header>
    <main>
        <!-- Exibir as postagens do banco de dados -->
        <?php
        // Buscar as postagens com informações do usuário, ordenadas pelo ID em ordem decrescente
        $sql = "SELECT posts.*, usuarios.nome, usuarios.pic_perfil FROM posts 
                JOIN usuarios ON posts.usuario_id = usuarios.id 
                ORDER BY posts.id DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<div class='post-header'>";
                echo "<img src='uploads/" . htmlspecialchars($row['pic_perfil']) . "' alt='Foto de Perfil' class='post-icon' width='50' height='50'>";
                echo "<span class='post-username'>" . htmlspecialchars($row['nome']) . "</span>";
                
                // Verificar se a postagem pertence ao usuário logado para mostrar o botão de deletar
                if ($row['usuario_id'] == $usuario_id) {
                    echo "<form method='POST' action='deletar_post.php' style='display:inline;'>";
                    echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' class='delete-btn'>Deletar</button>";
                    echo "</form>";
                }

                echo "</div>";
                echo "<div class='post-body'>";
                echo "<p>" . htmlspecialchars($row['texto']) . "</p>";

                // Exibir foto se existir
                if (!empty($row['foto'])) {
                    $fotoPath = '../post/uploads/' . htmlspecialchars($row['foto']);
                    if (file_exists($fotoPath)) {
                        echo "<img src='" . $fotoPath . "' alt='Postagem' class='post-img' style='max-width: 100%; height: auto;'>";
                    } else {
                        echo "<p>Imagem não encontrada no caminho: " . $fotoPath . "</p>";
                    }
                }

                // Exibir vídeo se existir
                if (!empty($row['video'])) {
                    $videoPath = '../post/uploads/' . htmlspecialchars($row['video']);
                    if (file_exists($videoPath)) {
                        echo "<video width='300' controls>
                                <source src='" . $videoPath . "' type='video/mp4'>
                                Seu navegador não suporta vídeos.
                              </video>";
                    } else {
                        echo "<p>Vídeo não encontrado no caminho: " . $videoPath . "</p>";
                    }
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
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body, html {
    font-family: 'Arial', sans-serif;
    background-color: #fff;
    color: #000;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #fff;
    border-bottom: 1px solid #ccc;
    position: relative; /* Necessário para centralizar o título */
}

.header-title {
    font-weight: bold;
    color: #FF6D00;
}

.header-center-title {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    font-size: 20px;
    color: #FF6D00;
    font-weight: bold;
}

.header-menu {
    color: #FF6D00;
}


main {
    padding: 10px 20px;
}

.post {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    margin-bottom: 20px;
    padding: 10px;
}

.post-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.post-icon {
    width: 40px;
    height: 40px;
    margin-right: 10px;
}

.post-username {
    font-weight: bold;
}

.post-body p {
    margin-bottom: 10px;
}

.post-image {
    width: 100%;
    border-radius: 10px;
}

.play-button {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.play-icon {
    width: 50px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.bottom-nav {
    display: flex;
    justify-content: space-around;
    align-items: center;
    position: fixed;
    bottom: 0;
    width: 100%;
    background-color: #fff;
    border-top: 1px solid #ccc;
    padding: 10px 0;
}

.nav-item {
    text-align: center;
}

.nav-icon {
    width: 30px;
}

.post1{
    width: 50%;
}


       .delete-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
    border-radius: 50px;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-left: auto; /* Empurra o botão para o lado direito */
}

.delete-btn:hover {
    background-color: #c0392b;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    transform: scale(1.05);
}

.delete-btn i {
    font-size: 16px;
}
    </style>

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
