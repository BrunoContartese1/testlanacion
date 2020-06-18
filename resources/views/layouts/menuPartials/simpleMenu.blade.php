@can($permission)
    <li class="{{Request::is($request) ? 'active' : ''}}">
        <a href="{{$url}}">
            <i class="{{$icon}}"></i>
            {{$name}}
        </a>
    </li>
@endcan
