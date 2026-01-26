<?php

function render_head(string $title, string $pageStyle = ''): void
{
    $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $safePageStyle = $pageStyle !== '' ? '<link rel="stylesheet" href="' . htmlspecialchars($pageStyle, ENT_QUOTES, 'UTF-8') . '">' : '';
    echo <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$safeTitle}</title>
    <script src="https://cdn.jsdelivr.net/npm/twind@0.16.16/shim.min.js"></script>
    <link rel="stylesheet" href="css/base.css">
    {$safePageStyle}
    <style>
        iframe { width: 100%; height: 100%; border: 0; }
    </style>
    <script>
        function handleRestrictedClick(event) {
            const senha = prompt('Digite a senha para acessar:');
            if (senha !== '300419') {
                alert('Senha incorreta.');
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</head>
<body class="app-body">
    <div class="container">
        <header class="app-header">
            <div class="brand">
                <div class="brand-badge">C.F</div>
                <div>
                    <h1>Canais Free</h1>
                    <p>Seu hub de canais online.</p>
                </div>
            </div>
            <nav class="nav">
                <a class="nav-link" href="index.php">Início</a>
                <a class="nav-link" href="manage.php" onclick="return handleRestrictedClick(event);">🔒</a>
            </nav>
        </header>
HTML;
}

function render_footer(): void
{
    $year = date('Y');
    echo <<<HTML
        <footer>© {$year} Canais Free</footer>
    </div>
</body>
</html>
HTML;
}
