@extends('layout.header')



@section('content')
    <div id="app">
        <draw-component
            :members = "{{$getMembers}}"
            :first = "{{ $firstNumber }}"
            :last = "{{ $lastNumber }}"
            :set = "{{ $setInUse }}">
        </draw-component>
    </div>
@stop

