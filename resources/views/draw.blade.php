@extends('layout.header')

<!-- Joshua's Changes -->

<h1> Joshua pogi </h1>

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

