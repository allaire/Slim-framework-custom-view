#What is it?

Just a simple Slim framework custom view (http://www.slimframework.com/documentation/develop#views) that is similar to how layout works in Sinatra (http://sinatra-book.gittr.com/#templates). I based this work on a rough draft in a Stack Overflow question and customized it to my needs, it's far from perfect, but it gets the job done.

#Usage

**index.php**
	
	require 'Slim/Slim.php';
	require 'custom_view.php';

	$view = new custom_view();

	$app = new Slim(array(
	    'mode' => 'development',
	    'view' => $view
	));

	$view::set_layout('base.php');

	$app->get('/', function() use ($app, $view)
	{
	    $view::set_data(array("title" => "Home"));

	    $app->render('home.php');
	});

	$app->run();
	
	
**templates/base.php**

	<!DOCTYPE html>
	<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>Foo - <?php echo $title; ?></title>
	</head>
	<body>
		<div id="container">
			<?php echo $content; ?>
		</div>
	</body>
	</html>


    