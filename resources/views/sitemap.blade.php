<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($urlGroups as $group)
    <url>
        <loc>{{ $group['locs']['de'] }}</loc>
        <lastmod>{{ $group['lastmod'] }}</lastmod>
        <changefreq>{{ $group['changefreq'] }}</changefreq>
        <priority>{{ $group['priority'] }}</priority>
        @foreach($group['locs'] as $lang => $loc)
        <xhtml:link rel="alternate" hreflang="{{ $lang }}" href="{{ $loc }}"/>
        @endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $group['locs']['de'] }}"/>
        @if(!empty($group['image']))
        <image:image>
            <image:loc>{{ $group['image']['loc'] }}</image:loc>
            <image:title>{{ $group['image']['title'] }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach
</urlset>
