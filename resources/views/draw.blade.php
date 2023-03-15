@extends('layout.header')



@section('content')
<!-- add paragraph by mj  -->
<p style="font-size: 50px;">mj josh pat alex sean lesther renzon</p>
    <div id="app">
        <draw-component
            :members = "{{$getMembers}}"
            :first = "{{ $firstNumber }}"
            :last = "{{ $lastNumber }}"
            :set = "{{ $setInUse }}">
        </draw-component>
    </div>
@stop

