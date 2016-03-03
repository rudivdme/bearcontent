<script data-route-id="reset" data-route-title="<?php echo ba_title('Reset Password')  ?>" type="text/x-handlebars-template">
	<div class="animated bear-content max450">
		<div class="clearfix"></div>
		<hr class="spacer" />
		<h1 class="center-align"><?php echo trans('bear::speak.oops') ?></h1>
		<p class="center-align">To reset your password, just enter your email address below and we'll send a reset code in the mail.</p>
		<?php echo Form::open(['url' => url('bear/password'), 'class' => 'ba-single-column']); ?>
			<div class="ba-field">
				<div class="ba-form-group" data-field-name="email">
					<label>Email</label>
					<input name="email" type="text" autocomplete="off" placeholder="Enter email address" class="ba-form-control" />
				</div>
			</div>
			<hr class="spacer" />
			<button type="submit" class="btn btn-lg pink pull-right" data-color="pink">Get It</button>
			<p class="teal-text font-90"><a href="/signin" data-ba-route><i class="fa fa-arrow-left"></i> Actually, I remembered it.</a></p>
		<?php echo Form::close(); ?>
	</div>
</script>