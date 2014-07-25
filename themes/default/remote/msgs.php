<?php
$user = $_SESSION['user_id'];
?>

                                     <table class="table msglist" style="width:500px">
                                        <thead>
                                            <tr>
                                            <th width="150"><?php echo DATE ?></th>
                                            <th><?php echo CHAT_WITH ?></th>
                                            <th width="120"><?php echo ACTION ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php getAllmsgs($user);
										if ($AllmsgCount >0){
											while ($geAllmsgs->fetch()){
											newSingMsg($user,$unique_id);
										?>

                                          <?php if ($newmsgs >0){
											  unMsgCount($user,$unique_id)
											  ?>
                                          
                                          <tr class="success">
                                         <td><?php echo date('d M Y \a\t g:ia', strtotime($timestamp));?></td>
           				<td><a href="<?php echo ISVIPI_URL.'profile/'?><?php if ($user==$msg_from){$msgFrom=$msg_to;}else {$msgFrom=$msg_from;}getUserDetails($msgFrom); echo $username;?>"><?php echo $username ?></a> <span class="badge bluebg"><?php echo $unMsgs." ". NEW_M;?></span></td>
                                            <td>
                         <a href="<?php echo ISVIPI_URL.'read_pm/'?><?php if ($user==$msg_from){$msgFrom=$msg_to;} else {$msgFrom=$msg_from;}getUserDetails($msgFrom); echo $username;?>"><?php echo READ ?>
                                 <i class="fa fa-external-link"></i></a>
                                    </td>
                                        </tr>
                                        <?php } else {?>
                                        <tr class="warning">
                                         <td><?php echo date('d M Y \a\t g:ia', strtotime($timestamp));?></td>
           				<td><a href="<?php echo ISVIPI_URL.'profile/'?><?php if ($user==$msg_from){$msgFrom=$msg_to;}else {$msgFrom=$msg_from;}getUserDetails($msgFrom); echo $username;?>"><?php echo $username ?></a></td>
                                            <td>
                         <a href="<?php echo ISVIPI_URL.'read_pm/'?><?php if ($user==$msg_from){$msgFrom=$msg_to;} else {$msgFrom=$msg_from;}getUserDetails($msgFrom); echo $username;?>"><?php echo READ ?>
                                 <i class="fa fa-external-link"></i></a>
                                    </td>
                                        </tr>
                                        
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <!--end of read msgs-->
                                        <td><?php echo NO_MSGS ?></td>
                                        </tbody>
                                        
                                        <?php }?>
                                     </table>
