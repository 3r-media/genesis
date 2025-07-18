@if(App::isProduction())
User-agent: *
Disallow:
@else
User-agent: *
Disallow: /
@endif
