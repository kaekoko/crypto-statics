<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>Crypto 2D |  Dashboard</title>

	<link href="../css_admin/app.css" rel="stylesheet">
	<link href="../css_admin/custom.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{ route('home') }}">
          			<span class="align-middle cry-logo"><img src="../img/photos/logo.png" class="img-fluid cry-logo" alt=""></span>
        		</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Pages
					</li>

					<li class="sidebar-item home">
						<a class="sidebar-link" href="/home">
              				<i class="align-middle" data-feather="sliders"></i><span class="align-middle">Dashboard</span>
            			</a>
					</li>
					<li class="sidebar-item section">
						<a class="sidebar-link" href="{{ route('section') }}">
							<i class="fas fa-clock"></i><span class="align-middle">Section</span>
            			</a>
					</li>
					<li class="sidebar-item manual">
						<a class="sidebar-link" href="{{ route('manual') }}">
							<i class="fas fa-keyboard"></i><span class="align-middle">Manual</span>
            			</a>
					</li>
					<li class="sidebar-item logs">
						<a class="sidebar-link" href="{{ route('logs') }}">
							<i class="fas fa-terminal"></i><span class="align-middle">Scraping Logs</span>
						</a>
					</li>
					<li class="sidebar-item offdays">
						<a class="sidebar-link" href="{{ route('offdays') }}">
							<i class="fab fa-expeditedssl"></i><span class="align-middle">Off Days</span>
						</a>
					</li>
				</ul> 
			</div>
		</nav>

		<div class="main">
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
					</a>
				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
								<img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark">{{ Auth::user()->name  }}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="{{ route('passwordedit') }}"><i class="align-middle me-1" data-feather="pie-chart"></i> Change Password</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('logout') }}"
								onclick="event.preventDefault();
											document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>							
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3 title-card"></h1>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">HOME</h5>
								</div>
								<div class="card-body">
										@yield('content')
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<input type="text" value="{{ Request::segment(1) }}" id="segment" hidden>
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Crypto Statics</strong></a> &copy;
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>	
	<script src="../js_admin/app.js"></script>
	@yield('script')
	<script>
		var seg = $('#segment').val();
		console.log(seg);
		$('.' + seg).addClass('active');
		$('.title-card').text(seg);
	</script>
</body>

</html>