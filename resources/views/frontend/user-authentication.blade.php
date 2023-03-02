@extends('frontend.layouts.master')
@section('title', 'Quiz Machine')
@section('main-content')
    <!-- main section start -->
    <section>
        <div class="container">
            <!-- breadcrumb section start -->
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 mx-auto">
                    <div class="breadcrumb">
                        <ul>
                            <li>
                                <a href="{{route('frontend.home')}}" class="text-decoration-none text-dark">Home <i class="fa-solid fa-chevron-right"></i></a>
                            </li>
                            <li>
                                <a href="#" class="text-decoration-none text-dark">Test Info <i class="fa-solid fa-chevron-right"></i></a>
                            </li>
                            <li>
                                <a href="#" class="text-decoration-none text-dark">Quiz <i class="fa-solid fa-chevron-right"></i></a>
                            </li>
                            <li>
                                <a href="#" class="text-decoration-none text-dark">authentication</a>
                            </li>
                        
                        </ul>
                    </div>
                </div>
            </div>
            <!-- breadcrumb section end -->
            <!-- content wrapper start -->
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 mx-auto">
                    <div class="content">
                        <h2 class="fw-bolder mb-3">Authentication</h2>
                        <div class="text-center">
                            <ul class="user_authentication_ul">
                                <li id="auth_login">Login</li>
                                <li id="auth_register">Register</li>
                            </ul>
                        </div>
                        <div class="result_login">
                            <div class="row">
                                <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
                                    <form id="resultAjaxLogin">
                                        <div class="form-group">
                                          <label for="">Email address</label>
                                          <input type="email" class="form-control" id="auth_email"  placeholder="Enter email">
                                        </div>
                                        <div class="form-group mt-2">
                                          <label for="">Password</label>
                                          <input type="password" class="form-control" id="auth_password" placeholder="********">
                                        </div>
                                        <button type="submit" class="btn btn-warning mt-2">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>      
                        <div class="result_register">
                            <div class="row">
                                <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
                                    <form id="resultAjaxRegister">
                                        <div class="form-group">
                                          <label for="">Name</label>
                                          <input type="email" class="form-control" id="auth_register_name"  placeholder="Enter email">
                                        </div>
                                        <div class="form-group mt-2">
                                          <label for="">Email address</label>
                                          <input type="email" class="form-control" id="auth_register_email"  placeholder="Enter email">
                                        </div>
                                        <div class="form-group mt-2">
                                          <label for="">Password</label>
                                          <input type="password" class="form-control" id="auth_register_password" placeholder="Password">
                                        </div>
                                        <div class="form-group mt-2">
                                          <label for="">Confirm Password</label>
                                          <input type="password" class="form-control" id="auth_register_c_password" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-warning mt-2">Register</button>
                                    </form>
                                </div>
                            </div>
                        </div>      
                    </div>
                </div>
            </div>
            <!-- content wrapper end --> 
        </div>
  </section>
    <!-- main section end -->
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".result_login").show();
    $(".result_register").hide();
    $("#auth_login").addClass('user_login_registration_active');
  $("#auth_register").click(function(){
    $(".result_login").hide();
    $(".result_register").show();
    $("#auth_login").removeClass('user_login_registration_active');
    $("#auth_register").addClass('user_login_registration_active');
  });
  $("#auth_login").click(function(){
    $(".result_login").show();
    $(".result_register").hide();
    $("#auth_login").addClass('user_login_registration_active');
    $("#auth_register").removeClass('user_login_registration_active');
  });
});
</script>
<script>
    $(document).ready(function(){
        $('#resultAjaxLogin').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type:'POST',
                url:"{{route('frontend.user.login')}}",
                data:{"action":"Login", email:$("#auth_email").val(), password:$("#auth_password").val()},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                  console.log('Login Successfully');
                  window.location.href = "{{route('frontend.exam.result', $exam_id)}}"
                },
                error: function(data){
                    console.log(data);
                }
            });
  
            return false;
        });
    });
  </script>
  <script>
    $(document).ready(function(){
        $('#resultAjaxRegister').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type:'POST',
                url:"{{route('frontend.user.register')}}",
                data:{"action":"Registration", name:$("#auth_register_name").val(),email:$("#auth_register_email").val(), password:$("#auth_register_password").val(), confirm_password:$("#auth_register_c_password").val()},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    console.log('Register Successfully');
                  window.location.href = "{{route('frontend.exam.result', $exam_id)}}"
                },
                error: function(data){
                    console.log($data);
                }
            });
  
            return false;
        });
    });
  </script>