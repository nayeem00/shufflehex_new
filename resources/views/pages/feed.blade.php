{{ Request::header('Content-Type : application/xml') }}

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>

        <title>{{ config('app.name') }}</title>
        <description>RSS Feed</description>
        <link>{{ url('/') }}</link>
@foreach ($posts as $post)
    @php
        $post->title = str_replace("&", "&amp;", $post->title);
        $post->description = str_replace("&rdquo;", "”", $post->description);
        $post->description = str_replace("&ldquo;", "“", $post->description);

        $post->title = stripslashes($post->title);
        $post->description = stripslashes($post->description);
        $post->slug = stripslashes($post->slug);

        if ($post->featured_image !='') {
            $img = "<img src='".url($post->featured_image)."' alt='".$post->title."' width='600'>";
        } else {
            $img = null;
        }
    @endphp
            <item>
                <title>{{ $post->title }}</title>
                <description><![CDATA[{!! $img !!} {!! $post->description !!}]]></description>
                <pubDate>{{ date('D, d M Y H:i:s', strtotime($post->created_at)) }} GMT</pubDate>
                <link>{{ url($post->slug) }}</link>
                <guid>{{ url($post->slug) }}</guid>
                <atom:link href="{{ url($post->slug) }}" rel="self" type="application/rss+xml"/>
            </item>
        @endforeach

    </channel>
</rss>