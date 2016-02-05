<?php require_once(ISVIPI_ADMIN_CLS_BASE .'get_members.cls.php'); 

	//number of users per page
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
?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php if(isset($q) && $q !=='pending_deletion'){ echo ucfirst($q);} else if ($q ==='pending_deletion') echo "Pending Deletion"; ?> Members (<?php echo $t_count ?>)
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active"><?php if(isset($q) && $q !=='pending_deletion'){ echo ucfirst($q);} else if ($q ==='pending_deletion') echo "Pending Deletion"; ?> Members</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-12">
                <div class="info-box" style="padding:20px">
                	<div class="box-header">
                    	<div class="col-md-6">
                        <div class="dropdown pull-left">
                          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php if (isset($q) && $q !== 'pending_deletion'){ echo ucfirst($q);} else if ($q === 'pending_deletion') echo "Pending Deletion" ?> 
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/all/'.$order ?>">All</a></li>
                            <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/active/'.$order ?>">Active</a></li>
                            <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/inactive/'.$order ?>">Inactive</a></li>
                            <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/suspended/'.$order ?>">Suspended</a></li>
                            <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/0/pending_deletion/'.$order ?>">Pending Deletion</a></li>
                          </ul>
                        </div>
                        <div class="dropdown pull-left" style="margin-left:20px;">
                          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php if(isset($order)) echo ucfirst($order); ?> first 
                            <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$pg.'/'.$q.'/latest/' ?>">Latest first</a></li>
                            <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$pg.'/'.$q.'/oldest/'?>">Oldest first</a></li>
                          </ul>
                        </div>
                       </div>
                 
                 	  <div class="col-md-6">
                      	<form class="form-inline" action="<?php echo ISVIPI_URL .'aa/members' ?>" method="post">
                          <div class="form-group">
                            <select class="form-control" name="type">
                              <option value="id">Search by user id</option>
                              <option value="username">Search by username</option>
                              <option value="email">Search by email</option>
                              <option value="name">Search by name</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control" name="user" placeholder="enter search term">
                          </div>
                          <input type="hidden" name="aop" value="<?php echo $converter->encode('search') ?>" />
                          <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                      </div>
                    </div>
                 
                   <div class="clearfix"></div>
                </div><!-- /.info-box -->
            </div><!-- /.col-md-12 -->
            
            <div class="col-md-12">
            <form action="<?php echo ISVIPI_URL .'aa/members' ?>" method="POST">
            <table class="table table-bordered table-hover" style="background:#FFF">
                <thead>
                    <tr class="headings">
                        <th> <input type="checkbox" class="flat" id="select-all"> </th>
                        <th>#id </th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($t_count > 0 ){?>
                <?php if(is_array($get)) foreach ($get as $key => $mi) {?>
                
                    <tr class="even pointer">
                        <td class="a-center "><input type="checkbox" class="flat" name="user_id[]" value="<?php echo $mi['id'] ?>" ></td>
                        <td><?php echo $mi['id'] ?></td>
                        <td><?php echo $mi['fullname'] ?></td>
                        <td><?php echo $mi['username'] ?></td>
                        <td><?php echo $mi['email'] ?></td>
                        <td><?php echo ucfirst($mi['gender']) ?></td>
                        <td><?php echo $mi['country'] ?></td>
                        <td><?php echo user_status($mi['status']) ?></td>
                        <td><?php echo $mi['level'] ?></td>
                        <td>
                        <?php if($mi['status'] === 0){?>
                            <a data-toggle="modal" data-target="#Activate<?php echo $mi['id'] ?>" href="#" class="btn btn-success btn-xs">
                                Activate
                            </a>
                        <?php } ?>
                        <a href="<?php echo ISVIPI_URL .'profile/'.$mi['username'] ?>" class="btn btn-default btn-xs" target="_blank">View</a>
                            <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'edit/'.$converter->encode($mi['username']) ?>" class="btn btn-primary btn-xs">Edit</a>
                            <?php if($mi['status'] === 2){?>
                                <a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#Unsuspend<?php echo $mi['id'] ?>">Unsuspend</a>
                            <?php } else if ($mi['status'] !== 0 && $mi['status'] !== 9){ ?>
                                <a href="#" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#Suspend<?php echo $mi['id'] ?>">Suspend</a>
                            <?php } ?>
                            <?php if ($mi['status'] === 9){?>
                            <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('undel').'/'.$converter->encode($mi['id']) ?>" class="btn btn-success btn-xs">Remove Sch. Delete</a>
                            <?php } else { ?>
                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#Delete<?php echo $mi['id'] ?>">Schedule Deletion</a>
                            <?php } ?>
                            <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#DeleteNow<?php echo $mi['id'] ?>">Delete Now!</a>
                        </td>
                    </tr>
               <!-- Activate Member -->
                <div class="modal modal-success fade" id="Activate<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
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
                        <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Cancel</a>
                        <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('act').'/'.$converter->encode($mi['id']) ?>" class="btn btn-primary">Yes, Activate Member</a>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Suspend Member -->
                <div class="modal modal-warning" id="Suspend<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Suspend <?php echo $mi['fullname'] ?> </h4>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to suspend <strong><?php echo $mi['fullname'] ?></strong>?
                      </div>
                      <div class="modal-footer" style="margin-top:-10px;">
                        <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Cancel</a>
                        <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('sus').'/'.$converter->encode($mi['id']) ?>" class="btn btn-default">Yes, Suspend Member</a>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Unsuspend Member -->
                <div class="modal modal-success" id="Unsuspend<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header modal-h">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Unsuspend <?php echo $mi['fullname'] ?> </h4>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to unsuspend <strong><?php echo $mi['fullname'] ?></strong>?
                      </div>
                      <div class="modal-footer" style="margin-top:-10px;">
                        <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Cancel</a>
                        <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('unsus').'/'.$converter->encode($mi['id']) ?>" class="btn btn-default">Yes, Unsuspend Member</a>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Schecule to Delete Member -->
                <div class="modal modal-danger" id="Delete<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
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
                      <div class="modal-footer" style="margin-top:-10px;">
                        <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Cancel</a>
                        <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('del').'/'.$converter->encode($mi['id']) ?>" class="btn btn-default">Yes, Delete Member</a>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Delete Member NOW -->
                <div class="modal modal-danger" id="DeleteNow<?php echo $mi['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
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
                        <p style="font-weight:600; background:#FFF; color:#666; padding:10px">NOTE: Depending on the user's activites on the site, deletion could take a while.</p>
                      </div>
                      <div class="modal-footer" style="margin-top:-10px;">
                        <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Cancel</a>
                        <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('delnow').'/'.$converter->encode($mi['id']) ?>" class="btn btn-default">Yes, Delete Member</a>
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
            </div><!-- /.col-md-12 -->


        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<script>
			$('#select-all').click(function(event) {   
				if(this.checked) {
					$(':checkbox').each(function() {
						this.checked = true;                        
					});
				} else {
					$(':checkbox').each(function() {
						this.checked = false;                        
					});
				}
			});
			
			function activate(){
				document.getElementById("op").value = "<?php echo $converter->encode('mass-act') ?>";
			}
			
			function suspend(){
				document.getElementById("op").value = "<?php echo $converter->encode('mass-sus') ?>";
			}
			
			function unsuspend(){
				document.getElementById("op").value = "<?php echo $converter->encode('mass-unsus') ?>";
			}
			
			function m_delete(){
				document.getElementById("op").value = "<?php echo $converter->encode('mass-del') ?>";
			}
			
			function undelete(){
				document.getElementById("op").value = "<?php echo $converter->encode('mass-undel') ?>";
			}
		</script>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>