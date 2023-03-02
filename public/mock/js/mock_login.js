$(document).ready(function(){
    $(".mock_register_div").hide();
    $("#mock_login").addClass('authentication_list_li_active');
    $("#mock_register").click(function(){
        $(".mock_login_div").hide();
        $(".mock_register_div").show();
        $("#mock_login").removeClass('authentication_list_li_active');
        $("#mock_register").addClass('authentication_list_li_active');
    });
    $("#mock_login").click(function(){
      $(".mock_login_div").show();
      $(".mock_register_div").hide();
      $("#mock_login").addClass('authentication_list_li_active');
      $("#mock_register").removeClass('authentication_list_li_active');
    });
  });

  

