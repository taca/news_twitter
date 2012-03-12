<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009-2010
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id: tl_news_archive.php 147 2010-09-14 21:41:16Z aschempp $
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_news_archive']['twitter']		= array('Enable twitter', 'Check here to enable Twitter for this news archive.');
$GLOBALS['TL_LANG']['tl_news_archive']['twitterAuth']	= array('Twitter Authentication');
$GLOBALS['TL_LANG']['tl_news_archive']['twitterParams']	= array('URL parameters', 'Parameters are appended to the URL sent to twitter. Use key=value pairs (key1=value1&key2=value2).');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_legend']	= 'Twitter';


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_ok']			= 'You are authenticated. Click here to use different credentials.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_error']		= 'Your are currently not authenticated.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_success']		= 'Twitter authentication successfull.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_denied']		= 'Twitter authentication denied.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_token']		= 'Error while communicating with Twitter. Please try again later.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_insecure']		= 'You have not registered your website as a Twitter application! It is not required to do so, but highly recommended due to flaws in the Twitter authentication system. <a href="contao/help.php?table=tl_settings&field=twitter_secret" onclick="Backend.openWindow(this, 600, 500); return false;">Click here for more information.</a>';

