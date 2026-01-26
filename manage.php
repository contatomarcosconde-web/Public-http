<?php
require __DIR__ . '/lib/storage.php';
require __DIR__ . '/lib/layout.php';

$channels = load_channels();
$editingId = isset($_GET['id']) ? trim((string)$_GET['id']) : '';
$editingChannel = $editingId !== '' ? find_channel($channels, $editingId) : null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $existing = null;
        if (!empty($_POST['id'])) {
            $existing = find_channel($channels, (string)$_POST['id']);
        }

        $payload = normalize_channel_input($_POST, $existing);
        $coverPath = $existing['cover'] ?? '';
        $coverUrl = trim((string)($_POST['cover_url'] ?? ''));

        if ($coverUrl !== '') {
            if (!filter_var($coverUrl, FILTER_VALIDATE_URL)) {
                $error = 'Informe uma URL de capa válida.';
            } else {
                if ($coverPath && strpos($coverPath, 'uploads/') === 0) {
                    safe_delete_cover($coverPath);
                }
                $coverPath = $coverUrl;
            }
        } elseif (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $coverPath = process_cover_upload($_FILES['cover'], $coverPath, $error);
        } elseif (!empty($_POST['remove_cover'])) {
            safe_delete_cover($coverPath);
            $coverPath = '';
        }

        $payload['cover'] = $coverPath;

        if ($payload['name'] === '' || $payload['category'] === '' || $payload['iframe'] === '') {
            $error = 'Preencha nome, categoria e iframe.';
        }

        if ($error === '') {
            $channels = update_channel($channels, $payload);
            save_channels($channels);
            header('Location: manage.php');
            exit;
        }
    }

    if ($action === 'delete') {
        $deleteId = trim((string)($_POST['id'] ?? ''));
        if ($deleteId !== '') {
            $channel = find_channel($channels, $deleteId);
            if ($channel) {
                safe_delete_cover($channel['cover'] ?? '');
            }
            $channels = delete_channel($channels, $deleteId);
            save_channels($channels);
        }
        header('Location: manage.php');
        exit;
    }
}

render_head('Gerenciar', 'css/manage.css');
?>

<section class="manage-layout">
    <div>
        <div class="panel">
            <h2 class="panel-title"><?php echo $editingChannel ? 'Editar canal' : 'Adicionar canal'; ?></h2>

            <?php if ($error !== ''): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data" class="form">
                <input type="hidden" name="action" value="save">
                <?php if ($editingChannel): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($editingChannel['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php endif; ?>

                <label class="form-field">
                    Nome
                    <input class="input" type="text" name="name" value="<?php echo htmlspecialchars($editingChannel['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Ex: Sport TV">
                </label>

                <label class="form-field">
                    Categoria
                    <input class="input" type="text" name="category" value="<?php echo htmlspecialchars($editingChannel['category'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Ex: Esportes">
                </label>

                <label class="form-field">
                    Iframe do player
                    <textarea class="textarea" name="iframe" placeholder="Cole aqui o iframe do streaming"><?php echo htmlspecialchars($editingChannel['iframe'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </label>

                <label class="form-field">
                    Capa por URL
                    <input class="input" type="url" name="cover_url" placeholder="https://exemplo.com/capa.jpg" value="<?php echo (isset($editingChannel['cover']) && preg_match('/^https?:\/\//i', $editingChannel['cover'])) ? htmlspecialchars($editingChannel['cover'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                    <span class="help-text">Se preencher a URL, ela tem prioridade sobre o upload.</span>
                </label>

                <label class="form-field">
                    Capa por upload (JPG, PNG ou WEBP)
                    <input class="input" type="file" name="cover" accept="image/png,image/jpeg,image/webp">
                </label>

                <input type="hidden" name="block_popups" value="0">
                <label class="checkbox">
                    <input type="checkbox" name="block_popups" value="1" <?php echo ($editingChannel ? !empty($editingChannel['block_popups']) : true) ? 'checked' : ''; ?>>
                    Bloquear popups/novas abas do player
                </label>

                <?php if (!empty($editingChannel['cover'])): ?>
                    <div class="cover-preview">
                        <img src="<?php echo htmlspecialchars($editingChannel['cover'], ENT_QUOTES, 'UTF-8'); ?>" alt="Capa atual">
                    </div>
                    <label class="checkbox">
                        <input type="checkbox" name="remove_cover" value="1">
                        Remover capa atual
                    </label>
                <?php endif; ?>

                <button class="btn btn-primary" type="submit">
                    <?php echo $editingChannel ? 'Salvar alterações' : 'Adicionar canal'; ?>
                </button>

                <?php if ($editingChannel): ?>
                    <a class="link-muted" href="manage.php">Cancelar edição</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div>
        <div class="panel">
            <h2 class="panel-title">Canais cadastrados</h2>

            <?php if (count($channels) === 0): ?>
                <div class="empty-state">Nenhum canal cadastrado.</div>
            <?php else: ?>
                <div class="channel-list">
                    <?php foreach ($channels as $channel): ?>
                        <div class="channel-item">
                            <div class="channel-info">
                                <div class="thumb">
                                    <?php if (!empty($channel['cover'])): ?>
                                        <img src="<?php echo htmlspecialchars($channel['cover'], ENT_QUOTES, 'UTF-8'); ?>" alt="Capa">
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="channel-title"><?php echo htmlspecialchars($channel['name'] ?? 'Sem nome', ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div class="channel-category"><?php echo htmlspecialchars($channel['category'] ?? 'Sem categoria', ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                            </div>
                            <div class="channel-actions">
                                <a class="btn btn-secondary" href="player.php?id=<?php echo urlencode($channel['id'] ?? ''); ?>">Play</a>
                                <a class="btn btn-secondary" href="manage.php?id=<?php echo urlencode($channel['id'] ?? ''); ?>">Editar</a>
                                <form method="post" onsubmit="return confirm('Deseja excluir este canal?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($channel['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <button class="btn btn-danger" type="submit">Excluir</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php render_footer(); ?>
