<script
	data-route-id="pages/done"
	data-store="beardata.pages.show.{{id}}"
	data-load-store="<?php echo url('bear/pages/{{id}}') ?>"
	data-route-title="<?php echo ba_title('Page Ready!')  ?>"
	type="text/x-handlebars-template">

{{#with record}}
	<div class="ba-controls">
		{{> baControls}}
		<button data-ba-route="pages" class="btn-floating btn-medium default pull-right ml8 tooltip" title="Go back"><i class="fa fa-arrow-left"></i></button>
	</div>

	<div>
		<div class="section">
			<h2 class="page-heading animated center-align">Page Ready!</h2>
		</div>
		<div class="section max450">
			<div class="row">
				<div class="col s12">
					{{#if title}}
						<div class="center-align">
							<p>Your page is ready to go and can be accessed at <a href="<?php echo url('{{slug}}') ?>"><?php echo str_replace('http://', '', url('{{slug}}')) ?></a>.
								{{#compare status 'draft'}}
									Remember this page is a draft and will not be publicly visible until it is published.
								{{/compare}}
							</p>
							<hr class="spacer" />
							<a href="<?php echo url('/') ?>/{{slug}}" class="btn btn-lg blue c-white">Go to page</a>
						</div>
					{{else}}
						<div class="sk-circle bear-loader"></div>
					{{/if}}
				</div>
 			</div>
		</div>
	</div>
{{/with}}
</script>