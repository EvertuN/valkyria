<?php
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);

$rota = explode('/', $url);

// Página inicial
$pagina = !empty($rota[0]) ? $rota[0] : 'home';

// Caminho do arquivo
$arquivo = "pages/$pagina.php";

if (file_exists($arquivo)) {
    require $arquivo;
} else {
    http_response_code(404);
    echo "Página não encontrada!";
}
