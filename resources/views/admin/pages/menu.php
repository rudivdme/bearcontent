<script
	data-route-id="menu"
	data-store="beardata.menu"
	data-load-store="<?php echo url('bear/menu') ?>"
	data-route-title="<?php echo ba_title('Edit Menu') ?>"
	type="text/x-handlebars-template">

	<div class="ba-controls">
		{{> baControls}}
	</div>

	<div>
		<div class="section">
			<h2 class="page-heading center-align">Edit Menu</h2>
		</div>
		<div class="section">
			<div class="row">
				<div class="col s12" id="menuContainer">
					{{#if menu}}
						<?php echo Form::open(['url' => url('bear/menu/save'), 'data-done-route' => "menu", 'data-encourage-refresh']); ?>
						<?php echo Form::hidden('menu'); ?>
						<div id="menuList" class="dd" data-target="input[name='menu']" data-group="1">
							<h6>Your Menu</h6>
						    <ol class="dd-list">
						    	{{#each menu}}
							        {{> menuItem}}
							    {{/each}}
						    </ol>
						</div>

						<div class="dd" data-group="1">
							<h6>Pending Items <small>(drag to your menu)</small></h6>
				            <ol class="dd-list" id="pendingList" data-ix="1">
				            	{{#each pages}}
					                <li class="dd-item" data-list="#menuList" data-id="new-{{id}}" data-page-id="{{id}}" data-title="{{title}}" data-url="{{url}}" data-active="true">
								        <button type="button" class="btn default pull-right dd-control" show-modal data-target="FormMenu{{id}}"><i class="fa fa-pencil"></i></button>
							            <div class="dd-handle">
							            	<div class="dd-title"><span data-field-{{id}}-title>{{title}}</span> 
							            		{{#compare active '0'}}<small>(not active)</small>{{/compare}}
							            	</div>
							            </div>
							            {{> menuItemForm}}
								    </li>
								{{/each}}
				            </ol>
				            <hr class="subtle" />
				            <button type="button" class="dd-new" show-modal data-target="FormMenuNew"><i class="fa fa-plus"></i> Create New</button>
							<div id="FormMenuNew" class="modal max450" data-store="beardata.menu"  data-target="#pendingList">
								<div class="modal-content">
									<div class="popover-form menu-item-form">
									    <div class="ba-field">
											<div class="ba-form-group" data-field-name="title">
												<label>Title</label>
												<input name="title" type="text" autocomplete="off" placeholder="Enter title" class="ba-form-control" />
											</div>
										</div>
										<div class="ba-field">
											<div class="ba-form-group" data-field-name="url">
												<label>Url</label>
												<input name="url" type="text" autocomplete="off" placeholder="Enter url" class="ba-form-control" />
											</div>
										</div>

									</div>
									<button class="btn btn-large pink pull-right waves-effect" data-create-menu-item>Okay</button>
									<div class="clearfix"></div>
								</div>
							</div>
				        </div>

						<div class="clearfix"></div>
						<hr class="spacer" />
						<button type="submit" class="btn blue pull-right" data-color="teal">Save Changes</button>
						<?php echo Form::close(); ?>
					{{else}}
						<div class="sk-circle bear-loader"></div>
					{{/if}}
				</div>
 			</div>
		</div>
		<hr class="subtle" />
	</div>

</script>

<script id="menu-item-form-template" type="text/x-handlebars-template">
	<div id="FormMenu{{id}}" class="modal max450">
		<div class="modal-content">
			<div class="popover-form menu-item-form">
			    <div class="ba-field">
					<div class="ba-form-group" data-field-name="title">
						<label>Title</label>
						<input value="{{title}}"" name="title" type="text" autocomplete="off" placeholder="Enter title" class="ba-form-control" />
					</div>
				</div>
				{{#if slug}}
					<div class="ba-field">
						<div class="ba-form-group" data-field-name="page_id">
							<label>Linked page</label>
							<input value="{{slug}}" type="text" autocomplete="off" placeholder="Linked page" class="ba-form-control" readonly />
						</div>
					</div>
				{{/if}}
				{{#compare slug ""}}
					<div class="ba-field">
						<div class="ba-form-group" data-field-name="url">
							<label>Url</label>
							<input value="{{url}}" name="url" type="text" autocomplete="off" placeholder="Enter url" class="ba-form-control" />
						</div>
					</div>
				{{/compare}}

			</div>
			<button class="btn btn-large pink pull-right waves-effect modal-close" data-save-menu-item data-target=".dd-item[data-id='{{id}}']">Okay</button>
			<div class="clearfix"></div>
		</div>
	</div>
</script>

<script id="menu-item-template" type="text/x-handlebars-template">
	<li class="dd-item" data-list="#menuList" data-id="{{id}}" data-page-id="{{page_id}}" data-title="{{title}}" data-url="{{url}}" data-active="{{active}}">
    	<button type="button" class="btn default pull-right dd-control" show-modal data-target="FormMenu{{id}}"><i class="fa fa-pencil"></i></button>
        <div class="dd-handle">
        	<div class="dd-title"><span data-field-{{id}}-title>{{title}}</span> 
        		{{#compare active '0'}}<small>(not active)</small>{{/compare}}
        	</div>
        </div>
        {{> menuItemForm}}
        {{#if children}}
            <ol class="dd-list">
            	{{#each children}}
	                {{> menuItem }}
	            {{/each}}
            </ol>
        {{/if}}
    </li>
</script>