              

        <button type="button" class="btn btn-success btn-block " data-toggle="modal" data-target="#myModal" style="bottom:28px;position: fixed;width: 26%">
                 Active Users
        </button>

              <!-- The Modal -->
              <div class="modal" id="myModal">
                <div class="modal-dialog modal-sm " style="float:right;margin-top: 300px;margin-right: 72px;max-height: 220px">
                  <div class="modal-content">
                  
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Online Actives</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div style="">
                            <table class="table table-hover">
                            <?php
                                $query=mysqli_query($con,"SELECT username FROM login_info");
                                
                                while($res= mysqli_fetch_assoc($query)){
                                $user=$res['username'];
                                $ifFrnd=new Get_User_Info($con, $userLoggedIn);
                                $isFriend=$ifFrnd->isFriend($user);
//                              
                                if($user!=$userLoggedIn && $user==$isFriend){
                                $activeuser=new Get_User_Info($con, $user);
                                $name=$activeuser->getName();
                                $pic=$activeuser->getProfilePic();
                                
                            ?>

                            <tr>
                                <td><img src="<?php echo $pic;?>" style="height:25px;border-radius: 13px;">
                                        <a href="message.php?msg_to=<?php echo $user;?>" style="font-size:14px;color: #5cb85c;">
                                            <?php echo $name;?>
                                        </a>
                                </td>
                            </tr>


                                <?php }  ?>
                                
                                <?php }?>
                            </table> 
                        </div>


                    </div>
                    
                    
                    
                  </div>
                </div>
              </div>