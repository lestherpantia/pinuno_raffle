@extends('layout.header')



@section('content')

    <div id="app">
        <settings-component :sets="{{ $setOfDraws }}"></settings-component>
    </div>

@stop

