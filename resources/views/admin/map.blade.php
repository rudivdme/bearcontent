@section('bear-menu')
	<li><a href="/info" data-ba-route id="bear-speak" class="bear-logo waves-effect waves-light tooltip mb0" title="About">
		<img src="/bear/images/bear.png" />
	</a></li>
	<li class="divider mt0"></li>
	<li><a href="{{url('/')}}" class="tooltip waves-effect waves-light" title="Website Home" data-position="right"><i class="icon-globe"></i></a></li>
	<li><a href="/dashboard" data-ba-route class="tooltip waves-effect waves-light" title="Dashboard"><i class="icon-home"></i></a></li>
	<li class="divider"></li>
	<li><a href="/pages" data-ba-route class="tooltip waves-effect waves-light" title="Pages"><i class="icon-docs"></i></a></li>
	<li><a href="/blogs" data-ba-route class="tooltip waves-effect waves-light" title="Blog Posts"><i class="icon-pencil"></i></a></li>
	<li><a href="/images" data-ba-route class="tooltip waves-effect waves-light" title="Images"><i class="icon-picture"></i></a></li>
	<li><a href="/emails" data-ba-route class="tooltip waves-effect waves-light" title="Emailing"><i class="icon-envelope"></i></a></li>
	<li class="divider"></li>
	<li><a href="/menu" data-ba-route class="tooltip waves-effect waves-light" title="Menu Items"><i class="icon-grid"></i></a></li>
	<li><a href="/settings" data-ba-route class="tooltip waves-effect waves-light" title="Settings"><i class="icon-settings"></i></a></li>
	<li class="divider"></li>
	<li><a href="/signout" data-ba-route class="tooltip waves" title="Signout"><i class="icon-logout"></i></a></li>
@stop

@section('bear-pages')

	@include('bear::admin.common.pagination')
	@include('bear::admin.pages.info')
	@include('bear::admin.pages.dashboard')
	@include('bear::admin.pages.pages.index')
	@include('bear::admin.pages.pages.create')
	@include('bear::admin.pages.pages.layout')
	@include('bear::admin.pages.pages.update')
	@include('bear::admin.pages.pages.menu')
	@include('bear::admin.pages.pages.done')
	@include('bear::admin.pages.blogs')
	@include('bear::admin.pages.menu')
	@include('bear::admin.pages.images')
	@include('bear::admin.pages.emails')
	@include('bear::admin.pages.settings')
	@include('bear::admin.pages.signout')

@stop