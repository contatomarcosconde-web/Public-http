<?php
require __DIR__ . '/lib/storage.php';
require __DIR__ . '/lib/layout.php';

$channels = load_channels();
$id = isset($_GET['id']) ? trim((string)$_GET['id']) : '';
$channel = $id !== '' ? find_channel($channels, $id) : null;

function apply_popup_block(string $iframeHtml, bool $blockPopups): string
{
    if (!$blockPopups) {
        return $iframeHtml;
    }

    if (!preg_match('/<iframe\b[^>]*>/i', $iframeHtml)) {
        return $iframeHtml;
    }

    return preg_replace_callback('/<iframe\b([^>]*)>/i', function ($matches) {
        $attrs = $matches[1] ?? '';

        if (preg_match('/\ssandbox\s*=\s*(["\"])(.*?)\1/i', $attrs, $sandboxMatch)) {
            $sandbox = preg_replace('/\ballow-popups(-to-escape-sandbox)?\b/i', '', $sandboxMatch[2]);
            $sandbox = trim(preg_replace('/\s+/', ' ', $sandbox));
            $attrs = preg_replace('/\ssandbox\s*=\s*(["\"]).*?\1/i', ' sandbox="' . $sandbox . '"', $attrs);
        } else {
            $attrs .= ' sandbox="allow-scripts allow-same-origin allow-forms allow-presentation"';
        }

        if (!preg_match('/\sallow\s*=\s*(["\"]).*?\1/i', $attrs)) {
            $attrs .= ' allow="autoplay; encrypted-media; fullscreen"';
        }

        if (!preg_match('/\sallowfullscreen\b/i', $attrs)) {
            $attrs .= ' allowfullscreen="true"';
        }

        return '<iframe' . $attrs . '>';
    }, $iframeHtml);
}

render_head('Player', 'css/player.css');
?>

<section class="player-shell">
    <?php if (!$channel): ?>
        <div class="empty-state">Canal não encontrado.</div>
    <?php else: ?>
        <div class="player-layout">
            <aside class="player-aside">
                <div class="poster">
                    <?php if (!empty($channel['cover'])): ?>
                        <img src="<?php echo htmlspecialchars($channel['cover'], ENT_QUOTES, 'UTF-8'); ?>" alt="Capa">
                    <?php else: ?>
                        <div class="poster-placeholder">
                            <?php echo htmlspecialchars($channel['name'] ?? 'Canal', ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="player-meta">
                    <h2><?php echo htmlspecialchars($channel['name'] ?? 'Sem nome', ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p><?php echo htmlspecialchars($channel['category'] ?? 'Sem categoria', ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <?php if (!empty($channel['id'])): ?>
                    <div class="player-actions">
                        <a class="btn btn-secondary" href="manage.php?id=<?php echo urlencode($channel['id']); ?>" onclick="return handleRestrictedClick(event);">✏️</a>
                    </div>
                <?php endif; ?>
            </aside>

            <div class="player-frame">
                <?php
                $iframe = $channel['iframe'] ?? '';
                $blockPopups = !empty($channel['block_popups']);
                echo apply_popup_block($iframe, $blockPopups);
                ?>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php render_footer(); ?>
