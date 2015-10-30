<?php require_once(ISVIPI_ADMIN_CLS_BASE .'get_members.cls.php'); 

	//number if users per page
	$p_limit = 20;
	
	//member type
	if (isset($PAGE[3]) && cleanGET($PAGE[3]) === 'all'){
		$q = 'all';
	} else if (isset($PAGE[3]) && cleanGET($PAGE[3]) === 'active'){
		$q = 'active';
	} else if (isset($PAGE[3]) && cleanGET($PAGE[3]) === 'inactive'){
		$q = 'inactive';
	} else if (isset($PAGE[3]) && cleanGET($PAGE[3]) === 'suspended'){
		$q = 'suspended';
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
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3> <?php if(isset($q)) echo ucfirst($q); ?> Members 
            
                <div class="m-actions">
                	<div class="dropdown inline-display">
                      <button class="btn btn-primary  btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <?php if (isset($q)) echo $q; ?>
                        <span class="fa fa-chevron-down"></span>
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$pg.'/all/'.$order ?>">All</a></li>
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$pg.'/active/'.$order ?>">Active</a></li>
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$pg.'/inactive/'.$order ?>">Inactive</a></li>
                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members/'.$pg.'/suspended/'.$order ?>">Suspended</a></li>
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
        <form class="form-inline">
        	<div class="col-lg-4">
            	<select class="form-control">
                  <option>Search by user id</option>
                  <option>Search by username</option>
                  <option>Search by email</option>
                  <option>Search by name</option>
                </select>
            </div>
            <div class="col-lg-6">
				<div class="input-group">
                  <input type="text" class="form-control" placeholder="enter search term">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Search</button>
                  </span>
                </div><!-- /input-group -->
            </div>
        </form>
        </div><!--end::search -->
    </div>
	<div class="row min-height">
	<div class="x_content">
    	<table class="table table-striped responsive-utilities jambo_table">
        	<thead>
            	<tr class="headings">
                	<th> <input type="checkbox" id="check-all" class="flat"> </th>
                	<th class="column-title">#id </th>
                    <th class="column-title">Email</th>
                  	<th class="column-title">Username</th>
                    <th class="column-title">Full Name</th>
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
                	<td class="a-center "><input type="checkbox" class="flat" name="table_records" ></td>
                    <td class=""><?php echo $mi['id'] ?></td>
                    <td class=""><?php echo $mi['email'] ?></td>
                    <td class=""><?php echo $mi['username'] ?></td>
                    <td class=""><?php echo $mi['fullname'] ?></td>
                    <td class=""><?php echo ucfirst($mi['gender']) ?></td>
                    <td class=""><?php echo $mi['country'] ?></td>
                    <td class=""><?php echo user_status($mi['status']) ?></td>
                    <td class=""><?php echo $mi['level'] ?></td>
                    <td class="">
                    <?php if($mi['status'] === 0){?>
                    	<a href="" class="btn btn-success btn-sm2">Activate</a>
                    <?php } ?>
                   	<a href="<?php echo ISVIPI_URL .'profile/'.$mi['username'] ?>" class="btn btn-default btn-sm2" target="_blank">View</a>
                        <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'edit/'.$mi['username'] ?>" class="btn btn-primary btn-sm2">Edit</a>
                        <?php if($mi['status'] === 2){?>
                        	<a href="#" class="btn btn-warning btn-sm2">Unsuspend</a>
                        <?php } else if ($mi['status'] !== 0){ ?>
                        	<a href="#" class="btn btn-warning btn-sm2">Suspend</a>
                        <?php } ?>
                        <a href="#" class="btn btn-danger btn-sm2">Delete</a>
                    </td>
         		</tr>
             <?php } ?>
             <?php } else { ?>
             <tr>
             	<td style="background:#FFF;">There are no <?php if(isset($q)) echo ucfirst($q); ?> members found.</td>
             </tr>
             <?php } ?> 
                
                
            </tbody>
    	</table>
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
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>