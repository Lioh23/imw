<div id="breadcrumbArrowed" class="col-xl-12 col-lg-12 layout-spacing ml-2">
    <nav class="breadcrumb-two" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">
                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['text'] }}</a>
            </li>
            @endforeach
        </ol>
    </nav>
</div>