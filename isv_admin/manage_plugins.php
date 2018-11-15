<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php 
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_CLASSES_BASE .'plugins/class.plugins.php');
	$plugins = new plugins();
	$all = array_filter($plugins-> load_all_plugins("all"));
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Manage Plugins</h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Manage Plugins</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="alert alert-warning">
            	CAUTION: Only activate a plugin if you have the plugin files uploaded in the plugins directory. Otherwise, your site could fail to load or experience errors.
            </div>
            <div class="col-md-12">
            <form action="<?php echo ISVIPI_URL .'aa/members' ?>" method="POST">
            <table class="table table-bordered table-hover" style="background:#FFF">
                <thead>
                    <tr class="headings">
                        <th>Plugin Name</th>
                        <th>Display Name</th>
                        <th>Developer</th>
                        <th>Description</th>
                        <th>Version</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					if(is_array($all) && count($all) > 0){
						foreach($all as $key => $pl){
				?>
                    <tr class="even pointer">
                        <td><?= $pl['pluginname'] ?></td>
                        <td><?= $pl['displayname'] ?></td>
                        <td><?= $pl['developer'] ?></td>
                        <td><?= $pl['description'] ?></td>
                        <td><?= $pl['version'] ?></td>
                        <td>
							<?php if($pl['status'] === 0){?>
                            	Deactivated
                          	<?php } else if($pl['status'] === 1){ ?>
                            	Active
                            <?php } ?>
                        </td>
                        <td>
                        	<?php if($pl['status'] === 0){?>
                            	<a data-toggle="modal" data-target="#Activate<?=$pl['id'] ?>" href="#" class="btn btn-success btn-sm">
                                Activate
                            </a>
                          	<?php } else if($pl['status'] === 1){ ?>
                            	<a data-toggle="modal" data-target="#Deactivate<?=$pl['id'] ?>" href="#" class="btn btn-danger btn-sm">
                                Deactivate
                            </a>
                            <?php } ?>
                            
                        </td>
                    </tr>
               <!-- Activate Plugin -->
                <div class="modal modal-success fade" id="Activate<?=$pl['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="activate">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header modal-h">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Activate Plugin </h4>
                      </div>
                      <div class="modal-body">
                            Are you sure you want to activate this plugin?
                      </div>
                      <div class="modal-footer modal-h" style="margin-top:-10px">
                        <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Cancel</a>
                        <a href="<?php echo ISVIPI_URL .'aa/plugins/'.$converter->encode('activate').'/'.$converter->encode($pl['id']) ?>" class="btn btn-default">Activate Plugin</a>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Deactivate Plugin -->
                <div class="modal modal-danger" id="Deactivate<?=$pl['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deactivate">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Deactivate Plugin </h4>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to deactivate this plugin?
                      </div>
                      <div class="modal-footer" style="margin-top:-10px;">
                        <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Cancel</a>
                        <a href="<?php echo ISVIPI_URL .'aa/plugins/'.$converter->encode('deactivate').'/'.$converter->encode($pl['id']) ?>" class="btn btn-default">Deactivate</a>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
                
                <?php } else { ?>
                 <tr>
                    <td style="background:#FFF;">No plugins were found.</td>
                    <td style="background:#FFF;"> -- </td>
                    <td style="background:#FFF;"> -- </td>
                    <td style="background:#FFF;"> -- </td>
                    <td style="background:#FFF;"> -- </td>
                    <td style="background:#FFF;"> -- </td>
                 </tr>
                 <?php } ?>   
                    
                </tbody>
            </table>
            </div><!-- /.col-md-12 -->
        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	<script>
			function activate(){
				document.getElementById("op").value = "<?php echo $converter->encode('mass-act') ?>";
			}
			
			function deactivate(){
				document.getElementById("op").value = "<?php echo $converter->encode('mass-sus') ?>";
			}
	</script>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>