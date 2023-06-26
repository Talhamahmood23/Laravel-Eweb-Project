@if(isset($data['breadcrumb']))
    <section class="page_title corner-title overflow-visible">
            <ol class="breadcrumb">
                <li class=" item-1"></li>
                @foreach($data['breadcrumb'] as $b)
                    <li class="breadcrumb-item"><a href="{{ $b['link'] }}">{!! strtoupper($b['title']) !!}</a></li>
                @endforeach
            </ol>
    </section>
@endif