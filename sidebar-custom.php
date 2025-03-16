<aside id="custom-sidebar">
    <?php if (is_active_sidebar('custom-sidebar')) : ?>
        <?php dynamic_sidebar('custom-sidebar'); ?>
    <?php else : ?>
        <p>No widgets added yet. Go to Appearance > Widgets to add some.</p>
    <?php endif; ?>
</aside>
