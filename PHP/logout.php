<?php
session_start(); // Iniciar a sessão
session_unset(); // Limpar todas as variáveis de sessão
session_destroy(); // Destruir a sessão

// Redirecionar para a página de login
header("Location: login.php");
exit();
?>
