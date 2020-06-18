{{--
    @param $permissions
    @param $id
    @param $icon
    @param $name
    @param $items

    --}}
@canany($permissions)
    <li>
        <a href="#{{ $id }}" aria-expanded="false" data-toggle="collapse">
            <i class="{{ $icon }}"></i>
            {{$name}}
            </a>
        <ul id="{{ $id }}" class="collapse list-unstyled ">
            @foreach($items as $item)
                {!! $item !!}
            @endforeach
        </ul>
    </li>
@endcanany
