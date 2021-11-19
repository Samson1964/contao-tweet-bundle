<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2017 Leo Feyer
 *
 * PHP version 5
 * @copyright  Frank Hoppe
 * @author     Frank Hoppe
 * @package    Twitch
 * @license    LGPL
 * @filesource
 */

namespace Schachbulle\ContaoTweetBundle\ContentElements;

/**
 * Class Reference
 *
 */
class Tweet extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_tweet';
	protected $html = false;

	public function generate()
	{

		if($this->tweet_url)
		{
			// Tweet-URL wurde eingetragen
			$json = file_get_contents('https://publish.twitter.com/oembed?url='.$this->tweet_url);
			$tweet = json_decode($json);
			$this->html = $tweet->html;
		}
		elseif($this->tweet_code)
		{
			// Tweet-Code wurde eingetragen
			$this->html = $this->tweet_code;
		}

		$request = \System::getContainer()->get('request_stack')->getCurrentRequest();

		if($request && \System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			if($this->tweet_url)
				$return = '<p><a href="'.$this->tweet_url.'" target="_blank">'.$this->tweet_url.'</a></p>';
			else
				$return = '<p>'.htmlentities($this->tweet_code).'</p>';

			if ($this->headline)
			{
				$return = '<' . $this->hl . '>' . $this->headline . '</' . $this->hl . '>' . $return;
			}

			//return $return;
		}

		return parent::generate();
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{

		$this->Template->tweetcontainer = $this->html;

	}

}
