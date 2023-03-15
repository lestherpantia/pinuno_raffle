@extends('layout.header')



@section('content')


    <!-- ALEX - CREATE P TAG -->
    <p>HELLO UNIVERSE</p>
    <div id="app">
        <draw-component
            :members = "{{$getMembers}}"
            :first = "{{ $firstNumber }}"
            :last = "{{ $lastNumber }}"
            :set = "{{ $setInUse }}">
        </draw-component>
    </div>
@stop

