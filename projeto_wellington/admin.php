<?php
session_start();

// Senha de acesso da secretaria (Altere para uma senha forte em produção)
$senha_correta = "escola2026";

// Sair do sistema
if (isset($_GET['sair'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Verifica login
$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['senha'])) {
    if ($_POST['senha'] === $senha_correta) {
        $_SESSION['logado'] = true;
    } else {
        $erro = "Senha incorreta! Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Secretaria - Colégio Horizonte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="logo">Painel <span>Secretaria</span></div>
        <nav>
            <ul>
                <li><a href="index.php">Voltar ao Site</a></li>
                <?php if (isset($_SESSION['logado'])): ?>
                    <li><a href="admin.php?sair=1" class="btn-admin">Sair</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section>
        <?php if (!isset($_SESSION['logado'])): ?>
            <!-- Tela de Login -->
            <div class="form-container" style="max-width: 400px; margin-top: 40px;">
                <h2 style="text-align:center; color:#003366; margin-bottom:20px;">Acesso Restrito</h2>
                <?php if ($erro) echo "<div class='alerta-erro'>$erro</div>"; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="senha">Senha da Secretaria:</label>
                        <input type="password" id="senha" name="senha" required placeholder="Digite a senha">
                    </div>
                    <button type="submit" class="btn-submit">Entrar</button>
                </form>
                <p style="text-align:center; margin-top:15px; font-size:0.85rem; color:#666;">
                    Senha padrão de teste: <strong>escola2026</strong>
                </p>
            </div>

        <?php else: ?>
            <!-- Painel de Dados -->
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px;">
                <h2>Solicitações de Pré-Matrícula</h2>
                <?php if (file_exists('matriculas.csv')): ?>
                    <a href="matriculas.csv" download class="btn-cta" style="font-size:0.95rem;">Baixar Planilha (CSV / Excel)</a>
                <?php endif; ?>
            </div>

            <?php
            if (file_exists('matriculas.csv')) {
                echo "<div style='overflow-x:auto;'><table>";
                $fp = fopen('matriculas.csv', 'r');
                $linha_numero = 0;

                while (($dados = fgetcsv($fp, 1000, ';')) !== FALSE) {
                    echo "<tr>";
                    foreach ($dados as $celula) {
                        if ($linha_numero == 0) {
                            echo "<th>" . htmlspecialchars($celula) . "</th>";
                        } else {
                            echo "<td>" . htmlspecialchars($celula) . "</td>";
                        }
                    }
                    echo "</tr>";
                    $linha_numero++;
                }
                fclose($fp);
                echo "</table></div>";
            } else {
                echo "<p style='margin-top:20px; background:#fff; padding:20px; border-radius:8px;'>Nenhuma solicitação de matrícula recebida até o momento.</p>";
            }
            ?>
        <?php endif; ?>
    </section>

</body>
</html>
