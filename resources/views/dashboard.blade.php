@extends('mainTemplate')


@section('main')
    <script>
    if(!localStorage.getItem('accessToken')){
        location.href="/login";
    }
    </script>
<div id="app">
    <navbar></navbar>
</div>

<script src="{{asset('js/app.js')}}"></script>

<!--PUSHER JS LIB-->

@endsection