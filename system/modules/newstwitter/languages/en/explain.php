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
 * @copyright  Andreas Schempp 2010
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id: explain.php 147 2010-09-14 21:41:16Z aschempp $
 */


/**
 * Help Wizard
 */
$GLOBALS['TL_LANG']['XPL']['twitter_auth'] = '<p class="tl_help_table">To securely link your website with your twitter account, it is HIGHLY recommended to register a custom "Browser" application! You can do this at <a href="http://dev.twitter.com/apps/new" onclick="window.open(this.href); return false">http://dev.twitter.com/apps/new</a>.<br /><br />
The callback url does not matter, just make sure you provide something or Twitter will fall back to a "Client" application type.<br /><br />After successfully registering your application, please add the "Consumer key" and "Consumer secret" to your system configuration settings.</p>';

