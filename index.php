<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
<?php
require("Element/nav.php");
?>
	

<div class="container main-con">
	
        <div class="row">
        	
        	<div class="col-md-6"></div>	
        	<div class="col-md-6 p-5">
        		
        		<form class="bg-white rounded p-5 signup-form" autocomplete="off">
        			<h1 class="text-center bold">Sign up</h1>
                    <div class="mb-3">
        		<label for="username"class="form-label" >Username</label>
        			<input type="text" id="username" class="form-control" required="required">
              </div>

              <div class="mb-3 email_con">
        			<label for="email" class="form-label">Email Id</label>
        			<input type="email" id="email" class="form-control" required="required">
              <i class="fa fa-circle-notch fa-spin email_loader d-none"></i>

              </div>

    <div class="mb-3 pass_con">
    <label for="password" class="form-label">Password</label>
    <input type="password" id="password" class="form-control" required="required">
    <i class="fa fa-eye pass_icon"></i>
                                        </div>

    <div class="mb-4 d-flex justify-content-between">
    <div class="form-text"> Click Generate to improve security</div>


    <button class="btn btn-sm btn-danger pass-gen">Generate</button>
   </div>
                    <div class="text-center">
      	<button class="btn btn-primary w-50 register_btn"  disabled="disabled">Register Now!</button>
                    </div>

                    <div class="msg"></div>

        		</form>
            
            <form class="bg-white rounded p-5 activation-form d-none" autocomplete="off">

              <h1 class="text-center bold mb-4">Activate Your Account</h1>

              <div class="mb-3">
                 <label for="activation_code" class="form-label">Activation Code</label>

                 <input type="text" id="activation_code" class="form-control" required="required"> </div>


                 <div class="text-center">

                  <button class="btn btn-primary w-50 activation_code">Active Now</button>
                    
                 </div>
              

               <div class="activation_msg"></div>
             </form>

        	</div>
        </div>

</div>
<script>
  
   $(document).ready(function(){

       $(".pass-gen").click(function(e){

        e.preventDefault();
          $("#password").attr("type","text");
        $(".pass_icon").css({color:"black"});

        $.ajax({
          type:"POST",
          url:"php/generate_password.php",
          
          beforeSend: function(){
            
            $(".pass_icon").removeClass("fa fa-eye");
            $(".pass_icon").addClass("fa fa-circle-notch fa-spin");
              

          },
          success:function(response){


            $(".pass_icon").addClass("fa fa-eye");
            $(".pass_icon").removeClass("fa fa-circle-notch fa-spin");

           $("#password").val(response.trim());
          }
        })


       });

    $(".pass_icon").click(function(){
      if($("#password").attr("type")=="password")


      {

        $("#password").attr("type","text");
        $(this).css({color:"black"});
      }
      
       else
       {

       
        $("#password").attr("type","password");
        $(this).css({color:"#ccc"});

       }
          })

    //loader show coding 
    $("#email").on('input',function(){
      $(".email_loader").removeClass("d-none");

    })

    //check already registered user

    $("#email").on('change',function()
    {
       
       $.ajax({

              type : "POST",
              url : "php/check_user.php",
              data : {
                email : $(this).val()
              },
              success : function(response){

                 $(".email_loader").removeClass("fa fa-circle-notch fa-spin");

                 if(response.trim()  == "notfound")

                 {
                    $(".email_loader").removeClass("fa fa-times-circle");
                  $(".email_loader").addClass("fa fa-check-circle");
                    $(".email_loader").css({color:"green"});
                    $(".register_btn").removeAttr("disabled");

                 }
                 else

                 {

                 $(".email_loader").removeClass("fa fa-check-circle");
                 $(".email_loader").addClass("fa fa-times-circle");
                 $(".email_loader").css({color:"red"});
                  $(".register_btn").attr("disabled","disabled");

                 }


              }


       })

    });

      $(".signup-form").submit(function(e){

        e.preventDefault();

        $.ajax({

          type: "POST",

          url : "php/register.php",

          data : {

            username : $("#username").val(),

             email : $("#email").val(),

             password : $("#password").val()

          },
           beforeSend : function(){
               
               $(".register_btn").html("Please wait.....");

               $(".register_btn").attr("disabled","disabled");

           },

          success : function(response){

                $(".register_btn").html("Register Now");

               $(".register_btn").removeAttr("disabled");

             if(response.trim() == "success")


             {
         
                var div = document.createElement("DIV");
                div.className = "alert alert-success mt-3";
                div.innerHTML = "Register Success !";
                $(".msg").append(div);


                setTimeout(function()
                {

                  $(".msg").html("");
                  
                  $(".signup-form").addClass("d-none");
                  $(".activation-form").removeClass("d-none");
                },3000)



             }
          

          else if (response.trim() = "usermatch")

           {

              var div = document.createElement("DIV");
                div.className = "alert alert-warning mt-3";
                div.innerHTML = "user already exist !";
                $(".msg").append(div);


                setTimeout(function()
                {

                  $(".msg").html("");
                  $(".signup-form").trigger('reset');
                },3000);

             }

             else {
                  
                var div = document.createElement("DIV");
                div.className = "alert alert-danger mt-3";
                div.innerHTML = "Register Failed !";
                $(".msg").append(div);


                setTimeout(function()
                {

                  $(".msg").html("");
                  $(".signup-form").trigger('reset');
                },3000);

             



             }
          
          }


        })


    })  
        
   //Activation form code

      $(".activation-form").submit(function(e){


        e.preventDefault();
        
        $.ajax({
  

           type: "POST",
           url : "php/check_activation_code.php",
           data : {

              email : $("#email").val(),
              atc : $("#activation_code").val()


           },
        

          beforeSend :function(){

            $(".activation_btn").html("Checking Activation Code....."); 
            $(".activation_btn").attr("disabled","disabled");
          },

           success : function(response)
           {

            $(".activation_btn").html("Activate Now !"); 
             $(".activation_btn").removeAttr("disabled");
            if(response.trim() =="active"){

               var div = document.createElement("DIV");
                div.className = "alert alert-success mt-3";
                div.innerHTML = "Account Activated  !";
                $(".activation_msg").append(div);


                setTimeout(function()
                {

                  $(".activation_msg").html("");
                  window.location = "login.php";
                },3000);

                 }
           

                else{
                var div = document.createElement("DIV");
                div.className = "alert alert-danger mt-3";
                div.innerHTML = response;
                $(".activation_msg").append(div);


                setTimeout(function()
                {

                  $(".activation_msg").html("");
                 },3000);


            }

           }



          })

          })







   })

</script>
</body>
</html>