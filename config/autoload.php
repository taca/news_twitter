<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package News_twitter
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'NewsTwitter'  => 'system/modules/news_twitter/NewsTwitter.php',
	'OAuth'        => 'system/modules/news_twitter/OAuth.php',
	'TwitterOAuth' => 'system/modules/news_twitter/TwitterOAuth.php',
));
