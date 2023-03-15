@extends('layout.header')

<!-- Joshua's Changes -->

<h1> Joshua pogi </h1>

@section('content')

    {{--  lesther create h3 in draw blade  --}}
    <h3>Hello World!</h3>

    <div id="app">
        <!-- Sean -->
        <h1>TALONG NI JUSWAAAA</h1>
        <draw-component
            :members = "{{$getMembers}}"
            :first = "{{ $firstNumber }}"
            :last = "{{ $lastNumber }}"
            :set = "{{ $setInUse }}">
        </draw-component>
    </div>
    


    <!-- ALEX - CREATE P TAG -->
    <p>HELLO UNIVERSE</p>
@stop

