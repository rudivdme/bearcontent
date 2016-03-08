<script data-route-id="signin" data-route-title="<?php echo ba_title('Sign In')  ?>"  type="text/x-handlebars-template">
	<div class="container bear-content animated max450">
		<div class="clearfix"></div>
		<hr class="spacer" />
		<h1 class="center-align"><span id="bear-speak" class="ba-tooltip c-white" title="It's a good day." data-position="right"><?php echo trans('bear::speak.hello') ?></span></h1>
		<p class="center-align">Please enter your username and password to sign in.</p>
		<?php echo Form::open(['url' => url('bear/login'), 'class' => 'ba-single-column']); ?>
			<div class="ba-field">
				<div class="ba-form-group" data-field-name="email">
					<label>Email</label>
					<input name="email" type="text" placeholder="Enter email address" class="ba-form-control" />
				</div>
			</div>
			<div class="ba-field">
				<div class="ba-form-group" data-field-name="password">
					<label>Password</label>
					<input name="password" type="password" placeholder="Enter password" class="ba-form-control" />
				</div>
			</div>
			<hr class="spacer" />
			<button type="submit" class="btn blue pull-right waves-effet waves-light w150">Sign In</button>
			<p class="teal-text font-90"><a href="/reset" data-ba-route><i class="fa fa-question-circle"></i> Oops, I don't know my password.</a></p>
		<?php echo Form::close(); ?>
	</div>
</script>