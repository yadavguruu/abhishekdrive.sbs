 <?php  

  session_start(); 
require("../db.php");
 $search = $_POST['query'];

$user_email = $_SESSION['user'];

  $user_sql = "SELECT * FROM users WHERE email = '$user_email'";

  $user_res = $db->query($user_sql);
  
  $user_data  = $user_res->fetch_assoc();

  $user_id =  $user_data['id'];

  $total_storage = $user_data['storage'];

  $tf = "user_".$user_id;

?>

<h1 class="text-center mt-3 mb-4">Search Files</h1>

     <div class="row">
             
             <?php 

                 $file_data_sql = "SELECT * FROM $tf WHERE file_name LIKE '%$search%'";
                $file_res = $db->query( $file_data_sql);

             while ($file_array = $file_res->fetch_assoc())

              {
                $fd_array = pathinfo($file_array['file_name']);

                

                $file_name = $fd_array['filename'];
                $f_ext = $fd_array['extension'];
                $basename = $fd_array['basename'];

                echo '
                   <div class="col-md-4">
                    <div class="d-flex border align-items-center p-3 mb-3">
                            <div class="me-3">';

                              if ($f_ext == "mp4")
                              {

                                 echo "<img src ='images/mp4.jpg'class='thumb'>";
                              }

                              else if ($f_ext == "mp3") 

                              {
                                echo "<img src ='images/mp3.jpg'class='thumb'>";  
                              }
                               
                               else if ($f_ext == "pdf")
                               {
                                 echo "<img src ='images/pdf.jpg'class='thumb'>"; 
                               } 

                               else if ($f_ext == "docx" || $f_ext == "doc")
                               
                               {
                                echo  "<img src ='images/doc.jpg'class='thumb'>";
                               }
                                
                                else if ($f_ext == "xlsx"  || $f_ext == "xls")
                                {

                                  echo "<img src ='images/xlsx.jpg'class='thumb'>";
                                }
                                
                                  else if ($f_ext == "pptx"  || $f_ext == "ppt")

                                  {
                                    
                                    echo "<img src ='images/pptx.jpg'class='thumb'>";

                                  }
                                   
                                   else if ($f_ext == "zip")

                                   {
                                    echo "<img src ='images/zip.jpg'class='thumb'>";
                                   }

                                   elseif ($f_ext == "txt")

                                   {
                                      
                                      echo "<img src ='images/txt.png'class='thumb'>";

                                   }

                                    else if ($f_ext == "mov")

                                   {
                                        
                                         echo "<img src ='images/mov.jpg'class='thumb'>";

                                   } 
                                    else if ($f_ext == "wmv")

                                    {
                                       
                                         echo "<img src ='images/wmv.jpg'class='thumb'>";

                                    }  

                                    else if($f_ext == "jpg" ||  $f_ext == "jpeg" ||  $f_ext == "png" ||  $f_ext == "gif" ||  $f_ext == "webp")

                                    {
                                       echo "<img src='data/".$tf."/".$basename."' class = 'thumb'>";
                                    }   


                                  echo'</div>
                            <div class="w-100">
                                   <p>'.$file_name.'</p>
                                   <hr>
                                   <div class="d-flex justify-content-around">
                                    
                                   <a href="data/'.$tf.'/'.$basename.'"target = "blank"><i class=" fas fa-eye"></i></a>
                                      <a href="data/'.$tf.'/'.$basename.'"download><i class=" fas fa-download"></i></a>
                                      <i class=" fas fa-trash del" id="'.$file_array['id'].'" folder="'.$tf.'" file="'.$basename.'"></i>';

                                      if($file_array['star'] =="yes")

                                      {
                                           echo '<i class="fas fa-star text-warning star" status="no" id="'.$file_array['id'].'" folder="'.$tf.'"></i>';

                                      }

                                       else
                                       {

                                          echo '<i class="fas fa-star secondary star" status="yes" id="'.$file_array['id'].'" folder="'.$tf.'"></i>';
                                       }


                                   echo'</div>

                            </div>

                    </div>

                   </div>

                ';
             
             }
             ?>
             </div>

             <script>
                 
                 $(document).ready(function(){
                     
                     $(".del").each(function(){

                        $(this).click(function(){

                           var id = $(this).attr('id');
                           var folder = $(this).attr('folder');
                           var file = $(this).attr('file');
                           var ce = $(this);

                           $.ajax({

                               type : "POST",
                               url : "php/del_file.php",
                               data : {

                                   id:id,
                                   folder:folder,
                                   file:file

                               },

                                    success:function(response){

                                       

                              var obj = JSON.parse(response);
                               

                           if(obj.msg == "file Delete Succesfully")
                                  

                                  {

                                  var new_per = (obj.use_storage*100)/<?php echo $total_storage?>
                                         
                                  $(".us").html(obj.use_storage);
                                  $(".pb").css("width",new_per+"%");

                                  var div = document.createElement("DIV");
                                  div.className = "alert alert-success mt-3";
                                   div.innerHTML = obj.msg;
                                  $(".upload_msg").append(div);
                                 $(ce).parent().parent().parent().parent().remove();
                                 


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

                        })

                     })


                     $(".star").each(function(){

                        $(this).click(function(){

                       var star_id = $(this).attr('id');

                       var star_status = $(this).attr('status');

                       var s_folder = $(this).attr('folder');

                       $.ajax({

                           type:"POST",
                           url : "php/star_files.php",
                           data : {
                            sid:star_id,
                           s_status:star_status,
                           s_folder:s_folder

                       },

                         success:function(response){

                        if(response.trim() == "success")

                        {
                              $('[p_link="my_files"]').click();          
                        }

                        else
                        {
                                  alert(response);

                        }


                         }



                       

                        })


                     })


                 })
             </script>