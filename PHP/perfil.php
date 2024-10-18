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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pic_perfil'])) {
    $uploadDir = 'uploads/';
    $fotoPerfil = basename($_FILES['pic_perfil']['name']);
    $fotoPath = $uploadDir . $fotoPerfil;

    // Mover a imagem para o diretório de uploads
    if (move_uploaded_file($_FILES['pic_perfil']['tmp_name'], $fotoPath)) {
        // Atualizar o caminho da foto no banco de dados
        $sqlUpdate = "UPDATE usuarios SET pic_perfil = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param('si', $fotoPerfil, $usuario_id);

        if ($stmtUpdate->execute()) {
            $_SESSION['pic_perfil'] = $fotoPerfil; // Atualiza a sessão com a nova foto
        } else {
            echo "Erro ao atualizar a foto de perfil: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        echo "Erro ao enviar a foto.";
    }
}

// Processar a alteração do nome
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $novoNome = trim($_POST['nome']);

    if (!empty($novoNome)) {
        $sqlUpdateNome = "UPDATE usuarios SET nome = ? WHERE id = ?";
        $stmtUpdateNome = $conn->prepare($sqlUpdateNome);
        $stmtUpdateNome->bind_param('si', $novoNome, $usuario_id);

        if ($stmtUpdateNome->execute()) {
            $_SESSION['usuario_nome'] = $novoNome; // Atualiza o nome na sessão
        } else {
            echo "Erro ao atualizar o nome: " . $stmtUpdateNome->error;
        }

        $stmtUpdateNome->close();
    } else {
        echo "Nome não pode ser vazio.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="perfil.css">
    <title>Perfil - App Monarca</title>
</head>
<style>
    /* perfil.css */

    /* Estilos gerais */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    header {
        text-align: center;
        margin-bottom: 20px;
    }

    h1 {
        font-size: 2.5em;
        color: #333;
    }

    h2 {
        color: #555;
        margin: 10px 0;
    }

    main {
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    p {
        font-size: 1em;
        margin: 10px 0;
    }

    /* Estilos dos formulários */
    form {
        margin: 20px 0;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="file"],
    input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    button {
        background-color: #28a745;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #218838;
    }

    /* Estilo do botão de voltar */
    .btn-container {
        text-align: center;
        margin: 20px 0;
    }

    .btn-voltar {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .btn-voltar:hover {
        background-color: #0056b3;
    }

    /* Estilo do rodapé */
    footer {
        text-align: center;
        margin-top: 20px;
    }

    footer a {
        color: #007bff;
        text-decoration: none;
    }

    footer a:hover {
        text-decoration: underline;
    }

    /* Estilo do input de arquivo */
.file-input {
    display: none; /* Esconde o input padrão */
}

.file-label {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.file-label:hover {
    background-color: #0056b3;
}

</style>

<body>
    <header>
        <h1>Perfil do Usuário</h1>
    </header>

    <main>
        <h2><?php echo htmlspecialchars($usuario['nome']); ?></h2>

        <?php if (!empty($usuario['pic_perfil'])) : ?>
            <img src="uploads/<?php echo htmlspecialchars($usuario['pic_perfil']); ?>" alt="Foto de perfil">
        <?php else : ?>
            <p>Foto de perfil não disponível.</p>
        <?php endif; ?>

        <p>Email: <?php echo htmlspecialchars($usuario['email']); ?></p>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="pic_perfil" class="file-label">Escolha uma nova foto de perfil</label><br>
            <input type="file" name="pic_perfil" id="pic_perfil" accept="image/*" required class="file-input">
            <button type="submit" onclick="location.reload();">Atualizar Foto de Perfil</button>
        </form>


        <form action="" method="post">
            <label for="nome">Novo Nome:</label>
            <input type="text" name="nome" id="nome" required>
            <button type="submit"  onclick="location.reload();">Alterar Nome</button>
        </form>
    </main><br>

    <div class="btn-container">
        <a href="fy.php" class="btn-voltar">Voltar para o Feed</a>
    </div>

    <footer>
        <a href="logout.php">Sair</a>
    </footer>
</body>

</html>