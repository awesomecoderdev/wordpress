<?php

global $product;

?>

<?php if ($product->get_attribute('pa_size')) : ?>
    <?php $sizes = wc_get_product_terms($product->get_id(), 'pa_size'); ?>
    <h2 class="text-base font-semibold"><?php _e("Select Size", "lumi") ?></h2>
    <div class="relative flex flex-wrap gap-3 product-sizes">
        <?php foreach ($sizes as $key => $size) : ?>
            <div class="w-10 h-10 flex justify-center items-center cursor-pointer overflow-hidden font-semibold rounded-lg border-2 product-sizes-item <?php echo $key == 0 ? "active" : "" ?>" id="product-sizes-item" data-size="<?php echo $size?->slug; ?>">
                <?php echo strtoupper(substr($size->name, 0, 2)); ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>