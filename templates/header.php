<!-- Page Header -->
<div class="page-header">
    <?php if (isset($page_title)): ?>
        <h1 class="page-title"><?php echo htmlspecialchars($page_title); ?></h1>
    <?php endif; ?>
    <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
        <div class="breadcrumb">
            <?php foreach ($breadcrumb as $index => $item): ?>
                <?php if ($index > 0): ?>
                    <span class="breadcrumb-separator">/</span>
                <?php endif; ?>
                <a href="<?php echo htmlspecialchars($item['url']); ?>" class="breadcrumb-item">
                    <?php echo htmlspecialchars($item['label']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
