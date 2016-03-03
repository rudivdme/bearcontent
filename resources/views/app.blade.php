@inject('bear', 'Rudivdme\BearContent\BearContent')

@if($bear->loadApp())

	@include('bear::admin.app')

@endif

@if($bear->loadLogin())

	@include('bear::auth.public')

@endif