<div class="well">
                    <center>
                    <table class="table table-border">
                        <tr>
                            <td>
                                <a type="button" style="" class="btn btn-block btn-link" href="../user/index.php"> News Feed </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php 
                                    $sql="SELECT * FROM messages WHERE sender='$userLoggedIn' OR receiver='$userLoggedIn' ORDER BY id DESC LIMIT 1";
                                    $query=mysqli_query($con, $sql);
                                    $row=mysqli_fetch_array($query);
                                    $msgWith=($row['receiver'] != $userLoggedIn) ? $row['receiver'] : $row['sender'];
                                    
                                ?>
                                <a style="" class="btn btn-block btn-link" href="../user/message.php?msg_to=<?php echo $msgWith;?>"> Messenger </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="button" style="" class="btn btn-block btn-link" data-toggle="collapse" data-target="#grp">Groups... <span class="caret"></span></button>
                                <div id="grp" class="collapse">
                                    <a href="createGroup.php" class="btn btn-sm btn-link"><b style="font-size:14px">Create Group ++</b></a><br>
                                    <!--         Groups section     -->
                                    <?php
                                    include_once '../config/configr.php';
                                    $grpQuery= mysqli_query($con, "SELECT * FROM group_members WHERE grp_member_username='$_SESSION[username]'");
                                    while ($grpList=mysqli_fetch_assoc($grpQuery)){ ?>
                                    <a href="groupPage.php?gid=<?php echo $grpList['grp_link']; ?>"><?php echo $grpList['grp_name'];?></a><br>
                                    <?php }
                                    ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a type="button" href="../user/notice.php" style="" class="btn btn-block  btn-link"> Notices </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a type="button" href="../user/video_tutorial.php" style=" " class="btn btn-block btn-link"> Video Tutorial </a>
                            </td>
                        </tr>
                        <tr>
                                <td>
                                <a type="button" href="../user/notes.php" style="" class="btn btn-block btn-link"> Notes </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a type="button" href="../user/search_job.php" style=" height: 40px;" class="btn btn-block  btn-link"> Job Search </a>
                            </td>
                        </tr>
                            
                            
                    </table>
                    </center>
                       
                </div>