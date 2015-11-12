<?php $pageManager->loadCustomHead('g_head','m_head'); ?>
<?php $pageManager->loadCustomHeader('g_header','m_header'); ?>
    <section id="middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="skill" style="margin-top:-25px">
						<div class="well betterwell" id="home-call">
							<img src="<?php echo ISVIPI_STYLE_URL . 'site/home_cover.jpg' ?>">
                        </div>
                    </div>
                </div><!--/.col-sm-6-->
				
                <div class="col-sm-5 uppedmargin">
                	<div id="dimmedDiv"></div>
                    <div class="col-xs-12 well signup-div">
                        <legend><i class="fa fa-user-plus"></i> Sign up!</legend>
                        <form action="<?php echo ISVIPI_URL .'p/users' ?>" method="post" class="form" role="form" id="regForm">
                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <input class="form-control" name="username" placeholder="Username*" type="text"
                                    autofocus />
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <input class="form-control" name="name" placeholder="Full Name*" type="text"/>
                            </div>
                        </div>
                        <input class="form-control" name="email" placeholder="Email*" type="email"/>
                        <input class="form-control" name="pwd" placeholder="Password*" type="password"/>
                        <input class="form-control" name="pwd2" placeholder="Re-enter Password*" type="password"/>
                        <select class="form-control" name="country">
                        	<option selected="selected" value="" disabled>Select Country*</option>
                        	<?php regCountrySelectOptions() ?>
                        </select>
                        <div class="row">
                        <div class="col-xs-6 col-md-6">
                        <label for="">Date of Birth</label>
                        <div class="clear"></div>
                        <select class="form-control prof-dob" name="dd">
                        	<option selected="selected" value="" disabled>dd</option>
                            <?php select_day() ?>
                        </select>
                        <select class="form-control prof-dob" name="mm">
                        	<option selected="selected" value="" disabled>mm</option>
                            <?php select_month() ?>
                        </select>
                        <input type="number" class="form-control prof-dob" name="yyyy" placeholder="yyyy"/>
                         </div>
                         <div class="col-xs-6 col-md-6">
                         <label for="">I am</label><br />
                        <label class="radio-inline">
                            <input type="radio" name="sex" id="inlineCheckbox1" value="male" checked/>
                            Male
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sex" id="inlineCheckbox2" value="female" />
                            Female
                        </label>
                        </div>
                        </div>
                        <div class="alert error nodisplay" id="error"></div>
                        <div class="alert success nodisplay" id="success"></div>
                        <?php if($isv_siteSettings['user_reg'] === 1){?>
                        <input type="hidden" name="isv_op" value="registration" />
                        <button class="btn btn-lg btn-success btn-block" type="submit" id="submit">Sign up</button>
                        <?php } else {?>
                        <div class="alert well alert-danger">
                        	Registration is disabled or is by invitation only.
                        </div>
                        <?php } ?>
                        </form>
                        
                        <!-- hide and show processing actions -->
                        <script>
							$( "#submit" ).click(function() {
								$('#success').css('display','none');
								$('#error').css('display','none');
								$("#dimmedDiv").show();
							});
						</script>
                        
                        <!-- prevent the form from submitting twice -->
                        <script>
						var $myForm = $("#regForm");
						$myForm.submit(function(){
							$myForm.submit(function(){
								return false;
							});
						});
						</script>
                        
                        <!-- we submit the form -->
                        <script>
							$('#regForm').ajaxForm({ 
							dataType: 'json', 
							success: function(json) { 
									//$("#submit").hide();
									$('input[type="submit"]').prop('disabled', true);
									
									setTimeout(function(){
									if(json.err == true) {
										$('#success').css('display','none');
										$('#error').css('display','block');
										$('#error').html(json.message);
									} else if (json.err == false){
										$('#error').css('display','none');
										$('#success').css('display','block');
										$('#regForm').clearForm();
										$('#success').html(json.message);
									}
									$("#dimmedDiv").hide();
									$('input[type="submit"]').prop('disabled', false);
								}, 2000);
							} 
						});
						</script>

                    </div>
                </div>

            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#middle-->
<?php $pageManager->loadCustomFooter('g_footer','m_footer'); ?>