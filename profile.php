<?php
session_start();

 if(empty($_SESSION['user']))

 {
    header("Location:login.php");
 }

  require("php/db.php");

  $user_email = $_SESSION['user'];

  $user_sql = "SELECT * FROM users WHERE email = '$user_email'";

  $user_res = $db->query($user_sql);
  
  $user_data  = $user_res->fetch_assoc();
  
  $user_name = $user_data['full_name'];

   $total_storage = $user_data['storage'];
      
    $use_storage = $user_data['use_storage']; 

    $plan = $user_data['plans'];

    $free_storage = 0;

 if($plan !="premium")

 {
    $per = round(($use_storage*100)/$total_storage,2); 

    $free_storage = $total_storage-$use_storage;


 }
   
  $user_id =  $user_data['id'];

  $tf = "user_".$user_id;

  $p_status = "";


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

  <style >
  	.main-container{
  		width: 100%;
  		height: 100vh;
  	}
  	.left{
  		width: 17%;
  		height: 100%;
  		background-color: #080429;


  	}
  	.right{

  		width: 83%;
  		height: 100%;
  		overflow: auto;
  	}
  	.profile_pic{
  		width: 100px;
  		height: 100px;
  		border-radius: 100%;
  		border:4px solid white;
  	}
  	.line{
  		background-color: #fff !important;
  		width: 100%;
  	}
.storage
{
    width: 80%;
}
.thumb{
   width: 75px;
   height: 75px;
}
.my_menu{
   list-style: none;
   padding: 0;
   margin: 0;
   width: 100%;

}
.my_menu li{

   width: 100%;
   padding: 10px;
   color: #fff;
   padding-left: 40px;

}

.my_menu li:hover{
   background-color: #fff;
   color: #080429;
   cursor: pointer;
}

.msg{

   width: 100%;
   height: 100vh;
   background-color: rgba(0, 0, 0,0.7);
   position: fixed;
   top: 0;
   left: 0;
   display: flex;
   justify-content: center;
   align-items: center;
   z-index: 1000000;
}

 @media(max-width : 992px)
 {   
    .right{
        width: 100%;
    }
    .mobile_menu{

        position: fixed;
        top: 0;
        left: 0;
        background-color: #080429;
        width: 0%;
        height: 100vh;
        z-index: 10000000000;
        overflow: hidden;
        transition: 0.4s;
    }
 }



  </style>


</head>
<body>

    <div class="main-container d-flex">
	  <div class="left d-none d-lg-block">

		 <div class="d-flex justify-content-center align-items-center flex-column pt-5">
		 	
		 	<div class="profile_pic d-flex justify-content-center align-items-center">
		 		<i class="fa fa-user fs-1 text-white"></i>
		 	</div>
		 	<span class="text-white fs-3 mt-3"><?php echo $user_name; ?></span>

		 	    <hr class="line">

		 	    <button class="btn btn-light rounded-pill upload"><i class="fa fa-upload"></i>Upload file</button>

              <div class="progress storage mt-3 d-none u_pro">
                   <div class="progress-bar bg-primary upload_p" style="width:0%"></div>
                 </div>

                 <div>

                  <div class="upload_msg"></div>
                    

                 </div>


             <hr class="line">
               
               <ul class="my_menu">
                  <li class="menu" p_link="my_files"><i class="fas fa-folder-open"></i>
                  My Files</li>
                  <li class="menu" p_link="f_files"><i class="fas fa-star"></i>
                  favourite Files</li>
                  <li class="menu"p_link="buy_storage"><i class="fas fa-shopping-cart"></i>
                  Buy Storage</li>
               </ul>


             <hr class="line">

                <?php
                 if($plan != "premium")
                 {
                 

                ?>

                <span class="text-white mb-2"><i class="fas fa-database"></i> STORAGE</span>
                <div class="progress storage">
                   <div class="progress-bar bg-primary pb" style="width:<?php echo $per;  ?>%"></div>
                 </div>
              
   <span class="text-white"><span class="us"><?php echo $use_storage  ?></span>MB /<?php echo $total_storage?>MB</span>


                  <?php  

                      }

                      else
                      {    
                      
                  
                  ?>
                   <span class="text-white mb-2"><i class="fas fa-database"></i> USED STORAGE</span>
                      <span class="text-white"><span class="us"><?php echo $use_storage  ?></span>MB</span>

                  <?php }

                  ?>

		 	    <a href="php/logout.php"  class="btn btn-light mt-3">Logout</a>
		 </div>
		
    </div>

      <!-- mobile menu  coding  start -->

           <div class="mobile_menu d-block d-lg-none">
            <i class="fas fa-times text-light fs-3 pt-4 ps-4 cut"></i>

         <div class="d-flex justify-content-center align-items-center flex-column pt-2">
            
            <div class="profile_pic d-flex justify-content-center align-items-center">
                <i class="fa fa-user fs-1 text-white"></i>
            </div>
            <span class="text-white fs-3 mt-3"><?php echo $user_name; ?></span>

                <hr class="line">

                <button class="btn btn-light rounded-pill upload"><i class="fa fa-upload"></i>Upload file</button>

              <div class="progress storage mt-3 d-none u_pro">
                   <div class="progress-bar bg-primary upload_p" style="width:0%"></div>
                 </div>

                 <div>

                  <div class="upload_msg"></div>
                    

                 </div>


             <hr class="line">
               
               <ul class="my_menu">
                  <li class="menu mm" p_link="my_files"><i class="fas fa-folder-open"></i>
                  My Files</li>
                  <li class="menu mm" p_link="f_files"><i class="fas fa-star"></i>
                  favourite Files</li>
                  <li class="menu mm"p_link="buy_storage"><i class="fas fa-shopping-cart"></i>
                  Buy Storage</li>
               </ul>


             <hr class="line">

                <?php
                 if($plan != "premium")
                 {
                 

                ?>

                <span class="text-white mb-2"><i class="fas fa-database"></i> STORAGE</span>
                <div class="progress storage">
                   <div class="progress-bar bg-primary pb" style="width:<?php echo $per;  ?>%"></div>
                 </div>
              
   <span class="text-white"><span class="us"><?php echo $use_storage  ?></span>MB /<?php echo $total_storage?>MB</span>


                  <?php  

                      }

                      else
                      {    
                      
                  
                  ?>
                   <span class="text-white mb-2"><i class="fas fa-database"></i> USED STORAGE</span>
                      <span class="text-white"><span class="us"><?php echo $use_storage  ?></span>MB</span>

                  <?php }

                  ?>

                <a href="php/logout.php"  class="btn btn-light mt-3">Logout</a>
         </div>
        
    </div>


       <!-- mobile menu coding  end-->


	     <div class="right">


		 <nav class="navbar navbar-light bg-light p-3 shadow-sm sticky-top">
          <div class="container-fluid">
            <i class="fas fa-bars fs-4 bars d-block d-lg-none"></i>
           <form class="d-flex ms-auto search_frm">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search">
           <button class="btn btn-outline-primary" type="submit">Search</button>
          </form>
           </div>
          </nav>
          <div class="content p-4">

          </div>

          
		
	      </div>
          </div>

                <div class="msg d-none"></div>

                <?php

                if($plan !="free")

  {

    $ed = $user_data['expiry_date'];
    $cd = date('Y-m-d');

    if($ed < $cd)

    {
      $p_status = "deactivae";

      echo "<style>.upload,[p_link='my_files'],[p_link='f_files']{pointer-events:none;}</style>";

    }

    else

    {

        $p_status = "activate";
    }
  
  }
  ?>


          <script>
          	 
          	 $(document).ready(function(){

                $(".upload").click(function(){
                     
                       var input = document.createElement("INPUT");
                       input.setAttribute("type","file");
                       input.click();
                       input.onchange = function(){
                      $(".u_pro").removeClass("d-none");
                      var file = new FormData();
                      file.append("data",input.files[0]);

                     var file_size = Math.floor(input.files[0].size/1024/1024);
                      
                      var free_storage = <?php echo $free_storage?>;

                      var plan = "<?php echo $plan; ?>";

                      function upload(){


                        $.ajax({
                             
                             type : "POST",
                             url : "php/upload.php",
                             data : file,
                             processData : false,
                             contentType : false,
                             cache: false,
                             xhr : function(){

                              var request = new XMLHttpRequest();
                              request.upload.onprogress = function(e){

                             var loaded = (e.loaded/1024/1024).toFixed(2);
                              var total = (e.total/1024/1024).toFixed(2);

                              var upload_per = ((loaded*100)/total).toFixed(0);

                              $(".upload_p").css("width",upload_per+"%");
                              $(".upload_p").html(upload_per+"%");

                              }

                               return request;
                                
                             },
                             success: function(response){

                              var obj = JSON.parse(response);
                               $(".u_pro").addClass("d-none");

                           if(obj.msg == "file upload successfully")
                                  

                                  {

                                  var new_per = (obj.use_storage*100)/<?php echo $total_storage?>
                                         
                                  $(".us").html(obj.use_storage);
                                  $(".pb").css("width",new_per+"%");

                                  var div = document.createElement("DIV");
                                  div.className = "alert alert-success mt-3";
                                   div.innerHTML = obj.msg;
                                  $(".upload_msg").append(div);
                                   my_files();


                                  setTimeout(function()
                                    {  

                                  $(".upload_msg").html("");

                                   $(".upload_p").css("width","0%");
                                     $(".upload_p").html("");  
                                   },3000);

                                  }
                                 else
                                 {
                                       
                                  var new_per = (obj.use_storage*100)/<?php echo $total_storage?>
                                         
                                  $(".us").html(obj.use_storage);
                                  $(".pb").css("width",new_per+"%");

                                  var div = document.createElement("DIV");
                                  div.className = "alert alert-danger mt-3";
                                   div.innerHTML = obj.msg;
                                  $(".upload_msg").append(div);



                                  setTimeout(function()
                                     {

                                  $(".upload_msg").html("");
                                   $(".upload_p").css("width","0%");
                                     $(".upload_p").html("");  
                                   },3000);



                                 }

                                }

                             

                        })

                      }
                     
                        if(plan == "premium")

                        {

                             upload();

                        }

                        else
                            {
                                 
                                   if(file_size<free_storage)
                                  {
                                      upload();
                          
                                 }
                        
                                else
                               {
                          
                                 var new_per = (obj.use_storage*100)/<?php echo $total_storage?>
                                         
                                  $(".us").html(obj.use_storage);
                                  $(".pb").css("width",new_per+"%");

                                  var div = document.createElement("DIV");
                                  div.className = "alert alert-danger mt-3";
                                   div.innerHTML = "file Size too large. Kindly Purchase More storage";
                                  $(".upload_msg").append(div);


                                  setTimeout(function()
                                     {

                                  $(".upload_msg").html("");
                                   $(".upload_p").css("width","0%");
                                     $(".upload_p").html("");  
                                     $(".u_pro").addClass("d-none");
                                   },3000);


                                 }

                            }


                    

                       }


                });


               $(".menu").each(function(){

                  $(this).click(function(){

                     var page_link = $(this).attr("p_link");
                    
                    $.ajax({

                       type : "POST",
                       url : "php/pages/"+page_link+".php",
                       beforeSend : function(){
                         
                         var div = document.createElement("DIV");
                         $(div).addClass("alert alert-success fs-1 text-center p-5");
                         $(div).html("<i class='fas fa-spinner fa-spin display-1'></i><br>Loading...");
                         $(".msg").html(div);
                         $(".msg").removeClass("d-none");

                       },

                       success:function(response){

                         $(".msg").addClass("d-none");
                        $(".content").html(response);
                       }

                    })



                  })

               })

               function my_files(){

                if("<?php echo $plan;?>" !="free")
                {

                if("<?php echo $p_status;?>" == "activate")

                {
                     
                     $('[p_link="my_files"]').click(); 

                }

                else
                {

                    $('[p_link="buy_storage"]').click(); 
                }
            }
            
            else 
            {
                
                 $('[p_link="my_files"]').click(); 

            }        

             }
             my_files();

             $(".cut").click(function(){

               $(".mobile_menu").css({"width":"0%"});

             })
              
              $(".bars").click(function(){
              
              $(".mobile_menu").css({"width":"75%"});


              })
                $(".mm").each(function(){

                   $(this).click(function(){
                     
                      $(".mobile_menu").css({"width":"0%"});


                   })

                })

                $(".search_frm").submit(function(e){
                    
                    e.preventDefault();
                   var query = $("#search").val();
                    
                    $.ajax({

                       type : "POST",
                       url : "php/pages/search.php",
                       data : {
                          query:query

                       },
                       beforeSend : function(){
                         
                         var div = document.createElement("DIV");
                         $(div).addClass("alert alert-success fs-1 text-center p-5");
                         $(div).html("<i class='fas fa-spinner fa-spin display-1'></i><br>Loading...");
                         $(".msg").html(div);
                         $(".msg").removeClass("d-none");

                       },

                       success:function(response){

                         $(".msg").addClass("d-none");
                        $(".content").html(response);
                       }

                    })

                })
          	 

             })
          </script>
       <marquee><h5 style="color:blue;text-align:center;"> Developed by : ABHISHEK YADAV
</h5>
</marquee>


</body>
</html>