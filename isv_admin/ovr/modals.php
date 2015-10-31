<?php if($PAGE[1] === 'members') {?>
<!-- load modals for the members page -->

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
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="<?php echo ISVIPI_URL .'aa/members/'.$converter->encode('act').'/'.$converter->encode($mi['id']) ?>" type="button" class="btn btn-primary">Yes, Activate Member</a>
      </div>
    </div>
  </div>
</div>




<?php } ?>