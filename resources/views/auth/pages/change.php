<script data-route-id="change" data-route-title="<?php echo ba_title('Change Password')  ?>" type="text/x-handlebars-template">
	<div class="animated bear-content max450">
		<div class="clearfix"></div>
		<hr class="spacer" />
		<h1 class="center-align"><span id="bear-speak" class="tooltip c-white" title="It's a good day." data-position="right"><?php echo trans('bear::speak.okay') ?></span></h1>
		<p class="center-align">Enter the code we sent you by email, and then enter your desired password.</p>
		<?php echo Form::open(['url' => url('bear/password/change'), 'class' => 'ba-single-column', 'data-done-route' => "/signin"]); ?>
			<div class="ba-field">
				<div class="ba-form-group" data-field-name="code">
					<label>Code</label>
					<input name="code" type="text" autocomplete="off" placeholder="Reset Code" class="ba-form-control" />
				</div>
			</div>
			<div class="ba-field">
				<div class="ba-form-group" data-field-name="password">
					<label>New Password</label>
					<input name="password" type="password" autocomplete="off" placeholder="New Password" class="ba-form-control" />
				</div>
			</div>
			<div class="ba-field">
				<div class="ba-form-group" data-field-name="password_confirmation">
					<label>Confirm Password</label>
					<input name="password_confirmation" type="password" autocomplete="off" placeholder="Confirm Password" class="ba-form-control" />
				</div>
			</div>
			<hr class="spacer" />
			<button type="submit" class="btn btn-lg pink pull-right" data-color="pink">Do It!</button>
			<p class="teal-text font-90"><a href="/signin" data-ba-route><i class="fa fa-arrow-left"></i> Actually, I remembered it.</a></p>
		<?php echo Form::close(); ?>
	</div>
</script>