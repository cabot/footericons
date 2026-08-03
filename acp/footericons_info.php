<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\acp;

class footericons_info
{
	public function module()
	{
		return [
			'filename'	=> '\cabot\footericons\acp\footericons_module',
			'title'		=> 'ACP_FI_TITLE',
			'modes'		=> [
				'overview'	=> [
					'title' 	=> 'ACP_FI_CONF',
					'auth' 		=> 'ext_cabot/footericons && acl_a_board',
					'cat'		=> ['ACP_FI_CONF'],
				],
			],
		];
	}
}
