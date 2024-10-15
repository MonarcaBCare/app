<?php 
// Inicie a sessão
session_start();

// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'meu_banco');
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar informações do usuário da sessão
    $usuario_id = $_SESSION['usuario_id']; // Supondo que você armazena o ID do usuário na sessão

    // Verifique se o nome do usuário está definido na sessão
    if (!isset($_SESSION['nome'])) {
        die("Nome do usuário não está definido na sessão."); // Mensagem de erro
    }
    $nome_usuario = $_SESSION['nome']; // Supondo que você armazena o nome do usuário na sessão

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
            // Sucesso no upload da foto
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
        if (move_uploaded_file($_FILES['video']['tmp_name'], $videoPath)) {
            // Sucesso no upload do vídeo
        } else {
            echo "Erro ao enviar o vídeo.";
            exit; // Adicionar um exit se o upload falhar
        }
    }

    // Verificar se a foto de perfil está definida; caso contrário, definir como uma imagem padrão
    $foto_perfil = isset($_SESSION['fotos_perfil']) ? $_SESSION['fotos_perfil'] : 'default_profile_picture.png'; // Insira o caminho da sua imagem padrão

    // Inserir dados no banco de dados
    $sql = "INSERT INTO posts (texto, foto, video, usuario_id, nomes_usuario, fotos_perfil) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Verifique se a preparação da declaração falhou
    if ($stmt === false) {
        die("Erro na preparação da declaração: " . $conn->error);
    }

    // Para o caso de não haver foto ou vídeo, use valores nulos
    $foto = !empty($foto) ? $foto : null; // Caso não tenha foto, insira null no banco
    $video = !empty($video) ? $video : null; // Caso não tenha vídeo, insira null no banco

    // Bind parameters
    $stmt->bind_param('sssiis', $texto, $foto, $video, $usuario_id, $nome_usuario, $foto_perfil);

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
