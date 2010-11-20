<?php
	Router::parseExtensions('json');
	Router::connect('/', array('controller' => 'pages', 'action' => 'home'));
