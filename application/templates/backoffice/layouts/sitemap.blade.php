<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd
    http://www.w3.org/1999/xhtml http://www.w3.org/2002/08/xhtml/xhtml1-strict.xsd"
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach($products as $product)
        <url>
            <loc>{{ URL . "" . $product->lang . "/products/" . $product->slug }}</loc>
            @if(isset($product->related) && !empty($product->related))
                @foreach($product->related as $p)
                    <xhtml:link rel="alternate" hreflang="{{$p->lang}}" href="{{ URL . '' . $p->lang . '/products/' . $p->slug }}"/> 
                @endforeach
            @endif  
            <lastmod>2011-12-06T17:38:21-00:00</lastmod>
            <priority>0.8</priority>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
    @foreach($pages as $page)
        <url>
            <loc>{{ URL . "" . $page->lang . "/ages/" . $page->url }}</loc>   
            @if(isset($page->related) && !empty($page->related))
                @foreach($page->related as $p)
                    <xhtml:link rel="alternate" hreflang="{{$p->lang}}" href="{{ URL . '' . $p->lang . '/pages/' . $p->slug }}"/> 
                @endforeach
            @endif        
            <lastmod>2011-12-06T17:38:21-00:00</lastmod>
            <priority>0.8</priority>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
    @foreach($news as $new)
        <url>
            <loc>{{ URL . "" . $new->lang . "/news/" . $new->slug }}</loc>
            @if(isset($new->related) && !empty($new->related))
                @foreach($new->related as $p)
                    <xhtml:link rel="alternate" hreflang="{{$p->lang}}" href="{{ URL . '' . $p->lang . '/news/' . $p->slug }}"/> 
                @endforeach
            @endif 
            <lastmod>2011-12-06T17:38:21-00:00</lastmod>
            <priority>0.8</priority>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
    @foreach($constructions as $construction)
        <url>
            <loc>{{ URL . "" . $construction->lang . "/constructions/" . $construction->slug }}</loc>
            @if(isset($construction->related) && !empty($construction->related))
                @foreach($construction->related as $p)
                    <xhtml:link rel="alternate" hreflang="{{$p->lang}}" href="{{ URL . '' . $p->lang . '/constructions/' . $p->slug }}"/> 
                @endforeach
            @endif 
            <lastmod>2011-12-06T17:38:21-00:00</lastmod>
            <priority>0.8</priority>
            <changefreq>weekly</changefreq>
        </url>
    @endforeach
    @foreach($front_pages as $f_page)
        @foreach($f_page as $p)
            <url>
                <loc>{{ URL . $p }}</loc>
                <lastmod>2011-12-06T17:38:21-00:00</lastmod>
                <priority>1.0</priority>
                <changefreq>weekly</changefreq>
            </url>
         @endforeach
    @endforeach
</urlset>