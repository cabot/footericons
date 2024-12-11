<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\acp;

class footericons_info
{
	function module()
	{
		return [
			'filename'	=> '\cabot\footericons\acp\footericons_module',
			'title'		=> 'ACP_FI_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title' 	=> 'ACP_FI_CONFIG',
					'auth' 		=> 'cabot/footericons && acl_a_board',
					'cat'		=> ['ACP_FI_CONFIG'],
				],
			],
		];
	}
}
