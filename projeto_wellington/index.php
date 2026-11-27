<?php
$mensagem = "";

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_aluno   = htmlspecialchars(trim($_POST['nome_aluno']));
    $responsavel  = htmlspecialchars(trim($_POST['responsavel']));
    $telefone     = htmlspecialchars(trim($_POST['telefone']));
    $email        = htmlspecialchars(trim($_POST['email']));
    $nivel        = htmlspecialchars(trim($_POST['nivel']));
    $data_envio   = date("d/m/Y H:i:s");

    if (!empty($nome_aluno) && !empty($responsavel) && !empty($telefone)) {
        $arquivo = 'matriculas.csv';
        $novo_arquivo = !file_exists($arquivo);

        // Abre ou cria o arquivo CSV para salvar os dados
        $fp = fopen($arquivo, 'a');
        
        // Adiciona cabeçalho se for a primeira vez
        if ($novo_arquivo) {
            fputcsv($fp, ['Data', 'Nome do Aluno', 'Responsavel', 'Telefone', 'E-mail', 'Nivel de Ensino'], ';');
        }

        // Grava os dados do formulário
        fputcsv($fp, [$data_envio, $nome_aluno, $responsavel, $telefone, $email, $nivel], ';');
        fclose($fp);

        $mensagem = "<div class='alerta-sucesso'>Pré-matrícula de <strong>$nome_aluno</strong> enviada com sucesso! Nossa secretaria entrará em contato em breve.</div>";
    } else {
        $mensagem = "<div class='alerta-erro'>Por favor, preencha todos os campos obrigatórios.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colégio Horizonte - Educação que Transforma</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Cabeçalho -->
    <header>
        <div class="logo">Colégio <span>Horizonte</span></div>
        <nav>
            <ul>
                <li><a href="#inicio">Início</a></li>
                <li><a href="#sobre">A Escola</a></li>
                <li><a href="#ensino">Níveis de Ensino</a></li>
                <li><a href="#matricula">Pré-Matrícula</a></li>
                <li><a href="admin.php" class="btn-admin">Área da Secretaria</a></li>
            </ul>
        </nav>
    </header>

    <!-- Banner Principal -->
    <div class="hero" id="inicio">
        <h1>Construindo o Futuro com Excelência</h1>
        <p>Ensino inovador, acolhimento humano e tecnologia para preparar seu filho para os desafios do mundo.</p>
        <a href="#matricula" class="btn-cta">Faça sua Pré-Matrícula</a>
    </div>

    <!-- Seção Sobre -->
    <section id="sobre">
        <h2 class="titulo-secao">Sobre o Colégio Horizonte</h2>
        <div class="sobre-grid">
            <div>
                <img src="https://unsplash.com" alt="Sala de aula moderna">
            </div>
            <div>
                <h3>Tradição e Inovação Pedagógica</h3>
                <br>
                <p>Com uma infraestrutura completa, laboratórios modernos, quadras poliesportivas e biblioteca interativa, o <strong>Colégio Horizonte</strong> oferece um ambiente seguro e estimulante para o desenvolvimento integral dos estudantes.</p>
                <br>
                <p>Nossa equipe de professores é altamente qualificada e utiliza metodologias ativas que incentivam o pensamento crítico, a criatividade e o trabalho em equipe desde os primeiros anos escolares.</p>
            </div>
        </div>
    </section>

    <!-- Seção Níveis de Ensino -->
    <section id="ensino">
        <h2 class="titulo-secao">Níveis de Ensino</h2>
        <div class="cards-container">
            <div class="card">
                <img src="https://unsplash.com" alt="Educação Infantil">
                <div class="card-body">
                    <h3>Educação Infantil</h3>
                    <p>Desenvolvimento motor, social e cognitivo através do brincar, da arte e da descoberta em um espaço seguro e lúdico.</p>
                </div>
            </div>

            <div class="card">
                <img src="https://unsplash.com" alt="Ensino Fundamental">
                <div class="card-body">
                    <h3>Ensino Fundamental</h3>
                    <p>Base sólida em leitura, matemática, ciências, idiomas e robótica educacional para estimular a curiosidade científica.</p>
                </div>
            </div>

            <div class="card">
                <img src="https://unsplash.com" alt="Ensino Médio">
                <div class="card-body">
                    <h3>Ensino Médio</h3>
                    <p>Preparação intensiva para o ENEM e principais vestibulares, com orientação vocacional e projetos de vida.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Formulário de Pré-Matrícula -->
    <section id="matricula">
        <h2 class="titulo-secao">Solicite uma Pré-Matrícula ou Visita</h2>
        <div class="form-container">
            
            <!-- Exibe mensagem de confirmação do PHP -->
            <?php echo $mensagem; ?>

            <form action="index.php#matricula" method="POST">
                <div class="form-group">
                    <label for="nome_aluno">Nome Completo do Aluno *</label>
                    <input type="text" id="nome_aluno" name="nome_aluno" required placeholder="Ex: Lucas Silva">
                </div>

                <div class="form-group">
                    <label for="responsavel">Nome do Responsável *</label>
                    <input type="text" id="responsavel" name="responsavel" required placeholder="Ex: Mariana Silva">
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone / WhatsApp *</label>
                    <input type="tel" id="telefone" name="telefone" required placeholder="(61) 99999-9999">
                </div>

                <div class="form-group">
                    <label for="email">E-mail para Contato</label>
                    <input type="email" id="email" name="email" placeholder="email@exemplo.com">
                </div>

                <div class="form-group">
                    <label for="nivel">Nível de Ensino Desejado *</label>
                    <select id="nivel" name="nivel" required>
                        <option value="Educação Infantil">Educação Infantil</option>
                        <option value="Ensino Fundamental I">Ensino Fundamental I (1º ao 5º ano)</option>
                        <option value="Ensino Fundamental II">Ensino Fundamental II (6º ao 9º ano)</option>
                        <option value="Ensino Médio">Ensino Médio</option>
                    </select>
                </div>

                <button type="submit" class="btn-submit">Enviar Solicitação</button>
            </form>
        </div>
    </section>

    <!-- Rodapé -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Colégio Horizonte - Todos os direitos reservados.</p>
        <p>Endereço: Av. Principal, nº 1000 - Centro | Telefone: (61) 3333-4444</p>
    </footer>

</body>
</html>
