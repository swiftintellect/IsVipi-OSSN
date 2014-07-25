<?php $user = $_SESSION['user_id']; ?>
                      <div id="not-bar">
                        <a href="<?php echo ISVIPI_URL.'notifications/' ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo NOTIFICATIONS ?>"><div class="not-boxes"><i class="fa fa-bell-o"></i><?php global $user; global $noticesno; global $pendreq; global $username; getUnseenNotices($user); if ($noticesno >0){ echo '<span class="badge badge-info"> '.$noticesno.' </span>';}else{};?></div></a>
                        <a href="<?php echo ISVIPI_URL.'messages/' ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo NEW_MSGS ?>"><div class="not-boxes"><i class="fa fa-envelope-o"></i><sup><?php global $newmsg; newMsgs($user); if ($newmsg >0){ echo '<span class="badge badge-success"> '.$newmsg.' </span>';}else{};?></sup></div></a>
                        <a href="<?php echo ISVIPI_URL.'friend_requests/' ?>" data-toggle="tooltip" data-placement="bottom"title="<?php echo F_REQUESTS ?>"><div class="not-boxes"><i class="fa fa-user"></i><sup>
                        <?php if(pendingFReq($user)){ echo '<span class="badge badge-warning"> '.$pendreq.' </span>';}else{};?></sup></div></a>
                      </div>
                      </div>
                      
