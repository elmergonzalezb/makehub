<div class="ihc-subtab-menu">
	<a class="ihc-subtab-menu-item <?php echo ($_REQUEST['subtab'] =='settings' || !isset($_REQUEST['subtab'])) ? 'ihc-subtab-selected' : '';?>" href="<?php echo $url.'&tab='.$tab.'&subtab=settings';?>"><?php _e('Settings', 'ihc');?></a>
	<a class="ihc-subtab-menu-item <?php echo ($_REQUEST['subtab'] =='design') ? 'ihc-subtab-selected' : '';?>" href="<?php echo $url.'&tab='.$tab.'&subtab=design';?>"><?php _e('Design', 'ihc');?></a>
	<?php
	$arr = array(
			"fb" => "Facebook",
			"tw" => "Twitter",
			"goo" => "Google",
			"in" => "LinkedIn",
			"vk" => "Vkontakte",
			"ig" => "Instagram",
			"tbr" => "Tumblr"
	);
	foreach ($arr as $k=>$v){
		?>
		<a class="ihc-subtab-menu-item" href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item='.$k;?>"><?php echo $v;?></a>
		<?php
	}
	?>
	<div class="ihc-clear"></div>
</div>
<?php
if (empty($_GET['subtab'])){
	$_GET['subtab'] = 'settings';
}
echo ihc_inside_dashboard_error_license();
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();

if ($_GET['subtab']=='settings'){
	//===================== SETTINGS PAGE
	if (empty($_GET['item'])){
		////// GENERAL SETTINGS
		?>
			<div class="iump-page-title">Ultimate Membership Pro -
				<span class="second-text">
					<?php _e('Social Media Login', 'ihc');?>
				</span>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("fb"); ?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=fb';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Facebook</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("tw"); ?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=tw';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Twitter</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("goo");?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=goo';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Google</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("in"); ?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=in';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">LinkedIn</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("vk");?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=vk';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Vkontakte</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("ig");?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=ig';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Instagram</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

			<div class="iump-sm-list-wrapper">
				<div class="iump-sm-box-wrap">
					<?php $status = ihc_check_social_status("tbr");?>
				  	<a href="<?php echo $url.'&tab='.$tab.'&subtab=settings&item=tbr';?>">
					<div class="iump-sm-box <?php echo $status['active']; ?>">
						<div class="iump-sm-box-title">Tumblr</div>
						<div class="iump-sm-box-bottom"><?php _e("Settings:", "ihc");?> <span><?php echo $status['settings']; ?></span></div>
					</div>
				 	</a>
				</div>
			</div>

		<?php
	} else {
		switch ($_GET['item']){
			case 'fb':
				ihc_save_update_metas('fb');
				$meta_arr = ihc_return_meta_arr('fb');
				?>
				<div class="iump-page-title">Ultimate Membership Pro -
					<span class="second-text">
						<?php _e('Social Media Login', 'ihc');?>
					</span>
				</div>
				<form action="" method="post">
					<div class="ihc-stuffbox">
						<h3><?php _e('Facebook Activation:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<h4><?php _e("Once everything is set up, activate Facebook login to use it.", "ihc");?></h4>
								<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
								<?php $checked = ($meta_arr['ihc_fb_status']) ? 'checked' : '';?>
								<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_fb_status');" <?php echo $checked;?> />
								<div class="switch" style="display:inline-block;"></div>
							</label>
							<input type="hidden" value="<?php echo $meta_arr['ihc_fb_status'];?>" name="ihc_fb_status" id="ihc_fb_status" />
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
					<div class="ihc-stuffbox">
						<h3><?php _e('Facebook Settings:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Application ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_fb_app_id'];?>" name="ihc_fb_app_id" style="width: 300px;" />
							</div>
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_fb_app_secret'];?>" name="ihc_fb_app_secret" style="width: 300px;" />
							</div>
							<div style="font-size: 11px; color: #333; padding-left: 10px;">
								<div style="font-size: 14px;"><h4><?php _e("How to create a Facebook App")?></h4></div>

								<ul class="ihc-info-list">
								<li><?php _e("Go to :", "ihc");?><a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a></li>
								<li><?php _e('Select "Add a New App" from the "My Apps" menu at the top.', 'ihc');?></li>
								<li><?php _e('Select "Site Web", fill out display name and click "Create New Facebook App ID".', 'ihc');?></li>
								<li><?php _e('Select a category from the popup that shows up and then click "Create App ID".', 'ihc');?></li>
								<li><?php _e('Fill out display name, choose a category and click "Create App".', 'ihc');?></li>
								<li><?php
									_e('After that in the "Tell us about your website" section you must add site URL : ', 'ihc');echo "<b>".site_url()."</b>";
									_e(' click "Next".', 'ihc');
								?></li>
								<li><?php _e('The application was created but it is not active.', 'ihc');?></li>
								<li><?php _e('To activate it, go to top menu "My Apps" and select the name of your app.', 'ihc');?></li>
								<li><?php _e('In the left menu go to "Settings"->"Basic" and fill out "Contact Email" and save.', 'ihc');?></li>
								<li><?php _e('Next you must go to left menu at "Status & Review" and make your app public.', 'ihc');?></li>
								<li><?php _e('You will find the "App ID" and "App Secret" in the "Dashboard" section.', 'ihc')?></li>
                                <li><?php _e("Set Valid OAuth Redirect URIs with: "); echo '<strong>'.IHC_URL.'classes/hybrid_auth/hybridauth/?hauth_done=Facebook'.'</strong>'; ?></li>
								</ul>
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
				</form>
				<?php
				break;

			case 'tw':
				ihc_save_update_metas('tw');
				$meta_arr = ihc_return_meta_arr('tw');
				?>
								<div class="iump-page-title">Ultimate Membership Pro -
									<span class="second-text">
										<?php _e('Social Media Login', 'ihc');?>
									</span>
								</div>
								<form action="" method="post">
									<div class="ihc-stuffbox">
										<h3><?php _e('Twitter Activation:', 'ihc');?></h3>
										<div class="inside">
											<div class="iump-form-line">
												<h4><?php _e("Once everything is set up, activate Twitter login to use it.", "ihc");?></h4>
												<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
												<?php $checked = ($meta_arr['ihc_tw_status']) ? 'checked' : '';?>
												<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_tw_status');" <?php echo $checked;?> />
												<div class="switch" style="display:inline-block;"></div>
											</label>
											<input type="hidden" value="<?php echo $meta_arr['ihc_tw_status'];?>" name="ihc_tw_status" id="ihc_tw_status" />
											</div>
											<div class="ihc-wrapp-submit-bttn iump-submit-form">
												<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
											</div>
										</div>
									</div>
									<div class="ihc-stuffbox">
										<h3><?php _e('Twitter Settings:', 'ihc');?></h3>
										<div class="inside">
											<div class="iump-form-line">
												<label class="iump-labels"><?php _e('Application Key:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_tw_app_key'];?>" name="ihc_tw_app_key" style="width: 300px;" />
											</div>
											<div class="iump-form-line">
												<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_tw_app_secret'];?>" name="ihc_tw_app_secret" style="width: 300px;" />
											</div>
											<div style="font-size: 11px; color: #333; padding-left: 10px;">
												<div style="font-size: 14px;"><h4><?php _e("How to create a Twitter App")?></h4></div>
												<ul class="ihc-info-list">
												<li><?php _e("Go to :", "ihc");?><a href="https://dev.twitter.com/apps" target="_blank">https://dev.twitter.com/apps</a></li>
												<li><?php _e('Click "Create New App".', 'ihc');?></li>
												<li><?php _e('Fill out the "Name", "Description", "Site URL". At "Callback URL" you must add: ', 'ihc'); echo '<b>'.site_url().'</b>';?></li>
												<li><?php _e('You will find the "Consumer Key" (API Key) and "Consumer Secret" (API Secret) in the "Keys and Access Tokens" section.', 'ihc');?></li>
												</ul>
											</div>
											<div class="ihc-wrapp-submit-bttn iump-submit-form">
												<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
											</div>
										</div>
									</div>
								</form>
								<?php
				break;

			case 'in':
				ihc_save_update_metas('in');
				$meta_arr = ihc_return_meta_arr('in');
				?>
							<div class="iump-page-title">Ultimate Membership Pro -
								<span class="second-text">
									<?php _e('Social Media Login', 'ihc');?>
								</span>
							</div>
							<form action="" method="post">
								<div class="ihc-stuffbox">
									<h3><?php _e('LinkedIn Activation:', 'ihc');?></h3>
									<div class="inside">
										<div class="iump-form-line">
											<h4><?php _e("Once everything is set up, activate LinkedIn login to use it.", "ihc");?></h4>
											<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
												<?php $checked = ($meta_arr['ihc_in_status']) ? 'checked' : '';?>
												<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_in_status');" <?php echo $checked;?> />
												<div class="switch" style="display:inline-block;"></div>
											</label>
											<input type="hidden" value="<?php echo $meta_arr['ihc_in_status'];?>" name="ihc_in_status" id="ihc_in_status" />
										</div>
										<div class="ihc-wrapp-submit-bttn iump-submit-form">
											<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
										</div>
									</div>
								</div>
								<div class="ihc-stuffbox">
									<h3><?php _e('LinkedIn Settings:', 'ihc');?></h3>
									<div class="inside">
										<div class="iump-form-line">
											<label class="iump-labels"><?php _e('Application Key:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_in_app_key'];?>" name="ihc_in_app_key" style="width: 300px;" />
										</div>
										<div class="iump-form-line">
											<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_in_app_secret'];?>" name="ihc_in_app_secret" style="width: 300px;" />
										</div>

										<div style="font-size: 11px; color: #333; padding-left: 10px;">
											<div style="font-size: 14px;"><h4><?php _e("How to create a LinkedIn App")?></h4></div>
											<ul class="ihc-info-list">
											<li><?php _e("Go to :", "ihc");?><a href="https://www.linkedin.com/secure/developer" target="_blank">https://www.linkedin.com/secure/developer</a></li>
											<li><?php _e('Click "Create Application".', 'ihc');?></li>
											<li><?php _e('Fill the required fields and submit.', 'ihc');?></li>
											<li><?php _e('After you create the app, in the left menu go to "Settings" and change "Application Status" to "Live".', 'ihc');?></li>
											<li><?php _e('You will find the "App Key" and "App Secret" in the "Authentication" section.', 'ihc');?></li>
											</ul>
										</div>

										<div class="ihc-wrapp-submit-bttn iump-submit-form">
											<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
										</div>
									</div>
								</div>
							</form>
						<?php
				break;

			case 'tbr':
					ihc_save_update_metas('tbr');
					$meta_arr = ihc_return_meta_arr('tbr');
					?>
					<div class="iump-page-title">Ultimate Membership Pro -
						<span class="second-text">
							<?php _e('Social Media Login', 'ihc');?>
						</span>
					</div>
					<form action="" method="post">
						<div class="ihc-stuffbox">
							<h3><?php _e('Tumblr Activation:', 'ihc');?></h3>
							<div class="inside">
								<div class="iump-form-line">
									<h4><?php _e("Once everything is set up, activate Tumblr login to use it.", "ihc");?></h4>
									<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
										<?php $checked = ($meta_arr['ihc_tbr_status']) ? 'checked' : '';?>
										<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_tbr_status');" <?php echo $checked;?> />
										<div class="switch" style="display:inline-block;"></div>
									</label>
									<input type="hidden" value="<?php echo $meta_arr['ihc_tbr_status'];?>" name="ihc_tbr_status" id="ihc_tbr_status" />
								</div>
								<div class="ihc-wrapp-submit-bttn iump-submit-form">
									<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
								</div>
							</div>
						</div>
						<div class="ihc-stuffbox">
							<h3><?php _e('Tumblr Settings:', 'ihc');?></h3>
							<div class="inside">
								<div class="iump-form-line">
									<label class="iump-labels"><?php _e('Application Key:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_tbr_app_key'];?>" name="ihc_tbr_app_key" style="width: 300px;" />
								</div>
								<div class="iump-form-line">
									<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_tbr_app_secret'];?>" name="ihc_tbr_app_secret" style="width: 300px;" />
								</div>

								<div style="font-size: 11px; color: #333; padding-left: 10px;">
									<div style="font-size: 14px;"><h4><?php _e("How to create a Tumblr App")?></h4></div>
									<ul class="ihc-info-list">
									<li><?php _e("Go to :", "ihc");?><a href="http://www.tumblr.com/oauth/apps" target="_blank">http://www.tumblr.com/oauth/apps</a></li>
									<li><?php _e('Register a new application.', 'ihc');?>
									<li><?php _e("Fill out the required fields and submit.", 'ihc');?></li>
									<li><?php _e('Set the "Default callback URL" as:', 'ihc');echo site_url();?></li>
									<li><?php _e('After submitting you will find "Application Key" and "Application Secret" just beside the App Logo.', 'ihc');?></li>
									</ul>
								</div>

								<div class="ihc-wrapp-submit-bttn iump-submit-form">
									<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
								</div>
							</div>
						</div>
					</form>
					<?php
				break;
			case 'ig':
				ihc_save_update_metas('ig');
				$meta_arr = ihc_return_meta_arr('ig');
				?>
				<div class="iump-page-title">Ultimate Membership Pro -
					<span class="second-text">
						<?php _e('Social Media Login', 'ihc');?>
					</span>
				</div>
				<form action="" method="post">
					<div class="ihc-stuffbox">
						<h3><?php _e('Instagram Activation:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<h4><?php _e("Once everything is set up, activate Instagram login to use it.", "ihc");?></h4>
								<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
									<?php $checked = ($meta_arr['ihc_ig_status']) ? 'checked' : '';?>
									<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_ig_status');" <?php echo $checked;?> />
									<div class="switch" style="display:inline-block;"></div>
								</label>
								<input type="hidden" value="<?php echo $meta_arr['ihc_ig_status'];?>" name="ihc_ig_status" id="ihc_ig_status" />
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
					<div class="ihc-stuffbox">
						<h3><?php _e('Instagram Settings:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Client ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_ig_app_id'];?>" name="ihc_ig_app_id" style="width: 300px;" />
							</div>
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Client Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_ig_app_secret'];?>" name="ihc_ig_app_secret" style="width: 300px;" />
							</div>
							<div style="font-size: 11px; color: #333; padding-left: 10px;">
								<div style="font-size: 14px;"><h4><?php _e("How to create a Instagram App")?></h4></div>
								<ul class="ihc-info-list">
								<li><?php _e("Go to :", "ihc");?><a href="http://instagr.am/developer/clients/manage/" target="_blank">http://instagr.am/developer/clients/manage/</a></li>
								<li><?php _e('Register a new application.', 'ihc');?></li>
								<li><?php _e("Fill out the required fields.", 'ihc')?></li>
								<li><?php _e('Set the "Callback URL" for your application as: ', 'ihc');echo IHC_URL . 'classes/hybrid_auth/hybridauth/?hauth.done=Instagram';?></li>
								<li><?php _e('After submitting you will find "Client Id" and "Client Secret" in the "Manage Clients" section.', 'ihc')?></li>
								</ul>
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
				</form>
					<?php
				break;
			case 'vk':
				ihc_save_update_metas('vk');
				$meta_arr = ihc_return_meta_arr('vk');
				?>
				<div class="iump-page-title">Ultimate Membership Pro -
					<span class="second-text">
						<?php _e('Social Media Login', 'ihc');?>
					</span>
				</div>
				<form action="" method="post">
					<div class="ihc-stuffbox">
						<h3><?php _e('Vkontakte Activation:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<h4><?php _e("Once everything is set up, activate Vkontakte login to use it.", "ihc");?></h4>
								<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
									<?php $checked = ($meta_arr['ihc_vk_status']) ? 'checked' : '';?>
									<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_vk_status');" <?php echo $checked;?> />
									<div class="switch" style="display:inline-block;"></div>
								</label>
								<input type="hidden" value="<?php echo $meta_arr['ihc_vk_status'];?>" name="ihc_vk_status" id="ihc_vk_status" />
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
					<div class="ihc-stuffbox">
						<h3><?php _e('Vkontakte Settings:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Application ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_vk_app_id'];?>" name="ihc_vk_app_id" style="width: 300px;" />
							</div>
							<div class="iump-form-line">
								<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_vk_app_secret'];?>" name="ihc_vk_app_secret" style="width: 300px;" />
							</div>

							<div style="font-size: 11px; color: #333; padding-left: 10px;">
								<div style="font-size: 14px;"><h4><?php _e("How to create a VK App")?></h4></div>
								<ul class="ihc-info-list">
								<li><?php _e("Go to :", "ihc");?><a href="http://vk.com/developers.php" target="_blank">http://vk.com/developers.php</a></li>
								<li><?php _e("Create a new application.", 'ihc')?></li>
								<li><?php _e('For "Category" you must set as "Website".', 'ihc');?></li>
								<li><?php _e('After submitting go to "Settings" and set the "Authorized redirect URI" as :', 'ihc');echo IHC_URL . 'classes/hybrid_auth/hybridauth/';?></li>
								<li><?php _e('Be sure "Application status" is set to "Application on and visible to all".', 'ihc')?></li>
								<li><?php _e('Save settings and copy the "Application ID" and "Application Secret".', 'ihc');?></li>
								</ul>
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
				</form>
			<?php
			break;

			case 'goo':
				ihc_save_update_metas('goo');
				$meta_arr = ihc_return_meta_arr('goo');
				?>
				<div class="iump-page-title">Ultimate Membership Pro -
					<span class="second-text">
						<?php _e('Social Media Login', 'ihc');?>
					</span>
				</div>
				<form action="" method="post">
					<div class="ihc-stuffbox">
						<h3><?php _e('Google Activation:', 'ihc');?></h3>
						<div class="inside">
							<div class="iump-form-line">
								<h4><?php _e("Once everything is set up, activate Google login to use it.", "ihc");?></h4>
								<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
									<?php $checked = ($meta_arr['ihc_goo_status']) ? 'checked' : '';?>
									<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_goo_status');" <?php echo $checked;?> />
									<div class="switch" style="display:inline-block;"></div>
								</label>
								<input type="hidden" value="<?php echo $meta_arr['ihc_goo_status'];?>" name="ihc_goo_status" id="ihc_goo_status" />
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
						</div>
					</div>
					<div class="ihc-stuffbox">
						<h3><?php _e('Google Settings:', 'ihc');?></h3>
							<div class="inside">
								<div class="iump-form-line">
									<label class="iump-labels"><?php _e('Application ID:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_goo_app_id'];?>" name="ihc_goo_app_id" style="width: 300px;" />
								</div>
								<div class="iump-form-line">
									<label class="iump-labels"><?php _e('Application Secret:', 'ihc');?></label> <input type="text" value="<?php echo $meta_arr['ihc_goo_app_secret'];?>" name="ihc_goo_app_secret" style="width: 300px;" />
								</div>

							<div style="font-size: 11px; color: #333; padding-left: 10px;">
								<div style="font-size: 14px;"><h4><?php _e("How to create a Google App")?></h4></div>
								<ul class="ihc-info-list">
								<li><?php _e("Go to: ", "ihc");?><a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a></li>
								<li><?php _e("Create new project.", 'ihc')?></li>
								<li><?php _e('Go to "ocial APIs" -> "Google+ API" and enable API.', 'ihc');?></li>
								<li><?php _e('Go to "Credentials" -> "Credentials", at "add credentials" select "OAuth 2.0 client ID".', 'ihc');?></li>
								<li><?php _e('Select web application, and set the "Authorized redirect URI" as : ', 'ihc'); echo IHC_URL . 'classes/hybrid_auth/hybridauth/?hauth.done=Google';?></li>
								<li><?php _e('After submitting a popup will appear with "Application ID" and "Application Secret".', 'ihc');?></li>
								</ul>
							</div>
							<div class="ihc-wrapp-submit-bttn iump-submit-form">
								<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
							</div>
							</div>
					</div>
				</form>
			<?php
		break;
		}
	}
} else {
	//===================== DESIGN
	ihc_save_update_metas('social_media');//save update metas
	$meta_arr = ihc_return_meta_arr('social_media');//getting metas
	?>
	<div class="iump-page-title">Ultimate Membership Pro -
		<span class="second-text">
			<?php _e('Social Media Login', 'ihc');?>
		</span>
	</div>
		<form action="" method="post">
			<div class="ihc-stuffbox">
				<h3><?php _e("Settings", "ihc");?></h3>
				<div class="inside">
					<div class="iump-form-line">
						<label class="iump-labels"><?php _e("Template", 'ihc');?></label>
							<select name="ihc_sm_template"><?php
								$templates = array("ihc-sm-template-1" => "Awesome Template One","ihc-sm-template-2" => "Split Box Template","ihc-sm-template-3" => "Shutter Color Template","ihc-sm-template-4" => "Margarita Template","ihc-sm-template-5" => "Picaso Template");
								foreach ($templates as $k=>$v){
									$selected = ($meta_arr['ihc_sm_template']==$k) ? "selected" : '';
									?>
										<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
									<?php
								}
							?></select>
					</div>
					<div class="iump-form-line">
						<label class="iump-labels"><?php _e("Show Label", 'ihc');?></label>
						<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
								<?php $checked = (!empty($meta_arr['ihc_sm_show_label'])) ? 'checked' : '';?>
								<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_sm_show_label');" <?php echo $checked;?> />
								<div class="switch" style="display:inline-block;"></div>
						</label>
						<input type="hidden" value="<?php echo $meta_arr['ihc_sm_show_label'];?>" name="ihc_sm_show_label" id="ihc_sm_show_label" />
					</div>

					<div style="margin-top: 15px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
			<div class="ihc-stuffbox">
				<h3><?php _e("Top Content", 'ihc');?></h3>
				<div class="inside">
					<div>
						<?php
							$settings = array(
												'media_buttons' => true,
												'textarea_name'=>'ihc_sm_top_content',
												'textarea_rows' => 5,
												'tinymce' => true,
												'quicktags' => true,
												'teeny' => true,
											);
							wp_editor(ihc_correct_text($meta_arr['ihc_sm_top_content']), 'tag-description', $settings);
						?>
					</div>
					<div style="margin-top: 15px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
			<div class="ihc-stuffbox">
				<h3><?php _e("Bottom Content", 'ihc');?></h3>
				<div class="inside">
					<div>
						<?php
							$settings = array(
												'media_buttons' => true,
												'textarea_name'=>'ihc_sm_bottom_content',
												'textarea_rows' => 5,
												'tinymce' => true,
												'quicktags' => true,
												'teeny' => true,
											);
							wp_editor(ihc_correct_text($meta_arr['ihc_sm_bottom_content']), 'tag-description', $settings);
						?>
					</div>
					<div style="margin-top: 15px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
			<div class="ihc-stuffbox">
				<h3><?php _e("Custom CSS", 'ihc');?></h3>
				<div class="inside">
					<div>
						<textarea name="ihc_sm_custom_css" class="ihc-dashboard-textarea-full"><?php echo $meta_arr['ihc_sm_custom_css'];?></textarea>
					</div>
					<div style="margin-top: 15px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
					</div>
				</div>
			</div>
		</form>
	<?php
}
