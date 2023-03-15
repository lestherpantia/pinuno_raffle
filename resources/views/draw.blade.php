@extends('layout.header')

<!-- Joshua's Changes -->

<h1> Joshua pogi </h1>

@section('content')
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
    
<!-- add paragraph by mj  -->
<p style="font-size: 50px;">mj josh pat alex sean lesther renzon</p>

    <!-- ALEX - CREATE P TAG -->
    <p>HELLO UNIVERSE</p>
@stop

