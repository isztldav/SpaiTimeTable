@extends('calendar')

@section('models1')
    @foreach ($sortedclass as $model)
        @if ($selected_class1 == $model)
            <option value="{{{ $model }}}" selected>{{{ $model }}}</option>
        @else
            <option value="{{{ $model }}}">{{{ $model }}}</option>
        @endif
    @endforeach
@endsection

@section('models2')
    @foreach ($sortedclass as $model)
        @if ($selected_class2 == $model)
            <option value="{{{ $model }}}" selected>{{{ $model }}}</option>
        @else
            <option value="{{{ $model }}}">{{{ $model }}}</option>
        @endif
    @endforeach
@endsection

@section('calendar')
    {!! $calendar->calendar() !!}
@endsection

@section('scripts')
    {!! $calendar->script() !!}
@endsection