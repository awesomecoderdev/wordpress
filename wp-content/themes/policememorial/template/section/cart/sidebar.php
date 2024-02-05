<div class="relative p-4 rounded border text-base font-semibold space-y-4 xl:sticky md:sticky md:top-20 md:mt-5">
    <?php foreach (lumi_get_cart() as $key => $item) : ?>
        <?php
        // Get product details
        $product = wc_get_product($item["product_id"]);

        // You can access product data like this:
        $product_id = $product->get_id();
        $product_name = $product->get_name();
        $product_price = $product->get_price();
        $product_sku = $product->get_sku();

        $color = wc_get_product_terms($product->get_id(), 'pa_color', [
            "number" => 1,
            "slug" => isset($item['color']) ? sanitize_text_field($item['color']) : "awesomecoder",
        ])[0] ?? null;

        $size = wc_get_product_terms($product->get_id(), 'pa_size', [
            "number" => 1,
            "slug" => isset($item['size']) ? sanitize_text_field($item['size']) : "awesomecoder",
        ])[0] ?? null;


        ?>

        <div class="relative flex justify-between items-center">
            <h2 class="text-slate-500 text-sm"><?php echo $product_name; ?>
                <?php if ($color || $size) : ?>
                    <span class="text-[10px] font-medium">
                        [
                        <?php if ($color) : ?>
                            <?php echo $color->name; ?>
                        <?php endif; ?>
                        <?php if ($size) : ?>
                            , <?php echo $size->name; ?>
                        <?php endif; ?>
                        ]
                    </span>
                <?php endif; ?>

                <span class="text-xs font-normal"> x <?php echo $item["quantity"] ?? 1 ?></span>
            </h2>
            <span class="text-black"><?php echo wc_price($item["line_total"] ?? $product_price); ?></span>
        </div>
    <?php endforeach; ?>
    <hr>

    <div class="relative flex justify-between items-center">
        <h2 class="text-slate-500"><?php _e("Subtotal", "lumi") ?></h2>
        <span class="text-black"><?php echo wc_price(lumi_cart()?->get_subtotal() ?? 0); ?></span>
    </div>
    <div class="relative flex justify-between items-center">
        <h2 class="text-slate-500"><?php _e("Discount", "lumi") ?></h2>
        <span class="text-black"><?php echo wc_price(lumi_cart()?->get_discount_total() ?? 0); ?></span>
    </div>
    <hr>
    <div class="relative flex justify-between items-center">
        <h2 class="text-slate-500"><?php _e("Total", "lumi") ?></h2>
        <span class="text-black"><?php echo wc_price(lumi_get_cart_total()); ?></span>
    </div>
    <a class="w-full block text-center py-2 bg-primary-500 text-white rounded-xl font-medium text-base" href="<?php echo site_url("/checkout") ?>"><?php _e("Checkout", "lumi") ?></a>
</div>