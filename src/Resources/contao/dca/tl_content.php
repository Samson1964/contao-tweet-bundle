<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2017 Leo Feyer
 *
 * PHP version 5
 * @copyright  Frank Hoppe
 * @author     Frank Hoppe
 * @package    references
 * @license    LGPL
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['tweet'] = '{type_legend},type,headline;{tweet_legend},tweet_url,tweet_code;;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['tweet_url'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tweet_url'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'dcaPicker'=>false, 'tl_class'=>'long'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);
		
$GLOBALS['TL_DCA']['tl_content']['fields']['tweet_code'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tweet_code'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'textarea',
	'eval'                    => array('allowHtml'=>true, 'class'=>'monospace', 'rte'=>'ace|html', 'helpwizard'=>true),
	'explanation'             => 'insertTags',
	'sql'                     => "mediumtext NULL"
);
