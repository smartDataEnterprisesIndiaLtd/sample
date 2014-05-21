<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    if(isset($products) && !empty($products)) {
    foreach ($products as $product){?>
    <url>
        <loc><?php echo Router::url('/'.$this->Common->getProductUrl($product['Product']['id']).'/categories/productdetail/'.$product['Product']['id'],true); ?></loc>
        <lastmod><?php echo trim($time->toAtom(time())); ?></lastmod>
    </url>
    
    <?php } } ?>
</urlset>