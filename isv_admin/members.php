<?php require_once(ISVIPI_ADMIN_CLS_BASE .'get_members.cls.php'); 

	//number if users per page
	$p_limit = 10;
	
	//member type
	if (isset($PAGE[3]) && cleanGET($PAGE[3]) === 'all'){
		$q = 'all';
	} else if (isset($PAGE[3]) && cleanGET($PAGE[3]) === 'active'){
		$q = 'active';
	} else if (isset($PAGE[3]) && cleanGET($PAGE[3]) === 'inactive'){
		$q = 'inactive';
	} else if (isset($PAGE[3]) && cleanGET($PAGE[3]) === 'suspended'){
		$q = 'suspended';
	} else if(isset($PAGE[3]) && cleanGET($PAGE[3]) === 'pending_deletion'){
		$q = 'pending_deletion';
	} else {
		$q = 'all';
	}
	
	//instantiate our class
	$members = new get_members();
	$t_count = $members->total($q);
	
	//total number of pages
	$last_page = (int) ($t_count / $p_limit);
	
	//pagination
	if (!isset($PAGE[2]) || (isset($PAGE[2]) && $PAGE[2] === 1)){
		$pg = 0;
	} else if (isset($PAGE[2]) && $PAGE[2] < 0){
		$pg = 0;
	} else if(isset($PAGE[2]) && is_numeric(cleanGET($PAGE[2])) && $PAGE[2] !==1) {
		$pg = cleanGET($PAGE[2]);
	} else {
		$pg = 0;
	}
	
	//order by
	if(isset($PAGE[4]) && $PAGE[4] === 'latest'){
		$order = 'latest';
	} else if (isset($PAGE[4]) && $PAGE[4] === 'oldest'){
		$order = 'oldest';
	} else {
		$order = 'oldest';
	}
	
	$get = $members->all($q,$pg,$order,$p_limit);
	
	require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php'); 
?>

<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3> <?php if(isset($q) && $q !=='pending_deletion'){ echo ucfirst($q);} else if ($q ==='pending_deletion') echo "Pending Deletion"; ?> Members (<?php echo $t_count ?>)<br/>
            
                <div class="m-actions">
                	<div class="dropdown inline-display">
                      <button class="btn btn-primary  btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?php if (isset($q) && $q !== 'pending_deletion'){ echo ucfirst($q);} else if ($q === 'pending_deletion') echo "Pending Deletion" ?>
                        <span class="fa fa-chevron-down"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/all/'.$order ?>">All</a></li>
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/active/'.$order ?>">Active</a></li>
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/inactive/'.$order ?>">Inactive</a></li>
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/suspended/'.$order ?>">Suspended</a></li>
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/pending_deletion/'.$order ?>">Pending Deletion</a></li>
                      </ul>
                    </div>
                    
                    <div class="dropdown inline-display">
                      <button class="btn btn-primary  btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?php if(isset($order)) echo ucfirst($order); ?> first
                        <span class="fa fa-chevron-down"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$pg.'/'.$q.'/latest/' ?>">Latest first</a></li>
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$pg.'/'.$q.'/oldest/'?>">Oldest first</a></li>
                      </ul>
                    </div>
                </div>
            </h3>
     	</div>
        <div class="title_right m-search-bar"><!--search -->
        <form class="form-inline" action="<?php echo ISVIPI_URL .'aa/members' ?>" method="post">
        	<div class="col-lg-4">
            	<select class="form-control" name="type">
                  <option value="id">Search by user id</option>
                  <option value="username">Search by username</option>
                  <option value="email">Search by email</option>
                  <option value="name">Search by name</option>
                </select>
            </div>
            <div class="col-lg-6">
				<div class="input-group">
                  <input type="text" class="form-control" name="user" placeholder="enter search term">
                  <span class="input-group-btn">
                  	<input type="hidden" name="aop" value="search" />
                    <button class="btn btn-default" type="submit">Search</button>
                  </span>
                </div><!-- /input-group -->
            </div>
        </form>
        </div><!--end::search -->
    </div>
	<div class="row min-height">
	<div class="x_content">
    <form action="<?php echo ISVIPI_URL .'aa/members' ?>" method="POST">
    	<table class="table table-striped responsive-utilities jambo_table">
        	<thead>
            	<tr class="headings">
                	<th> <input type="checkbox" class="flat" id="select-all"> </th>
                	<th class="column-title">#id </th>
                    <th class="column-title">Full Name</th>
                  	<th class="column-title">Username</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Gender</th>
                    <th class="column-title">Country</th>
                    <th class="column-title">Status</th>
                    <th class="column-title">Level</th>
                    <th class="column-title">Action</th>
             	</tr>
          	</thead>
            <tbody>
            <?php if($t_count > 0 ){?>
            <?php if(is_array($get)) foreach ($get as $key => $mi) {?>
            
            	<tr class="even pointer">
                	<td class="a-center "><input type="checkbox" class="flat" name="user_id[]" value="<?php echo $mi['id'] ?>" ></td>
                    <td class=""><?php echo $mi['id'] ?></td>
                    <td class=""><?php echo $mi['fullname'] ?></td>
                    <td class=""><?php echo $mi['username'] ?></td>
                    <td class=""><?php echo $mi['email'] ?></td>
                    <td class=""><?php echo ucfirst($mi['gender']) ?></td>
                    <td class=""><?php echo $mi['country'] ?></td>
                    <td class=""><?php echo user_status($mi['status']) ?></td>
                    <td class=""><?php echo $mi['level'] ?></td>
                    <td class="">
                    <?php if($mi['status'] === 0){?>
                    	<a data-toggle="modal" data-target="#Activate<?php echo $mi['id'] ?>" href="#" class="btn btn-success btn-sm2">
                        	Activate
                        </a>
                    <?php } ?>
                   	<a href="<?php echo ISVIPI_URL .'profile/'.$mi['username'] ?>" class="btn btn-default btn-sm2" target="_blank">View</a>
                        <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'edit/'.$converter->encode($mi['username']) ?>" class="btn btn-primary btn-sm2">Edit</a>
                        <?php if($mi['status'] === 2){?>
                        	<a href="#" class="btn btn-success btn-sm2" data-toggle="modal" data-target="#Unsuspend<?php echo $mi['id'] ?>">Unsuspend</a>
                        <?php } else if ($mi['status'] !== 0 && $mi['status'] !== 9){ ?>
                        	<a href="#" class="btn btn-warning btn-sm2" data-toggle="modal" data-target="#Suspend<?php echo $mi['id'] ?>">Suspend</a>
                        <?php } ?>
                        <?php if ($mi['status'] === 9){?>
                        <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('undel').'/'.$converter->encode($mi['id']) ?>" class="btn btn-success btn-sm2">Remove Sch. Delete</a>
                        <?php } else { ?>
                        <a href="#" class="btn btn-danger btn-sm2" data-toggle="modal" data-target="#Delete<?php echo $mi['id'] ?>">Schedule Deletion</a>
                        <?php } ?>
                        <a href="#" class="btn btn-danger btn-sm2" data-toggle="modal" data-target="#DeleteNow<?php echo $mi['id'] ?>">Delete Now!</a>
                    </td>
         		</tr>
           <!-- Activate Member -->
            <div class="modal fade" id="Activate<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Activate <?php echo $mi['fullname'] ?> </h4>
                  </div>
                  <div class="modal-body">
                    	Are you sure you want to activate <strong><?php echo $mi['fullname'] ?></strong>?
                  </div>
                  <div class="clear"></div>
                  <div class="modal-footer modal-h">
                    <a href="#" class="btn btn-default" data-dismiss="modal" style="margin-top:5px;">Cancel</a>
                    <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('act').'/'.$converter->encode($mi['id']) ?>" class="btn btn-primary">Yes, Activate Member</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Suspend Member -->
            <div class="modal fade" id="Suspend<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Suspend <?php echo $mi['fullname'] ?> </h4>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to suspend <strong><?php echo $mi['fullname'] ?></strong>?
                  </div>
                  <div class="modal-footer modal-h">
                    <a href="#" class="btn btn-default" data-dismiss="modal" style="margin-top:5px;">Cancel</a>
                    <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('sus').'/'.$converter->encode($mi['id']) ?>" class="btn btn-primary">Yes, Suspend Member</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Suspend Member -->
            <div class="modal fade" id="Unsuspend<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Unsuspend <?php echo $mi['fullname'] ?> </h4>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to unsuspend <strong><?php echo $mi['fullname'] ?></strong>?
                  </div>
                  <div class="modal-footer modal-h">
                    <a href="#" class="btn btn-default" data-dismiss="modal" style="margin-top:5px;">Cancel</a>
                    <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('unsus').'/'.$converter->encode($mi['id']) ?>" class="btn btn-primary">Yes, Unsuspend Member</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Schecule to Delete Member -->
            <div class="modal fade" id="Delete<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Schedule <?php echo $mi['fullname'] ?> for Deletion  </h4>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to schedule <strong><?php echo $mi['fullname'] ?></strong> for deletion ? Once this has been done: 
                    <hr style="margin:10px 0" />
                    <ul>
                        <li>This user will be deleted within two weeks (14 days).</li> 
                        <li>They will not be allowed to log in at all. </li>
                    </ul>
                    <hr style="margin:10px 0" />
                    <p>This short period is aimed at notifying his/her friends of the pending deletion and giving the account owner enough time to reclaim his/her account.</p>
                  </div>
                  <div class="modal-footer modal-h">
                    <a href="#" class="btn btn-default" data-dismiss="modal" style="margin-top:5px;">Cancel</a>
                    <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('del').'/'.$converter->encode($mi['id']) ?>" class="btn btn-primary">Yes, Delete Member</a>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Delete Member NOW -->
            <div class="modal fade" id="DeleteNow<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header modal-h">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete <?php echo $mi['fullname'] ?> NOW!  </h4>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete <strong><?php echo $mi['fullname'] ?></strong> NOW? Once this has been done: 
                    <hr style="margin:10px 0" />
                    <ul>
                        <li>This user will be deleted immediately without having to wait for the 14 days grace period.</li> 
                        <li>All their site activities will be deleted immediately.</li>
                    </ul>
                    <hr style="margin:10px 0" />
                    <p>We strongly recommend that you use "Schedule Deletion" which allows the user 14 days to reclaim his/her account. If you however want it deleted immediately, please procees.</p>
                    <p style="font-weight:600; background:#09F; color:#FFF; padding:10px">NOTE: Depending on the user's activites on the site, deletion could take a while.</p>
                  </div>
                  <div class="modal-footer modal-h">
                    <a href="#" class="btn btn-default" data-dismiss="modal" style="margin-top:5px;">Cancel</a>
                    <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('delnow').'/'.$converter->encode($mi['id']) ?>" class="btn btn-primary">Yes, Delete Member</a>
                  </div>
                </div>
              </div>
            </div>

             <?php } ?>
             
             <?php } else { ?>
             <tr>
             	<td style="background:#FFF;">There are no <?php if (isset($q) && $q !== 'pending_deletion'){ echo ucfirst($q);} else if ($q === 'pending_deletion') echo "Pending Deletion" ?> members found.</td>
                <td style="background:#FFF;"> -- </td>
                <td style="background:#FFF;"> -- </td>
                <td style="background:#FFF;"> -- </td>
                <td style="background:#FFF;"> -- </td>
                <td style="background:#FFF;"> -- </td>
                <td style="background:#FFF;"> -- </td>
                <td style="background:#FFF;"> -- </td>
                <td style="background:#FFF;"> -- </td>
                <td style="background:#FFF;"> -- </td>
             </tr>
             <?php } ?> 
                
                
            </tbody>
    	</table>
        <?php if($t_count > 0 ){?>
            <input type="hidden" name="aop" id="op" value="mass-act" />
            <input type="submit" class="btn btn-default btn-sm" name="submit" value="Activate Selected" onclick="activate();"/>
            <input type="submit" class="btn btn-warning btn-sm" name="submit" value="Suspend Selected" onclick="suspend();"/>
            <input type="submit" class="btn btn-primary btn-sm" name="submit" value="Unsuspend Selected" onclick="unsuspend();"/>
            <input type="submit" class="btn btn-danger btn-sm" name="submit" value="Schedule Deletion for Selected" onclick="m_delete();"/>
            <input type="submit" class="btn btn-success btn-sm" name="submit" value="Remove Scheduled Deletion for Selected" onclick="undelete();"/>
        </form>
        <?php } ?>
        <?php 
			$prev = $pg - 1;
			$next = $pg + 1; 
			if($t_count > $p_limit){
		?>
        <nav>
          <ul class="pagination">
            <li <?php if ($pg == 0){?> class="disabled" <?php } ?>>
              <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$prev.'/'.$q.'/'.$order ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo; prev</span>
              </a>
            </li>
            <li <?php if ($pg == $last_page){?> class="disabled" <?php } ?>>
              <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$next.'/'.$q.'/'.$order ?>" aria-label="Next">
                <span aria-hidden="true">&raquo; next</span>
              </a>
            </li>
          </ul>
        </nav>
        <?php } ?>
        <hr />
    
    </div><!-- end::x_content -->
</div><!-- end::row -->
<script>
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
});

function activate(){
	document.getElementById("op").value = "mass-act";
}

function suspend(){
	document.getElementById("op").value = "mass-sus";
}

function unsuspend(){
	document.getElementById("op").value = "mass-unsus";
}

function m_delete(){
	document.getElementById("op").value = "mass-del";
}

function undelete(){
	document.getElementById("op").value = "mass-undel";
}
</script>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>