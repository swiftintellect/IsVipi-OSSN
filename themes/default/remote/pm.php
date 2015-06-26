<?php
$from_url = ISVIPI_URL.'messages';
$user = $_SESSION['user_id'];
getConv($ACTION[2],$user);
		if ($convCount == 0){
			echo $ACTION[2];
			echo NO_SUCH_CONV;
			exit();
		} 
?>
<script>
$(document).ready(function(){
var $cont = $('.scrollable3');
$cont[0].scrollTop = $cont[0].scrollHeight;
$cont[0].scrollTop = $cont[0].scrollHeight;
});
</script>
                                	<div class="m_list">
                                        <div class="scrollable3 emoticon">
                                        <?php 
										while ($geUtmsgs->fetch())
											{
												updMsgRead($user,$uniqID);
										?>
                                         <div>
                                         <div class="r_msg">
                                         <?php if ($user1 !== $user){?>
                                         <div class="chat_user_ico2">
                                         <a href="#" data-toggle="tooltip" data-placement="right" title="<?php getUserDetails($ACTION[2]);echo $username ?>"><i class="fa fa-user"></i></a>
                                         </div><p class="triangle-right right">
										<?php echo $message;?>
                                        <span class="chat_time">
                                        <?php 
										$time = $timestamp;echo relativeTime($time);
										?>
                                        </span>
                                        </p>
                                        <?php } else {?>
                                         <div class="chat_user_ico">
                                         <a href="#" data-toggle="tooltip" data-placement="top" title="<?php ; getUserDetails($user);echo $username ?>"><i class="fa fa-user"></i></a>
                                         </div><p class="triangle-right left green">
										 <?php echo $message;?>
                                         <span class="chat_time">
                                        <?php 
										$time = $timestamp;echo relativeTime($time);
										?>
                                        </span>
                                         </p>
                                         <?php }?>
                                         </div>
                                         </div>
                                         <?php } ?>
                                 		</div>
                                 	</div>
                               </div>
                       <script>
						$( "div" ).on({
							mouseenter: function() {
								$('#pmRefresh').timer('stop');
							},
							mouseleave: function() {
								$('#pmRefresh').timer('stop');
							},
							click: function() {
								$('#pmRefresh').timer('start');
							}
						});
						$( "textarea" ).on({
							click: function() {
								$('#pmRefresh').timer('start');
							}
						});
					  </script>

                               
