<script
	data-route-id="pages/create"
	data-store="beardata.pages.create"
	data-route-title="<?php echo ba_title('Create Page')  ?>"
	type="text/x-handlebars-template">

	<div class="ba-controls">
		{{> baControls}}
		<button data-ba-route="pages" class="btn-floating btn-medium default pull-right ml8 ba-tooltip" title="Go back"><i class="fa fa-arrow-left"></i></button>
	</div>

	<div>
		<div class="section">
			<h2 class="page-heading animated center-align">Create Page</h2>
		</div>
		<div class="section max800">
			<div class="row">
				<div class="col s12">
					<hr class="subtle" />
					<?php echo Form::open(['url' => url('bear/pages/create'), 'data-done-route' => "pages/{id}/layout"]); ?>
						<div class="ba-field">
							<div class="ba-form-group" data-field-name="title">
								<label>Title</label>
								<input name="title" type="text" autocomplete="off" placeholder="Enter page title" class="ba-form-control generate-slug" data-target="input[name='slug']" />
							</div>
						</div>
						<div class="ba-field">
							<div class="ba-form-group" data-field-name="slug">
								<label>Slug <small>(shown in address bar)</small></label>
								<input name="slug" type="text" autocomplete="off" placeholder="Enter page slug" class="ba-form-control" />
							</div>
						</div>
						<div class="ba-field">
							<div class="ba-form-group" data-field-name="entity">
								<label>Entity</label>
								<div class="ba-dropdown mr8 mb8 w300">
			                        <input name="entity" type="hidden" >
			                        <button class="dropdown-button w100p" data-activates="page-entity"><span data-display>Select Entity</span><i class="fa fa-caret-down"></i></button>
			                     	<ul id='page-entity' class='dropdown-content'>
			                     		<?php foreach (config('bear.page_entities') as $entity => $title) { ?>
			                     			<li><a href="#" data-value="<?php echo $entity ?>"><?php echo str_singular($title) ?></a></li>
			                     		<?php } ?>
			                        </ul>
			                    </div>
							</div>
						</div>
						<div class="ba-field">
							<div class="ba-form-group w300" data-field-name="private">
								<label>Page availability</label>
								<div class="switch ba-switch-field">
									<label>
										Public
										<input type="checkbox" name="private" value="true" />
										<span class="lever"></span>
										Private
									</label>
								</div>
							</div>
						</div>

						<hr class="spacer" />
						<button type="submit" class="btn blue pull-right">Continue <i class="fa fa-arrow-right"></i></button>
					<?php echo Form::close(); ?>
				</div>
 			</div>
		</div>
	</div>

</script>