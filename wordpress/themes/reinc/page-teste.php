<?php
/*
Template Name: Página Teste
*/

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> ng-app="myapp">
<head>
	<title>Angular Experiments (1)</title>
	<style type="text/css">
	/*
Theme Name: Angular Experiments (1)
Version: 1.0.0
Theme URI: https://github.com/devinsays/angular-experiments/ae-1
Author: Devin Price
Author URI: https://wptheming.com
Description: Really basic example showing how to display recent posts.
*/

body {
	background: #fafafa;
	font-family: sans-serif;
	font-size:1.5m;
}
.col-width {
	max-width: 680px;
	padding: 0 1.5em;
	margin: 3em auto;
}
header {
	display:block;
	margin-bottom: 3em;
	text-align: center;
}
article {
	display:block;
	background: #fff;
	padding: 1.5em;
	margin-bottom: 1.5em;
}
	</style>
	<script type="application/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
	<script type="application/javascript">
	var myapp = angular.module( 'myapp', [] );

// Set the configuration
myapp.run( ['$rootScope', function($rootScope) {

	// Variables defined by wp_localize_script
	$rootScope.api = "<?php echo get_bloginfo( 'wpurl' ) . '/wp-json/reinc-api/v1/associados'; ?>";

}]);

// Add a controller
myapp.controller( 'mycontroller', ['$scope', '$http', function( $scope, $http ) {

	// Load posts from the WordPress API
	$http({
		method: 'GET',
		url: $scope.api,
		params: {
			'types[]' : ['incubadoras'],
			'filter[posts_per_page]' : 10,
			/**
			 * design-economia-criativa, base-tecnologica, economia-solidaria
			 */
			'filter[terms]' : ['design-economia-criativa'],
			'filter[order]' : 'desc'
		},
	}).
	success( function( data, status, headers, config ) {
		console.log( $scope.api );
		console.log( config.params );
		console.log( data.pagination );
		console.log( data );
		$scope.posts = data.posts;
	}).
	error(function(data, status, headers, config) {});

}]);
	</script>
</head>
<body>
	<div class="row">
	<div class="col-md-12 col-width">

		<header>
			<h1>Angular Experiments</h1>
			<p>Display a list of recent posts.</p>
		</header>

		<div ng-controller="mycontroller">
			<article ng-repeat="post in posts">
				<h3>{{ post.title }}</h3>
				<p><pre>{{ post }}</pre></p>
			</article>
		</div>

	</div>
	</div>
	<?php wp_footer();?>
</body>
</html>