<?php
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss version="2.0"
xmlns:g="http://base.google.com/ns/1.0">

<channel>
<title>Products Content</title> 
<link>{{URL}}</link> 
<description>Our products to sell</description> 


@foreach($array as $product)
<item> 
    <g:id>{{ $product['id'] }}</g:id>
    <title>{{ $product['title'] }}</title>
    <link>{{ $product['link'] }}</link>
    <description>{{ $product['description'] }}</description>
    <g:image_link>{{ $product['image_link'] }}</g:image_link> 
    <g:price>{{ $product['price'] }}</g:price> 
    <g:availability>{{ $product['availability'] }}</g:availability> 
    <g:gtin>{{ $product['gtin'] }}</g:gtin>
    <g:mpn>{{ $product['mpn'] }}</g:mpn>
    <g:brand>{{ $product['brand'] }}</g:brand>   
    <g:update_type>{{ $product['update_type'] }}</g:update_type> 
    @if(isset($product['additional_image_link']))
        @foreach($product['additional_image_link'] as $additional)
            <g:additional_image_link>{{ $additional }}</g:additional_image_link> 
        @endforeach
    @endif
</item> 
@endforeach

</channel> </rss>