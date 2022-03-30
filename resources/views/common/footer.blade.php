<footer class="global-footer footer-1 bg-dark">
	<div class="container">

		<div class="row links">

			<div class="col-xs-4 col-md-4 col-lg-2">
				<ul class="links">
					<li><a href="{{ route('page.tips-tricks') }}">Tips For Tutors</a></li>
					<li><a href="{{ route('page.about-us') }}">About Us</a></li>
					<li><a href="{{ route('page.blog') }}">Blog</a></li>
				</ul>
			</div>

			<div class="col-xs-4 col-md-4 col-lg-2">
				<ul class="links">
					<li><a href="{{ route('page.online-tuition') }}">Online Tuition</a></li>
					<li><a href="{{ route('page.help') }}">Help</a></li>
					<li><a href="{{ route('page.trust') }}">Trust</a></li>
				</ul>
			</div>

			<div class="col-xs-4 col-md-4 col-lg-3">
				<ul class="links">
					<li><a href="{{ route('page.terms-conditions') }}">Terms & Conditions</a></li>
					<li><a href="{{ route('page.privacy-cookie') }}">Privacy and Cookie Policy</a></li>
				</ul>
			</div>

			<!-- Optional: clear the XS cols if their content doesn't match in height -->
  			<div class="clearfix visible-xs-block"></div>

			<div class="col-lg-5 col-md-8 text-right footer-social">
				<ul class="list-inline social-list">
					<li>
						<a href="https://www.facebook.com/ClassHubapp/" class="facebook">
							facebook
						</a>
					</li>
					<li>
						<a href="https://twitter.com/ClassHubapp" class="twitter">
							twitter
						</a>
					</li>
					<li>
						<a href="https://www.instagram.com/classhubapp/" class="instagram">
							instagram
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 text-center">
				<hr />
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 text-center">
				<span class="sub">&copy; Copyright {{ date('Y') }} - Classhub</span>
			</div>
		</div>

	</div>
</footer>
