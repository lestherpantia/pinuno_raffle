@extends('layout.header')



@section('content')

    {{--  lesther create h3 in draw blade  --}}
    <h3>Hello World!</h3>

    <div id="app">
        <draw-component
            :members = "{{$getMembers}}"
            :first = "{{ $firstNumber }}"
            :last = "{{ $lastNumber }}"
            :set = "{{ $setInUse }}">
        </draw-component>
    </div>
@stop

