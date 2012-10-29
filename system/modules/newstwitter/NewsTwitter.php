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
 * @version    $Id: NewsTwitter.php 148 2010-09-14 21:53:12Z aschempp $
 */


class NewsTwitter extends Frontend
{
	/**
	 * Twitter when onsubmit_callback is triggered
	 */
	public function sendNow($dc)
	{
		$this->import('Database');
		
		$objNews = $this->Database->prepare("SELECT tl_news.*, tl_news_archive.twitterAuth, tl_news_archive.twitterParams, tl_news_archive.twitter_key, tl_news_archive.twitter_secret, tl_news_archive.jumpTo AS parentJumpTo FROM tl_news LEFT OUTER JOIN tl_news_archive ON tl_news.pid=tl_news_archive.id WHERE tl_news_archive.twitter='1' AND tl_news.twitter='1' AND twitterStatus='now' AND published='1' AND tl_news.id=?")->limit(1)->execute($dc->id);
		
		if (!$objNews->numRows)
			return;
			
		$strUrl = '';
		if ($objNews->twitterUrl)
		{
			$strUrl = $this->generateNewsUrl($objNews);
		}

        $msg = sprintf("%d on %s", $objNews->id, $this->Environment->host);
		
		if ($this->twitter($objNews->twitter_key, $objNews->twitter_secret, $objNews->twitterAuth, (strlen($objNews->twitterMessage) ? $objNews->twitterMessage : (strlen($objNews->teaser) ? $objNews->teaser : strip_tags($objNews->text))), $strUrl, $objNews->twitterParams, $msg))
		{
			$this->Database->prepare("UPDATE tl_news SET twitterStatus='sent' WHERE id=?")->execute($objNews->id);
		}
	}
	
	
	/**
	 * Run cron job and find news to twitter
	 */
	public function cron()
	{
		$this->import('Database');
		
		$objNews = $this->Database->prepare("SELECT tl_news.*, tl_news_archive.twitterAuth, tl_news_archive.twitterParams, tl_news_archive.twitter_key, tl_news_archive.twitter_secret, tl_news_archive.jumpTo AS parentJumpTo FROM tl_news LEFT OUTER JOIN tl_news_archive ON tl_news.pid=tl_news_archive.id WHERE tl_news_archive.twitter='1' AND tl_news.twitter='1' AND twitterStatus='cron' AND published='1'")->limit(1)->execute($dc->id);

		if (!$objNews->numRows)
			return;

		while( $objNews->next() )
		{
            if (!isset($redirectPage)) {
                $redirectPage = $this->getPageDetails($objNews->parentJumpTo);
                $host = $this->Environment->host;
                if (strcasecmp($host, $redirectPage->domain) != 0) {
                    break;
                }
            }

			// Check if news is withing start & stop date
			if (($objNews->start > 0 && $objNews->start > time()) || ($objNews->stop > 0 && $objNews->stop < time()))
				continue;
				
			$strUrl = '';
			if ($objNews->twitterUrl)
			{
				$strUrl = $this->generateNewsUrl($objNews);
			}

            $msg = sprintf("%d on %s", $objNews->id, $host);

			if ($this->twitter($objNews->twitter_key, $objNews->twitter_secret, $objNews->twitterAuth, (strlen($objNews->twitterMessage) ? $objNews->twitterMessage : (strlen($objNews->teaser) ? $objNews->teaser : strip_tags($objNews->text))), $strUrl, $objNews->twitterParams, $msg))
			{
				$this->Database->prepare("UPDATE tl_news SET twitterStatus='sent' WHERE id=?")->execute($objNews->id);
			}
		}
	}
	
	
	/**
	 * Send a message to twitter
	 */
	private function twitter($twitter_key, $twitter_secret, $varAuth, $strStatus, $strUrl='', $strUrlParams='', $msg = '')
	{
		$access_token = deserialize($varAuth, true);
		$error = '';

		// Create a TwitterOauth object with consumer/user tokens.
		$connection = new TwitterOAuth($twitter_key, $twitter_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$connection->get('account/verify_credentials');

		if ($connection->http_code == 200)
		{
			$this->import('String');
			
			// Decode entities, replace insert tags
			$strStatus = $this->String->decodeEntities($strStatus);
			$strStatus = $this->restoreBasicEntities($strStatus);
			$strStatus = $this->replaceInsertTags($strStatus);
			
			// Shorten message
			if (strlen($strStatus) > 120)
			{
				$strStatus = $this->String->substr($strStatus, 110) . ' ...';
			}
			
			if (strlen($strUrl))
			{
				// Make sure url has protocol and domain
				if (substr($strUrl, 0, 4) != 'http')
				{
					$strUrl = $this->Environment->base . $strUrl;
				}
				
				if (strlen($strUrlParams))
				{
				    $strUrl .= (strpos($strUrl, '?') === false ? '?' : '&') . $strUrlParams;
				}
			}
			
			$connection->post('https://api.twitter.com/1.1/statuses/update.json?status=' . urlencode($strStatus . ' ' . $strUrl));
			
			if ($connection->http_code == 200)
			{
                $this->log('Twitter posted ' . $msg, 'NewsTwitter twitter()', TL_GENERAL);
				return true;
			}
        }

		$error = $connection->http_code;
		if (!empty($error)) {
			$error = ": " . $error;
		}
		$this->log('Error posting to Twitter' . $error, 'NewsTwitter twitter()', TL_ERROR);
		return false;
	}
	
	
	/**
	 * Generate an URL and return it as string
	 */
	private function generateNewsUrl(Database_Result $objArticle, $blnAddArchive=false)
	{
		$strUrl = '';
		
		switch ($objArticle->source)
		{
			// Link to external page
			case 'external':
				$this->import('String');

				if (substr($objArticle->url, 0, 7) == 'mailto:')
				{
					$strUrl = $this->String->encodeEmail($objArticle->url);
				}
				else
				{
					$strUrl = ampersand($objArticle->url);
				}
				break;

			// Link to an internal page
			case 'internal':
				$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
									 	  ->limit(1)
										  ->execute($objArticle->jumpTo);

				if ($objPage->numRows)
				{
					$strUrl = ampersand($this->generateFrontendUrl($objPage->row()));
				}
				break;

			// Link to an article
			case 'article':
				$objPage = $this->Database->prepare("SELECT a.id AS aId, a.alias AS aAlias, a.title, p.id, p.alias FROM tl_article a, tl_page p WHERE a.pid=p.id AND a.id=?")
										  ->limit(1)
										  ->execute($objArticle->articleId);

				if ($objPage->numRows)
				{
					$strUrl = ampersand($this->generateFrontendUrl($objPage->row(), '/articles/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objPage->aAlias)) ? $objPage->aAlias : $objPage->aId)));
				}
				break;
		}

		// Link to the default page
		if ($strUrl == '')
		{
			$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
								 	  ->limit(1)
									  ->execute($objArticle->parentJumpTo);

			if ($objPage->numRows)
			{
				$strUrl = ampersand($this->generateFrontendUrl($objPage->row(), '/items/' . ((!$GLOBALS['TL_CONFIG']['disableAlias'] && strlen($objArticle->alias)) ? $objArticle->alias : $objArticle->id)));
			}
			else
			{
				$strUrl = ampersand($this->Environment->request, true);
			}
		}
		
		return $strUrl;
	}
	
	
	/**
	 * Show twitter options if enabled in archive
	 */
	public function injectField()
	{
		if ($this->Input->get('act') == 'edit')
		{
			$objArchive = $this->Database->prepare("SELECT tl_news_archive.twitter FROM tl_news LEFT OUTER JOIN tl_news_archive ON tl_news.pid=tl_news_archive.id WHERE tl_news.id=?")->execute($this->Input->get('id'));
			
			if ($objArchive->numRows && $objArchive->twitter)
			{
				$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('addEnclosure;', 'addEnclosure;{twitter_legend},twitter;', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);
				$GLOBALS['TL_DCA']['tl_news']['palettes']['internal'] = str_replace('addEnclosure;', 'addEnclosure;{twitter_legend},twitter;', $GLOBALS['TL_DCA']['tl_news']['palettes']['internal']);
				$GLOBALS['TL_DCA']['tl_news']['palettes']['external'] = str_replace('addEnclosure;', 'addEnclosure;{twitter_legend},twitter;', $GLOBALS['TL_DCA']['tl_news']['palettes']['external']);
			}
		}
	}
}

