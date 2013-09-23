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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_news_archive']['palettes']['__selector__'][] = 'twitter';
$GLOBALS['TL_DCA']['tl_news_archive']['palettes']['default'] .= ';{twitter_legend},twitter';
$GLOBALS['TL_DCA']['tl_news_archive']['subpalettes']['twitter'] = 'twitterAuth,twitterParams,twitter_key,twitter_secret';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_news_archive']['fields']['twitter'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_news_archive']['twitter'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'			=> array('submitOnChange'=>true),
);

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['twitterAuth'] = array
(
	'label'					=> &$GLOBALS['TL_LANG']['tl_news_archive']['twitterAuth'],
	'input_field_callback'	=> array('tl_news_archive_newstwitter', 'authenticate'),
	'eval'					=> array('tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['twitterParams'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_news_archive']['twitterParams'],
	'exclude'		=> true,
	'inputType'		=> 'text',
	'eval'			=> array('maxlength'=>255, 'rgxp'=>'url', 'tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['twitter_key'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_news_archive']['twitter_key'],
	'inputType'			=> 'text',
	'eval'				=> array('tl_class'=>'w50', 'helpwizard'=>true),
	'explanation'		=> 'twitter_auth'
);

$GLOBALS['TL_DCA']['tl_news_archive']['fields']['twitter_secret'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_news_archive']['twitter_secret'],
	'inputType'			=> 'text',
	'eval'				=> array('tl_class'=>'w50', 'helpwizard'=>true),
	'explanation'		=> 'twitter_auth'
);

class tl_news_archive_newstwitter extends Backend
{

	/**
	 * Authenticate on Twitter usin OAuth
	 */
	public function authenticate($dc, $label)
	{
        // Try to use saved value in NewsArchive
        $twitter_key = $dc->activeRecord->{'twitter_key'};
        $twitter_secret = $dc->activeRecord->{'twitter_secret'};

        // If any value in NewsArchive, try global value as default.
        if ($twitter_key == '' || $twitter_secret == '') {
            $twitter_key = $GLOBALS['TL_CONFIG']['twitter_key'];
            $twitter_secret = $GLOBALS['TL_CONFIG']['twitter_secret'];
        }

		if ($twitter_key == '' || $twitter_secret == '')
		{
			$insecure = '<p class="tl_gerror">'.$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_insecure'].'</p>';
		}

		$strButton = $insecure.'<div class="' . $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['tl_class'] . '"><h3><label>'.$GLOBALS['TL_LANG']['tl_news_archive']['twitterAuth'][0].'</label></h3><a href="' . $this->addToUrl('twitterauth=1') . '">' . $this->generateImage('system/modules/newstwitter/html/connect.png', 'Sign in with Twitter') . '</a>';


		// Start Twitter authentication
		if ($this->Input->get('twitterauth'))
		{
			if (!$_SESSION['oauth_token'] || !$_SESSION['oauth_token_secret'])
			{
				$connection = new TwitterOAuth($twitter_key, $twitter_secret);

				// Get temporary credentials.
				$request_token = $connection->getRequestToken($this->Environment->base . $this->Environment->request);

				if ($connection->http_code != 200)
				{
					$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_token'];
					$this->redirect($this->Environment->script.'?do=news&table=tl_news_archive&act=edit&id='.$dc->id);
				}

				// Save temporary credentials to session.
				$_SESSION['oauth_token'] = $request_token['oauth_token'];
				$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

				$this->redirect($connection->getAuthorizeURL($request_token['oauth_token']));
			}
			elseif ($this->Input->get('denied') != '')
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_denied'];
				$this->redirect($this->Environment->script.'?do=news&table=tl_news_archive&act=edit&id='.$dc->id);
			}
			elseif ($this->Input->get('oauth_token') != '' && $this->Input->get('oauth_token') == $_SESSION['oauth_token'])
			{
				// Create TwitteroAuth object with app key/secret and token key/secret from default phase
				$connection = new TwitterOAuth($twitter_key, $twitter_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

				// Request access tokens from twitter
				$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

				if ($connection->http_code != 200)
				{
					$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_token'];
					$this->redirect($this->Environment->script.'?do=news&table=tl_news_archive&act=edit&id='.$dc->id);
				}

				// Save the access tokens. Normally these would be saved in a database for future use.
				$this->Database->query("UPDATE tl_news_archive SET " . $dc->field . "='" . serialize($access_token) . "' WHERE id={$dc->id}");

				// Remove no longer needed request tokens
				unset($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

				$_SESSION['TL_CONFIRM'][] = $GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_success'];
				$this->redirect($this->Environment->script.'?do=news&table=tl_news_archive&act=edit&id='.$dc->id);
			}
			else
			{
				// Remove session, try again
				unset($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
				$this->reload();
			}
		}

		$access_token = deserialize($dc->activeRecord->{$dc->field});

		// Create a TwitterOauth object with consumer/user tokens.
		$connection = new TwitterOAuth($twitter_key, $twitter_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);

		// If method is set change API call made. Test is called by default.
		$connection->get('account/verify_credentials');


		if ($connection->http_code == 200)
		{
			return $strButton . '<p class="tl_help tl_tip">'.$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_ok'].'</p></div>';
		}
		else
		{
			return $strButton . '<p class="tl_error">'.$GLOBALS['TL_LANG']['tl_news_archive']['twitter_auth_error'].'</p></div>';
		}
	}
}

