<div id="bear-container" data-save-url="{{ url('bear/save') }}">

	@include('bear::admin.map')

	<div class="bear-page-tool first">
		<a data-editor-start class="btn btn-floating btn-large blue tooltip bear-tools" title="Edit" data-tooltip-theme="tooltipster-punk-dark"><i class="fa fa-pencil"></i></a>
		<a data-editor-cancel class="btn btn-floating btn-large red tooltip bear-editing" title="Cancel" data-position="top" data-tooltip-theme="tooltipster-punk-dark"><i class="fa fa-close"></i></a>
		<a data-editor-save class="btn btn-floating btn-large green tooltip bear-editing" title="Save" data-position="top" data-tooltip-theme="tooltipster-punk-dark"><i class="fa fa-check"></i></a>
	</div>

	@yield('bear-tools')

	<aside class="ba-sidebar">
		<ul class="ba-sidebar-nav">
			@yield('bear-menu')
		</ul>
	</aside>

	<section class="ba-overlay">
		<div class="ba-top-loader">
			<div class="progress bear-loader">
				<div class="indeterminate"></div>
			</div>
		</div>
		<div class="ba-wrapper">
			<div class="container">
				<div id="bearContent"></div>
			</div>
		</div>
	</section>

	<div class="fixed-action-btn horizontal click-to-toggle bear-page-tool bottom">
		<a class="btn btn-floating btn-large green spin"><i class="fa fa-bars"></i></a>
		<ul>
			<li><a href="/pages/create" data-ba-route class="btn-floating teal tooltip" title="Create New Page" data-position="top" data-tooltip-theme="tooltipster-punk-dark"><i class="fa fa-pencil"></i></a></li>
		</ul>
	</div>

	@yield('bear-pages')

</div>