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
 * @version    $Id: tl_news.php 147 2010-09-14 21:41:16Z aschempp $
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_news']['twitter']			= array('Twitter senden', 'Klicken Sie hier wenn diese Nachricht getwittert werden soll.');
$GLOBALS['TL_LANG']['tl_news']['twitterMessage']	= array('Twitter Nachricht', 'Geben Sie einen Twitter-Status ein. Wenn Sie dieses Feld leer lassen, werden die ersten 120 Zeichen des Teaser- oder Nachrichtentextes verwendet.');
$GLOBALS['TL_LANG']['tl_news']['twitterStatus']		= array('Twitter Status', 'Wählen Sie ob die Nachricht sofort oder bei veröffentlichung (stündlich) getwittert werden soll. Der Status wird automatisch aktualisiert.');
$GLOBALS['TL_LANG']['tl_news']['twitterUrl']		= array('News-Link senden', 'Klicken Sie hier wenn ein Link zu diesem News-Beitrag an Twitter gesendet werden soll. Die URL wird mittels http://is.gd/ gekürzt.');


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_news']['twitterStatus_ref']['now']	= 'Jetzt senden';
$GLOBALS['TL_LANG']['tl_news']['twitterStatus_ref']['cron']	= 'Planen';
$GLOBALS['TL_LANG']['tl_news']['twitterStatus_ref']['sent']	= 'Bereits gesendet';


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_news']['twitter_legend']			= 'Twitter';

