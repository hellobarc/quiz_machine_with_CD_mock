@extends('frontend.layouts.master')
@section('title', 'Mock Authetication')
@section('main-content')
    <!-- main section start -->
    <section>
      <div class="container">
         <!-- breadcrumb section start -->
         <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcrumb">
                    <ul>
                        <li>
                            <a href="{{route('frontend.home')}}" class="text-decoration-none text-dark">Home > </a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Mock Info > </a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none text-dark"> Authentication</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- breadcrumb section end -->
          <!-- content wrapper start -->
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 mx-auto">
                <div class="content">
                    <h2 class="fw-bolder">Before Exam Login your panel</h2>
                    <p class="main-text">Please fill in your name and email and get the results direct to your inbox after you have finished the test!</p>
                    <div class="authentication_list">
                        <ul>
                            <li id="mock_login">Login</li>
                            <li id="mock_register">Register</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12 mx-auto">
                            <div class="authentication_form">
                                <div class="mock_login_div">
                                    <form id="mock_login_form">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Email address</label>
                                          <input type="email" class="form-control" id="mockLoginEmail" placeholder="Enter email">
                                        </div>
                                        <div class="form-group mt-3">
                                          <label for="exampleInputPassword1">Password</label>
                                          <input type="password" class="form-control" placeholder="Password" id="mockLoginPassword">
                                        </div>
                                        <button type="submit" class="btn btn-warning fw-bold mt-3">Submit</button>
                                    </form>
                                </div>
                                <div class="mock_register_div">
                                    <form id="mock_register_form">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Name</label>
                                          <input type="text" class="form-control" id="inputName" aria-describedby="emailHelp" placeholder="Enter email">
                                        </div>
                                        <div class="form-group mt-3">
                                          <label for="exampleInputEmail1">Email address</label>
                                          <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email">
                                        </div>
                                        <div class="form-group mt-3">
                                          <label for="exampleInputPassword1">Password</label>
                                          <input type="password" class="form-control" id="inputPassword" placeholder="*******">
                                        </div>
                                        <div class="form-group mt-3">
                                          <label for="exampleInputPassword1">Confirm Password</label>
                                          <input type="password" class="form-control" id="inputConfirmPass" placeholder="*******">
                                        </div>
                                        <button type="submit" class="btn btn-warning fw-bold mt-3">Submit</button>
                                    </form>
                                </div>
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
    $('#mock_login_form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type:'POST',
            url:"{{route('frontend.user.login')}}",
            data:{"action":"Login", email:$("#mockLoginEmail").val(), password:$("#mockLoginPassword").val()},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
              console.log('Login Successfully');
              window.location.href = "{{route('frontend.mock.module.info', ['mock_id'=>$mock_id])}}"
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
        $('#mock_register_form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type:'POST',
                url:"{{route('frontend.user.register')}}",
                data:{"action":"Registration", name:$("#inputName").val(),email:$("#inputEmail").val(), password:$("#inputPassword").val(), confirm_password:$("#inputConfirmPass").val()},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    console.log('Register Successfully');
                  window.location.href = "{{route('frontend.mock.module.info', ['mock_id'=>$mock_id])}}"
                },
                error: function(data){
                    console.log($data);
                }
            });
  
            return false;
        });
    });
  </script>
<script src="{{asset('mock/js/mock_login.js')}}"></script>
