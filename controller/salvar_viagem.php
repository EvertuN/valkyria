<?php
global $conn;
require __DIR__ . '/../config/conexao.php'; // Ajuste o caminho conforme seu projeto

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // ====== DADOS PRINCIPAIS ======
        $origem = trim($_POST['origem'] ?? '');
        $destino = trim($_POST['destino'] ?? '');
        $motorista = trim($_POST['motorista'] ?? '');
        $responsavel_envio = trim($_POST['responsavel_envio'] ?? '');
        $responsavel_recebimento = trim($_POST['responsavel_recebimento'] ?? '');
        $data_envio = $_POST['data_envio'] ?? null;
        $data_prevista = $_POST['data_prevista'] ?? null;

        if (
            empty($origem) || empty($destino) || empty($motorista) ||
            empty($responsavel_envio) || empty($responsavel_recebimento) ||
            empty($data_envio) || empty($data_prevista)
        ) {
            throw new Exception("Preencha todos os campos obrigatórios.");
        }

        // ====== ITENS DA VIAGEM ======
        $itens = [];
        if (!empty($_POST['item_nome'])) {
            foreach ($_POST['item_nome'] as $i => $nome) {
                $nome = trim($nome);
                $qtd = (int) ($_POST['item_qtd'][$i] ?? 0);
                $unidade = trim($_POST['item_unidade'][$i] ?? '');

                if ($nome !== '' && $qtd > 0 && $unidade !== '') {
                    $itens[] = [
                        'nome' => $nome,
                        'qtd' => $qtd,
                        'unidade' => $unidade
                    ];
                }
            }
        }

        // ====== FROTA ======
        $frota = [];
        if (!empty($_POST['frota'])) {
            foreach ($_POST['frota'] as $descricao) {
                $descricao = trim($descricao);
                if ($descricao !== '') {
                    $frota[] = $descricao;
                }
            }
        }

        // ====== IMPLEMENTO ======
        $implemento = [];
        if (!empty($_POST['implemento'])) {
            foreach ($_POST['implemento'] as $descricao) {
                $descricao = trim($descricao);
                if ($descricao !== '') {
                    $implemento[] = $descricao;
                }
            }
        }

        // ====== INSERÇÃO NO BANCO ======
        $sql = "INSERT INTO viagens 
            (origem, destino, motorista, responsavel_envio, responsavel_recebimento, data_envio, data_prevista, itens, frota, implemento)
            VALUES (:origem, :destino, :motorista, :responsavel_envio, :responsavel_recebimento, :data_envio, :data_prevista, :itens, :frota, :implemento)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':origem' => $origem,
            ':destino' => $destino,
            ':motorista' => $motorista,
            ':responsavel_envio' => $responsavel_envio,
            ':responsavel_recebimento' => $responsavel_recebimento,
            ':data_envio' => $data_envio,
            ':data_prevista' => $data_prevista,
            ':itens' => json_encode($itens, JSON_UNESCAPED_UNICODE),
            ':frota' => json_encode($frota, JSON_UNESCAPED_UNICODE),
            ':implemento' => json_encode($implemento, JSON_UNESCAPED_UNICODE)
        ]);

        // Redireciona com sucesso
        header("Location: ../?url=home&sucesso=1");
        exit;

    } catch (Exception $e) {
        // Mostra erro de forma amigável
        header("Location: ../?url=home&erro=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    header("Location: ../?url=home");
    exit;
}
