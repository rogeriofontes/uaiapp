<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ $title }}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ url(\Route::current()->getPrefix()) }}">Home</a>
            </li>

            @foreach($breadcrumb as $key => $row)
                @if($key + 1 == count($breadcrumb))
                    <li class="active">
                        <strong>{{ $row['pagina'] }}</strong>
                    </li>
                @else
                    <li>
                        <a href="{{ url($row['route']) }}">{{ $row['pagina'] }}</a>
                    </li>
                @endif                
            @endforeach

        </ol>
    </div>
    <div class="col-lg-2">
        
    </div>
</div>