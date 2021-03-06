{{ content() }}

<div class="content-wrapper">
	<div class="pure-g">
		<div class="pure-u-1">
			<h1>Welcome to MyDAV</h1>

			<p>
				MyDAV new program for special personnal's study.
				{{ link_to('list', 'Mes fichiers') }}
			</p>

			<p>{{ link_to('register', 'Créer un compte', 'class': 'pure-button') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<h2>Manage Invoices Online</h2>

			<p>
				Create, track and export your invoices online. Automate recurring invoices and design your own invoice
				using our invoice template and brand it with your business logo.
			</p>
		</div>
		<div class="col-md-4">
			<h2>Dashboards And Reports</h2>

			<p>
				Gain critical insights into how your business is doing. See what sells most, who are your top paying
				customers and the average time your customers take to pay.
			</p>
		</div>
		<div class="col-md-4">
			<h2>Invite, Share And Collaborate</h2>

			<p>
				Invite users and share your workload as invoice supports multiple users with different permissions. It
				helps your business to be more productive and efficient.
			</p>
		</div>
	</div>
</div>
