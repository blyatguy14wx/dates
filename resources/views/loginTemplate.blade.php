@extends('mainTemplate')
<link rel="icon" type="image/png" href="/img/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/css/login/util.css">
	<link rel="stylesheet" type="text/css" href="/css/login/main.css">
<!--===============================================================================================-->
@section('main')
<div id="loginId">
        <login-component></login-component>
    </div>
    <script src="{{asset('js/login.js')}}"></script>
@endsection
<script src="/js/login/main.js"></script>