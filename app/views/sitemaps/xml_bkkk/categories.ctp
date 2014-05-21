<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    if(isset($sitemapData) && !empty($sitemapData)) {
    foreach ($sitemapData as $dept_id=>$data){?>
    <url>
        <loc><?php echo Router::url('/'.$data['department'].'/departments/index/'.$dept_id,true); ?></loc>
        <lastmod><?php echo trim($time->toAtom(time())); ?></lastmod>
    </url>
     <?php
    if(isset($data['categories']) && !empty($data['categories'])) {
     foreach ($data['categories'] as $cat_id=>$categories){ ?>
    <url>
        <loc><?php echo Router::url('/'.$data['department'].'/'.$categories.'/categories/index/'.$cat_id,true); ?>
        </loc>
       <lastmod><?php echo trim($time->toAtom(time())); ?></lastmod>
    </url>
    <?php }} ?>
    
    <?php } } ?>
</urlset>