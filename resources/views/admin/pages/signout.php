<script data-route-id="signout" data-route-title="<?php echo ba_title('Goodbye!')  ?>" type="text/x-handlebars-template">

	<div data-post-immediately="<?php echo url('bear/logout') ?>">
		<div class="section center-align">
			<hr class="spacer" />
			<h3>Goodbye!</h3>
			<p>We're signing you out, please wait...</p>
			<hr class="spacer" />
			<div class="sk-circle bear-loader"></div>
		</div>
	</div>

</script>