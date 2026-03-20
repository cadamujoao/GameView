<?php
// Tempo de duração: 4 dias
$tempo = 4 * 24 * 60 * 60; // 4 dias em segundos (345600)

// Configurações do cookie de sessão
session_set_cookie_params([
    'lifetime' => $tempo,                 // Dura 4 dias mesmo após fechar o navegador
    'httponly' => true,                   // Impede acesso via JS
    'secure' => isset($_SERVER['HTTPS']), // Só via HTTPS se disponível
    'samesite' => 'Lax'                   // 'Strict' pode bloquear login com POST
]);

session_start();

setcookie(session_name(), session_id(), [
    'expires'  => time() + $tempo,        // Validade do cookie = agora + 4 dias
    'path'     => '/',                    // Disponível em todo o site
    'httponly' => true,
    'secure'   => isset($_SERVER['HTTPS']),
    'samesite' => 'Lax'
]);
?>

