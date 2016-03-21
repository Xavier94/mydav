<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	{{ get_title() }}

	{{ stylesheet_link('vendor/jquery-ui/jquery-ui.min.css') }}

	{{ stylesheet_link('css/font-awesome.min.css') }}
	{{ stylesheet_link('css/pure-min.css') }}

	<!--[if lte IE 8]>
	{{ stylesheet_link('css/grids-responsive-old-ie-min.css') }}
	<![endif]-->
	<!--[if gt IE 8]><!-->
	{{ stylesheet_link('css/grids-responsive-min.css') }}
	<!--<![endif]-->

	<!--[if lte IE 8]>
	{{ stylesheet_link('css/style.min.css') }}
	<![endif]-->
	<!--[if gt IE 8]><!-->
	{{ stylesheet_link('css/style.min.css') }}
	<!--<![endif]-->

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Your invoices">
	<meta name="author" content="Phalcon Team">
</head>
<body>
	{{ content() }}

	<div class="alert-wrapper">
		{% for message in flash.getMessages() %}
			<div class="alert alert-{{ message['type'] }}">
				{{ message['text'] }}
				<a href="#" class="close" title="close" aria-label="close">&times;</a>
			</div>
		{% endfor %}
	</div>

	{{ javascript_include('vendor/jquery/jquery-1.12.2.min.js') }}
	{{ javascript_include('vendor/jquery-ui/jquery-ui.min.js') }}
	{{ javascript_include('vendor/jquery-fileupload/jquery.iframe-transport.js') }}
	{{ javascript_include('vendor/jquery-fileupload/jquery.fileupload.js') }}
	{{ javascript_include('js/script.min.js') }}
</body>
</html>
