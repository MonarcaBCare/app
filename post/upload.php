<?php 
// Inicie a sessão
session_start();

// Verifique se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    die("Usuário não autenticado. Acesse a página de login."); // Mensagem de erro
}

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'meu_banco');
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar informações do usuário da sessão
    $usuario_id = $_SESSION['usuario_id'];
    $nomes_usuario = $_SESSION['usuario_nome']; // Supondo que você armazena o nome do usuário na sessão

    // Recuperar texto da postagem
    $texto = $_POST['texto'];
    $foto = null;
    $video = null;

    // Diretório para upload
    $uploadDir = __DIR__ . '/uploads/';

    // Criar o diretório de upload se não existir
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Permissões de leitura e execução
    }

    // Verificar se uma foto foi enviada
    if (!empty($_FILES['foto']['name'])) {
        $foto = basename($_FILES['foto']['name']);
        $fotoPath = $uploadDir . $foto;

        // Mover a foto para o diretório de uploads
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $fotoPath)) {
            // Foto carregada com sucesso
        } else {
            echo "Erro ao enviar a foto.";
            exit; // Adicionar um exit se o upload falhar
        }
    }

    // Verificar se um vídeo foi enviado
    if (!empty($_FILES['video']['name'])) {
        $video = basename($_FILES['video']['name']);
        $videoPath = $uploadDir . $video;

        // Mover o vídeo para o diretório de uploads
        if (!move_uploaded_file($_FILES['video']['tmp_name'], $videoPath)) {
            echo "Erro ao enviar o vídeo.";
            exit; // Adicionar um exit se o upload falhar
        }
    }

    // Inserir dados no banco de dados
    $sql = "INSERT INTO posts (texto, foto, video, usuario_id, nomes_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param('sssis', $texto, $foto, $video, $usuario_id, $nomes_usuario);

    if ($stmt->execute()) {
        // Redirecionar para a página de postagens
        header("Location: ../PHP/fy.php"); // Altere para o nome correto do seu arquivo de postagens
        exit; // Certifique-se de chamar exit após o redirecionamento
    } else {
        echo "Erro ao criar postagem: " . $stmt->error;
    }

    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>
