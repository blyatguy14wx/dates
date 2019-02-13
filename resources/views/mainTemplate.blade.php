<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>

    <link rel="icon" type="image/png" href="../assets/img/favicon.ico">

<!-- Bootstrap core CSS     -->
<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />

<!--     Fonts and icons     -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
<!-- Animation library for notifications   -->
<link href="{{asset('assets/css/animate.min.css')}}" rel="stylesheet"/>

<!--  Light Bootstrap Table core CSS    -->
<link href="{{asset('assets/css/light-bootstrap-dashboard.css?v=1.4.0')}}" rel="stylesheet"/>

<link href="{{asset('assets/css/pe-icon-7-stroke.css')}}" rel="stylesheet" /> 
</head>
<body>
   <div class="container-fluid">
       <div class="row">
           <div class="col-md-12">
               @yield('main')
           </div>
       </div>
   </div>
</body>


 <!--   Core JS Files   -->
<script src="{{asset('assets/js/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
 <!--  Charts Plugin -->
<script src="{{asset('assets/js/chartist.min.js')}}"></script>

 <!--  Notifications Plugin    -->
 <script src="{{asset('assets/js/bootstrap-notify.js')}}"></script>
 

 <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="{{asset('assets/js/light-bootstrap-dashboard.js?v=1.4.0')}}"></script>


 <!-- MOMENT JS -->
<script src="{{asset('assets/js/moment-with-locales.js')}}"></script>



</html>

