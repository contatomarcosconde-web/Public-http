<?php
require __DIR__ . '/lib/storage.php';
require __DIR__ . '/lib/layout.php';

$channels = load_channels();
$categories = array_values(array_unique(array_filter(array_map(function ($channel) {
    return trim((string)($channel['category'] ?? ''));
}, $channels))));
sort($categories);

$selectedCategory = isset($_GET['category']) ? trim((string)$_GET['category']) : '';
$filtered = $channels;
if ($selectedCategory !== '') {
    $filtered = array_values(array_filter($channels, function ($channel) use ($selectedCategory) {
        return strtolower((string)($channel['category'] ?? '')) === strtolower($selectedCategory);
    }));
}

render_head('Início', 'css/index.css');
?>

<!--
<section class="hero">
    <div>
        <h2>Seu catálogo Canais Free</h2>
        <p>Canais gratuitos para você assistir online.</p>
    </div>
</section>
-->

<section class="section">
    <h2 class="section-title">Categorias</h2>
    <div class="category-list">
        <a class="category-pill <?php echo $selectedCategory === '' ? 'active' : ''; ?>" href="index.php">Todas</a>
        <?php foreach ($categories as $category): ?>
            <?php $active = strtolower($selectedCategory) === strtolower($category); ?>
            <a class="category-pill <?php echo $active ? 'active' : ''; ?>" href="index.php?category=<?php echo urlencode($category); ?>">
                <?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="section">
    <div class="section-header">
        <h2 class="section-title">Canais</h2>
    </div>

    <?php if (count($filtered) === 0): ?>
        <div class="empty-state">Nenhum canal encontrado.</div>
    <?php else: ?>
        <div class="card-grid">
            <?php foreach ($filtered as $channel): ?>
                <a class="card" href="player.php?id=<?php echo urlencode($channel['id'] ?? ''); ?>">
                    <div class="card-image">
                        <?php if (!empty($channel['cover'])): ?>
                            <img src="<?php echo htmlspecialchars($channel['cover'], ENT_QUOTES, 'UTF-8'); ?>" alt="Capa">
                        <?php else: ?>
                            <div class="card-placeholder">
                                <?php echo htmlspecialchars($channel['name'] ?? 'Canal', ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-info">
                        <h3><?php echo htmlspecialchars($channel['name'] ?? 'Sem nome', ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><?php echo htmlspecialchars($channel['category'] ?? 'Sem categoria', ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php render_footer(); ?>
