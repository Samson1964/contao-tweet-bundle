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

	public function generate()
	{
		if($this->twitchOptions) $this->twitchOptions = unserialize($this->twitchOptions);
		$this->twitchOptions = array();

		$this->playerSize = unserialize($this->playerSize);

		// Kanalname übergeben?
		if(!is_numeric($this->twitch)) $this->twitchChannel = true; // Ja!

		$request = \System::getContainer()->get('request_stack')->getCurrentRequest();

		if($request && \System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
		{
			if($this->twitchChannel)
				$return = '<p><a href="https://www.twitch.tv/' . $this->twitch . '" target="_blank" rel="noreferrer noopener">www.twitch.tv/' . $this->twitch . '</a></p>';
			else
				$return = '<p><a href="https://www.twitch.tv/videos/' . $this->twitch . '" target="_blank" rel="noreferrer noopener">www.twitch.tv/videos/' . $this->twitch . '</a></p>';

			if ($this->headline)
			{
				$return = '<' . $this->hl . '>' . $this->headline . '</' . $this->hl . '>' . $return;
			}

			return $return;
		}

		return parent::generate();
	}

	/**
	 * Generate the content element
	 */
	protected function compile()
	{

		// Zufallszahl für Container-ID ermitteln
		$container_id = mt_rand();
		// Reponsive-Ratio übergeben, wenn gewünscht
		if($this->playerAspect)
		{
			$responsive = 'responsive ratio-'.str_replace(':', '', $this->playerAspect);
		}
		else
		{
			$responsive = '';
		}

		$content = '';
		//$content .= '<script src= "https://player.twitch.tv/js/embed/v1.js"></script>'."\n";
		$content .= '<div class="twitch '.$responsive.'" id="twitch_'.$container_id.'"></div>'."\n";
		$content .= '<script type="text/javascript">'."\n";
		$content .= '  var options = {'."\n";
		// Breite setzen
		if($this->playerSize[0])
		{
			$content .= '    width: '.$this->playerSize[0].','."\n";
		}
		else
		{
			$content .= '    width: 400,'."\n";
		}
		// Höhe setzen
		if($this->playerSize[1])
		{
			$content .= '    height: '.$this->playerSize[1].','."\n";
		}
		else
		{
			$content .= '    height: 300,'."\n";
		}
		$content .= '    autoplay: '.(in_array('twitch_autoplay', $this->twitchOptions) ? 'true' : 'false').','."\n";

		if($this->twitchChannel) $content .= '    channel: "'.$this->twitch.'",'."\n";
		else $content .= '    video: "'.$this->twitch.'",'."\n";

		// Startzeit setzen
		if($this->playerStart > 0)
		{
			$startzeit = self::Zeitrechner($this->playerStart);
			$content .= '    time: "'.$startzeit.'",'."\n";
		}
		$content .= '    parent: ["'.$_SERVER['SERVER_NAME'].'"]'."\n";
		$content .= '  };'."\n";
		$content .= '  var player = new Twitch.Player("twitch_'.$container_id.'", options);'."\n";
		$content .= '  player.setVolume(0.5);'."\n";
		$content .= '</script>'."\n";

		$this->Template->tweetcontainer = $content;

	}

}
