
<div id="bear-container">

	@include('bear::auth.map')

	<a href="/signin" data-ba-toggle-route class="bear-login-handle btn-floating waves-effect waves-light blue"><i class="fa fa-unlock-alt animated pulse infinite"></i></a>

	<section class="ba-overlay">
		<div class="ba-top-loader">
			<div class="progress bear-loader">
				<div class="indeterminate"></div>
			</div>
		</div>
		<div id="bearContent" class="ba-wrapper"></div>
	</section>

	@yield('bear-pages')

</div>