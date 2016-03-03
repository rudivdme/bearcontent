<script
	data-route-id="pages/layout"
	data-store="beardata.pages.show.{{id}}"
	data-load-store="<?php echo url('bear/pages/{{id}}') ?>"
	data-route-title="<?php echo ba_title('Choose Layout')  ?>"
	type="text/x-handlebars-template">

{{#with record}}
	<div class="ba-controls">
		{{> baControls}}
		<button data-ba-route="pages" class="btn-floating btn-medium default pull-right ml8 tooltip" title="Go back"><i class="fa fa-arrow-left"></i></button>
	</div>

	<div>
		<div class="section">
			<h2 class="page-heading animated center-align">Choose Layout</h2>
		</div>
		<div class="section max800">
			<div class="row">
				<div class="col s12">
					<hr class="subtle" />
					<?php echo Form::open(['url' => url('bear/pages/{{id}}/layout'), 'data-done-route' => "pages/{{id}}/menu"]); ?>
						<input type='hidden' name="layout" value="{{layout}}" />
						<ul class="ba-image-listing-select" data-field-name="layout" data-target="input[name='layout']">
							<?php foreach (config('bear.layouts') as $layout) { ?>
								<li><a href="#" data-value="<?php echo $layout['id'] ?>">
										<img src="<?php echo url($layout['image']) ?>" />
										<?php echo $layout['description'] ?>
										<div class="selected"><i class="fa fa-check green-text"></i></div>
									</a>
								</li>
							<?php } ?>
						</ul>
						<div class="clearfix"></div>
						<hr class="spacer" />
						<button data-ba-route="pages/{{id}}/update" class="btn default"><i class="fa fa-arrow-left mr8"></i> Go Back</button>
						<button type="submit" class="btn blue pull-right">Continue <i class="fa fa-arrow-right"></i></button>
					<?php echo Form::close(); ?>
				</div>
 			</div>
		</div>
	</div>
{{/with}}
</script>