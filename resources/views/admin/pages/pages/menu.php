<script
	data-route-id="pages/menu"
	data-store="beardata.pages.menu.{{id}}"
	data-load-store="<?php echo url('bear/pages/{{id}}/menu') ?>"
	data-route-title="<?php echo ba_title('Menu Placement')  ?>"
	type="text/x-handlebars-template">

{{#with record}}
	<div class="ba-controls">
		{{> baControls}}
		<button data-ba-route="pages" class="btn-floating btn-medium default pull-right ml8 tooltip" title="Go back"><i class="fa fa-arrow-left"></i></button>
	</div>

	<div data-store="beardata.pages.show.{{id}}" data-load-store="<?php echo url('bear/pages/{{id}}') ?>">
		<div class="section">
			<h2 class="page-heading animated center-align">Menu Placement</h2>
		</div>
		<div class="section max800">
			<div class="row">
				<div class="col s12">
					{{#if ../menu}}
						<?php echo Form::open(['url' => url('bear/pages/{{id}}/menu/update'), 'data-done-route' => "pages/{{id}}/done"]); ?>
						<?php echo Form::hidden('menu'); ?>
						<div class="dd" data-target="input[name='menu']" data-group="1">
							<h6>Your Menu</h6>
						    <ol class="dd-list">
						    	{{#each ../menu}}
							        <li class="dd-item {{#compare ../id '==' page_id}}active{{/compare}}" data-id="{{id}}" data-page-id="{{page_id}}" data-title="{{title}}" data-url="{{url}}" data-active="{{active}}">
							            <div class="dd-handle">
							            	<div class="dd-title"><span data-field-{{id}}-title>{{title}}</span> 
							            		{{#compare active '0'}}<small>(not active)</small>{{/compare}}
							            	</div>
							            </div>
							            {{#if children}}
								            <ol class="dd-list">
								            	{{#each children}}
									                <li class="dd-item {{#compare ../../id '==' page_id}}active{{/compare}}" data-id="{{id}}" data-page-id="{{page_id}}" data-title="{{title}}" data-url="{{url}}" data-active="{{active}}">
									                    <div class="dd-handle">
									                    	<div class="dd-title"><span data-field-{{id}}-title>{{title}}</span>
									                    		{{#compare active '0'}}<small>(not active)</small>{{/compare}}
									                    	</div>
									                    </div>
									                </li>
									            {{/each}}
								            </ol>
								        {{/if}}
							        </li>
							    {{/each}}
						    </ol>
						</div>

						{{#compare linked "false"}}
							<div class="dd" data-group="1">
								<h6>Your new page <small>(drag to your menu)</small></h6>
					            <ol class="dd-list" id="pendingList" data-ix="1">
					                <li class="dd-item active" data-id="new-{{id}}" data-page-id="{{id}}" data-title="{{title}}" data-url="{{url}}" data-active="{{#compare status 'published'}}1{{else}}0{{/compare}}">
								        <div class="dd-handle">
								        	{{title}}
								        	{{#compare status 'draft'}}<small>(not active)</small>{{/compare}}
								        </div>
								    </li>
					            </ol>
					        </div>
					    {{/compare}}

						<div class="clearfix"></div>
						<hr class="spacer" />
						<button data-ba-route="pages/{{id}}/layout" class="btn default"><i class="fa fa-arrow-left mr8"></i> Go Back</button>
						<button type="submit" class="btn blue pull-right" data-color="teal">Save Changes</button>
						<?php echo Form::close(); ?>
					{{else}}
						<div class="sk-circle bear-loader"></div>
					{{/if}}
				</div>
 			</div>
		</div>
	</div>
{{/with}}
</script>