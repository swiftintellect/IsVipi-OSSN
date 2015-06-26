<?php getMyFriends($id);?>
<!-- friends -->
<h2 class="profile-header"><?php echo FRIENDS ?> (<?php echo $MyfriendCount ?>)</h2>
<hr/>
<div class="friend_list">
    <div class="list-group">
    	<?php while ($getfriends->fetch()){
			getMemberDet($id);
			getUserDetails($id);
		?> 
          <li class="list-group-item">
          <!-- friend image -->
              <?php if(empty($m_thumbnail)&& $m_gender == "Male"){
			  		$m_thumbnail="m_.png";
			  } else if(empty($m_thumbnail)&& $m_gender == "Female"){
					$m_thumbnail="f_.png";	
			  }?>
                <a href="<?php echo ISVIPI_URL.'profile/' ?><?php echo htmlspecialchars($username, ENT_QUOTES, 'utf-8');?>" title="<?php echo htmlspecialchars($m_name, ENT_QUOTES, 'utf-8');?>" class="thumbnail">
                  <img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_150.htmlspecialchars($m_thumbnail, ENT_QUOTES, 'utf-8');?>"/>
                </a>
                <div class="friend_list_name">
                	<a href="<?php echo ISVIPI_URL.'profile/' ?><?php echo htmlspecialchars($username, ENT_QUOTES, 'utf-8');?>" title="<?php echo htmlspecialchars($m_name, ENT_QUOTES, 'utf-8');?>">
						<?php echo htmlspecialchars($username, ENT_QUOTES, 'utf-8');?>
                  	</a>
                </div>
          <?php } ?>
          </li>
    </div>
</div>

<!-- ./friends -->
                                