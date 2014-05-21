<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <sitemap>
      <loc><?php echo Router::url('/sitemaps/static_links.xml',true); ?></loc>
      <lastmod><?php echo trim($time->toAtom(time())); ?></lastmod>
   </sitemap>
   <sitemap>
      <loc><?php echo Router::url('/sitemaps/categories.xml',true); ?></loc>
      <lastmod><?php echo trim($time->toAtom(time())); ?></lastmod>
   </sitemap>
   <sitemap>
      <loc><?php echo Router::url('/files/sitemap/products.xml.gz',true); ?></loc>
      <lastmod><?php echo trim($time->toAtom(time())); ?></lastmod>
   </sitemap>
   <sitemap>
      <loc><?php echo Router::url('/files/sitemap/products1.xml.gz',true); ?></loc>
      <lastmod><?php echo trim($time->toAtom(time())); ?></lastmod>
   </sitemap>
</sitemapindex>