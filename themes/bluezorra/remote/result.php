<div class="profile-header">
	<?php 
		funcMemberListCount();
		funcMemberList();
		echo VALIDATED_MEMBERS ?> (<?php echo ($member_count-1)?>)
	<div class="memberlist_options pull-right">
	<div class="btn-group">
	<button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
 		<?php echo FILTER_OPTIONS ?> <span class="caret"></span>
	</button>
		<ul class="dropdown-menu" role="menu">
			<li>
				<a href="<?php echo ISVIPI_URL.'memberlist/online' ?>">
					<?php echo ONLINE_NOW ?>
				</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="<?php echo ISVIPI_URL.'memberlist/new' ?>">
					<?php echo NEW_MEMBERS ?>
				</a>
			</li>
		</ul>
	  </div>
	</div>
  </div>
</div>
<hr/>
<div class="friend_list">
    <div class="list-group">
        <?php while ($getmembers->fetch()){
                getMemberDet($id);
                GetUsernameOnly($id);
        ?> 
        <li class="list-group-item" <?php if ($id == $_SESSION['user_id']){echo 'style="display:none"';}?>>
        <!-- friend image -->
        <?php if(empty($m_thumbnail)&& $m_gender == "Male"){
            $m_thumbnail="m_.png";
         } else if(empty($m_thumbnail)&& $m_gender == "Female"){
            $m_thumbnail="f_.png";	
        }?>
        <a href="<?php echo ISVIPI_URL.'profile/'.$usrname ?>" title="<?php echo $m_name ?>" class="thumbnail">
            <img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_150.$m_thumbnail ?>"/>
        </a>
        <div class="friend_list_name">
            <a href="<?php echo ISVIPI_URL.'profile/' ?><?php echo $usrname ?>" title="<?php echo $m_name ?>">
                <?php echo $usrname ?>
            </a>
        </div>
        <?php } ?>
        </li>
    </div>
