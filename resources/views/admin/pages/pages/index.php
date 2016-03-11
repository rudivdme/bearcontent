<script
	data-route-id="pages"
	data-store="beardata.pages.list"
	data-load-store="<?php echo url('bear/pages') ?>"
	data-route-title="<?php echo ba_title('Pages')  ?>"
	type="text/x-handlebars-template">

	<div class="ba-controls">
		{{> baControls}}
		<button data-ba-route="pages/create" class="btn-floating btn-medium teal pull-right ml8 ba-tooltip waves-effect" title="Create Page" data-position="bottom"><i class="fa fa-pencil"></i></button>
	</div>

	<div data-store="beardata.pages.list">
		<div class="section">
			<h2 class="page-heading animated center-align">Pages</h2>
		</div>
		<div class="section">
			{{#if paginator}}
				{{#if filters}}
					{{#with filters}}
						<input name="filters[search]" type="text" autocomplete="off" placeholder="Search" class="ba-form-control filter mr8 mb8 w200 pull-left" data-auto-search value="{{search}}" />
				        <input name="filters[sort]" type="hidden" class="filter" value="{{sort}}" />
				        <input name="filters[order]" type="hidden" class="filter" value="{{order}}" />
				        <div class="ba-dropdown mr8 mb8 pull-left">
	                        <input name="filters[status]" type="hidden" class="filter" data-auto-submit value="{{status}}" >
	                        <button class="dropdown-button" data-activates="page-status-filter"><span data-display>Filter by Status</span><i class="fa fa-caret-down"></i></button>
	                     	<ul id='page-status-filter' class='dropdown-content'>
	                     		<li><a href="#" data-value="draft">draft</a></li>
	                     		<li><a href="#" data-value="published">published</a></li>
	                            <li class="divider"></li>
	                            <li><a href="#" data-clear><small>Clear Filter</small></a></li>
	                        </ul>
	                    </div>
	                    <div class="ba-dropdown mr8 mb8 pull-left">
	                        <input name="filters[entity]" type="hidden" class="filter" data-auto-submit value="{{entity}}" >
	                        <button class="dropdown-button" data-activates="page-entity-filter"><span data-display>Filter by Type</span><i class="fa fa-caret-down"></i></button>
	                     	<ul id='page-entity-filter' class='dropdown-content'>
	                     		<?php foreach (config('bear.page_entities') as $entity => $title) { ?>
	                     			<li><a href="#" data-value="<?php echo $entity ?>"><?php echo $title ?></a></li>
	                     		<?php } ?>
	                     		<li><a href="#" data-value="all">All Pages</a></li>
	                        </ul>
	                    </div>
	                    <div class="clearfix"></div>
	                    <hr class="spacer" />
			        {{/with}}
			    {{/if}}
				{{#if records}}
					<table class="ba-listing">
						<tr>
							<th data-sort="title">title</th>
							<th data-sort="slug">slug</th>
							<th data-sort="status" class="center-align">status</th>
							<th data-sort="created" class="center-align">created</th>
							<th></th>
						</tr>
						{{#each records}}
							<tr>
								<td><a href="<?php echo url('/') ?>/{{slug}}">{{title}}</a></td>
								<td><a href="<?php echo url('/') ?>/{{slug}}">{{slug}}</a></td>
								<td class="center-align">
									{{#compare status 'draft'}}
										<span class="ba-lbl">{{status}}</span>
									{{else}}
										<span class="ba-lbl bgm-lightblue c-white">{{status}}</span>
									{{/compare}}
								</td>
								<td class="center-align">{{created}}</td>
								<td class="right-align">
									<a href="<?php echo url('/') ?>/{{slug}}" class="btn default btn-icon-sm ba-tooltip" title="View/Update Content" data-position="top"><i class="fa fa-pencil"></i></a>
									<a href="/pages/{{id}}/update" data-ba-route class="btn default btn-icon-sm ba-tooltip" title="Configure page" data-position="top"><i class="fa fa-wrench"></i></a>
									{{#compare status 'draft'}}
										<a href="#" data-post-url="<?php echo url('bear/pages/{{id}}/delete') ?>" data-no-go="{{slug}}" class="btn default btn-icon-sm ba-tooltip " data-encourage-refresh title="Delete page" data-position="top"><i class="fa fa-trash"></i></a>
										<a href="#" data-post-url="<?php echo url('bear/pages/{{id}}/publish') ?>" class="btn pink btn-icon-sm ba-tooltip " data-encourage-refresh title="Publish online!" data-position="top"><i class="fa fa-thumbs-up"></i></a>
									{{/compare}}
									{{#compare status 'published'}}
										<a href="#" data-post-url="<?php echo url('bear/pages/{{id}}/unpublish') ?>" class="btn default btn-icon-sm ba-tooltip" data-encourage-refresh title="Unpublish this page" data-position="top"><i class="fa fa-thumbs-down"></i></a>
									{{/compare}}
								</td>
							</tr>
						{{/each}}
					</table>
				{{else}}
					<hr class="subtle" />
					<div class="p10 center-align">There is nothing to show here.</div>
				{{/if}}
				{{> paginator}}
			{{else}}
				<div class="sk-circle bear-loader"></div>
			{{/if}}
		</div>
	</div>

</script>