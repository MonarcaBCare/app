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
$sql = "SELECT nome, email, fotos_perfil FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// Verifica se o nome ou o email está vazio
$perfilIncompleto = empty($usuario['nome']) || empty($usuario['email']);

if ($perfilIncompleto) {
    header("Location: completar_perfil.php"); // Redirecionar para completar o perfil
    exit();
}

// Processar o upload da nova foto de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_perfil'])) {
    $uploadDir = 'uploads/';
    $fotoPerfil = basename($_FILES['foto_perfil']['name']);
    $fotoPath = $uploadDir . $fotoPerfil;

    // Mover a imagem para o diretório de uploads
    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $fotoPath)) {
        // Atualizar o caminho da foto no banco de dados
        $sqlUpdate = "UPDATE usuarios SET fotos_perfil = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param('si', $fotoPerfil, $usuario_id);
        
        if ($stmtUpdate->execute()) {
            echo "Foto de perfil atualizada com sucesso!";
            $_SESSION['fotos_perfil'] = $fotoPerfil; // Atualiza a sessão com a nova foto
        } else {
            echo "Erro ao atualizar a foto de perfil: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        echo "Erro ao enviar a foto.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - App Monarca</title>
</head>
<body>
    <header>
        <h1>Perfil do Usuário</h1>
    </header>

    <main>
        <h2><?php echo htmlspecialchars($usuario['nome']); ?></h2>
        <!-- Exibir a foto de perfil do usuário -->
        <?php if (!empty($usuario['fotos_perfil'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($usuario['fotos_perfil']); ?>" alt="Foto de perfil" width="100">
        <?php else: ?>
            <p>Foto de perfil não disponível.</p>
        <?php endif; ?>
        
        <p>Email: <?php echo htmlspecialchars($usuario['email']); ?></p>

        <!-- Formulário para upload da nova foto de perfil -->
        <form action="" method="post" enctype="multipart/form-data">
            <label for="foto_perfil">Escolha uma nova foto de perfil:</label>
            <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" required>
            <button type="submit">Atualizar Foto de Perfil</button>
        </form>
    </main>
    <div style="margin: 20px;">
    <a href="fy.php" class="btn-voltar">Voltar para o Feed</a>
</div>


    <footer>
        <a href="logout.php">Sair</a>
    </footer>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="perfil.css"> <!-- Link para o CSS -->
<!-- </head>
<body>
    <div class="profile-header">
        <img src="profile-picture.jpg" alt="Foto de Perfil" class="profile-picture">
        <h2 class="profile-name">Nome do Usuário</h2>
        <p class="profile-email">email@exemplo.com</p>
        <input type="file" id="profilePictureInput" accept="image/*" />
        <button class="edit-profile-button">Editar Perfil</button>
    </div>
    
        <div class="profile-details">
            <h3>Sobre Mim</h3>
            <p>Descrição do usuário vai aqui.</p>
            
            <h3>Atividades Recentes</h3>
            <ul class="activity-list">
                <li>Atividade 1</li>
                <li>Atividade 2</li>
                <li>Atividade 3</li>
            </ul>
        </div>
        <button class="edit-profile-button">Editar Perfil</button>
    </div>

    <!-- Modal para edição de perfil -->
    <!-- Modal para edição de perfil -->
<!-- <div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="editProfileForm">
            <label for="name">Nome:</label>
            <input type="text" id="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" required>
            <button type="submit">Salvar</button>
        </form>
    </div>
</div>
<div class="back-button">
    <a href="fy.html">Voltar</a>
</div>
    Script JavaScript -->
    <!-- <script src="script.js"></script> Link para o JavaScript -->
<!-- </body>
</html>   -->
