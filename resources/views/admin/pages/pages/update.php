<script
	data-route-id="pages/update"
	data-store="beardata.pages.show.{{id}}"
	data-load-store="<?php echo url('bear/pages/{{id}}') ?>"
	data-route-title="<?php echo ba_title('Update Page')  ?>"
	type="text/x-handlebars-template">

{{#with record}}
	<div class="ba-controls">
		{{> baControls}}
		<button data-ba-route="pages" class="btn-floating btn-medium default pull-right ml8 tooltip" title="Go back"><i class="fa fa-arrow-left"></i></button>
	</div>

	<div data-store="beardata.pages.show.{{id}}" data-load-store="<?php echo url('bear/pages/{{id}}') ?>">
		<div class="section">
			<h2 class="page-heading animated center-align">Update Page</h2>
		</div>
		<div class="section max800">
			<div class="row">
				<div class="col s12">
					<hr class="subtle" />
					<?php echo Form::open(['url' => url('bear/pages/{{id}}/edit'), 'data-done-route' => "pages/{{id}}/layout"]); ?>
						<div class="ba-field">
							<div class="ba-form-group" data-field-name="title">
								<label>Title</label>
								<input value="{{title}}" name="title" type="text" autocomplete="off" placeholder="Enter page title" class="ba-form-control generate-slug" data-target="input[name='slug']" />
							</div>
						</div>
						<div class="ba-field">
							<div class="ba-form-group" data-field-name="slug">
								<label>Slug <small>(shown in address bar)</small></label>
								<input value="{{slug}}" name="slug" type="text" autocomplete="off" placeholder="Enter page slug" class="ba-form-control" />
							</div>
						</div>
						<div class="ba-field">
							<div class="ba-form-group" data-field-name="private">
								<label>Page availability</label>
								<div class="switch ba-switch-field">
									<label>
										Public
										<input type="checkbox" name="private" value="true" {{#compare private 'true'}}checked="checked"{{/compare}} />
										<span class="lever"></span>
										Private
									</label>
								</div>
							</div>
						</div>
						<hr class="spacer" />
						<button data-ba-route="pages" class="btn default"><i class="fa fa-arrow-left mr8"></i> Go Back</button>
						<button type="submit" class="btn blue pull-right">Continue <i class="fa fa-arrow-right"></i></button>
					<?php echo Form::close(); ?>
				</div>
 			</div>
		</div>
	</div>
{{/with}}
</script>