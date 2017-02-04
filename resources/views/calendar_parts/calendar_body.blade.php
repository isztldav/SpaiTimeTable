@extends('calendar')

@section('models1')
    @foreach ($classes as $model)
        @if ($selected_class1 == $model->class)
            <option value={{{ $model->class }}} selected>{{{ $model->class }}}</option>
        @else
            <option value={{{ $model->class }}}>{{{ $model->class }}}</option>
        @endif
    @endforeach
@endsection

@section('models2')
    @foreach ($classes as $model)
        @if ($selected_class2 == $model->class)
            <option value={{{ $model->class }}} selected>{{{ $model->class }}}</option>
        @else
            <option value={{{ $model->class }}}>{{{ $model->class }}}</option>
        @endif
    @endforeach
@endsection

@section('calendar')
    {!! $calendar->calendar() !!}
@endsection

@section('scripts')
    {!! $calendar->script() !!}
@endsection