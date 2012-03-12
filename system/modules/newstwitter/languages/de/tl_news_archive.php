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
$GLOBALS['TL_LANG']['tl_news_archive']['twitter']		= array('Twitter aktivieren', 'Klicken Sie hier um Twitter-Funktionen für dieses Nachrichtenarchiv zu aktivieren.');
$GLOBALS['TL_LANG']['tl_news_archive']['twitterAuth']	= array('Anmeldung bei Twitter');
$GLOBALS['TL_LANG']['tl_news_archive']['twitterParams']	= array('URL-Parameter', 'Parameter werden der an Twitter gesendeten URL angehängt. Verwenden Sie key=value Paare (key1=value1&key2=value2).');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_legend']	= 'Twitter';


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_ok']			= 'Sie sind angemeldet. Klicken Sie hier um Ihre Anmeldedaten zu ändern.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_error']		= 'Sie sind nicht angemeldet.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_success']		= 'Anmeldung bei Twitter erfolgreich.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_denied']		= 'Anmeldung bei Twitter abgelehnt.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_token']		= 'Fehler bei der Kommunikation mit Twitter. Bitte versuchen Sie es später nochmals.';
$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_insecure']	= 'Sie haben Ihre Webseite nicht als Twitter-Applikation registriert! Dies ist nicht unbedingt nötig aber dringend empfohlen, um bekannte Sicherheitsrisiken zu umgehen. <a href="contao/help.php?table=tl_settings&field=twitter_secret" onclick="Backend.openWindow(this, 600, 500); return false;">Klicken Sie hier für weitere Informationen.</a>';

