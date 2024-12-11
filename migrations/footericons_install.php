<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\migrations;

class footericons_install extends \phpbb\db\migration\migration
{

	public function update_schema()
	{
		return [
			'add_tables'	=> [
			// Add new table structure
				$this->table_prefix . 'footericons'	=> [
					'COLUMNS'		=> [
						'fi_id'					=> ['UINT', null, 'auto_increment'],
						'fi_url'				=> ['VCHAR', ''],
						'fi_name'				=> ['VCHAR', ''],
						'fi_desc'				=> ['VCHAR', ''],
						'fi_open'				=> ['VCHAR', 0],
						'fi_code'				=> ['VCHAR', ''],
						'fi_color'				=> ['VCHAR', '#105289'],
						'fi_color_hover'		=> ['VCHAR', ''],
						'fi_bg'					=> ['VCHAR', ''],
						'fi_bgcolor'			=> ['VCHAR', ''],
						'fi_bgcolor_hover'		=> ['VCHAR', ''],
						'fi_shadow_color'		=> ['VCHAR', ''],
					],
					'PRIMARY_KEY'		=> 'fi_id',
				],
			],
		];
	}

	public function update_data()
	{
		// Add config
		return [
			['config.add', ['footericons_enable', 0]],
			['config.add', ['footericons_position', 0]],
			['config.add', ['footericons_align', 'center']],
			['config.add', ['footericons_size', '2em']],

			// Add ACP modules
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'ACP_FI_TITLE']],
			['module.add', ['acp', 'ACP_FI_TITLE', [
				'module_basename'		=> '\cabot\footericons\acp\footericons_module',
				'module_langname'		=> 'ACP_FI_CONF',
				'module_mode'			=> 'overview',
				'module_auth'			=> 'ext_cabot/footericons && acl_a_board',
			]]],
		];
	}

	/**
	 * Drop the Footer Icons table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'footericons',
			],
		];
	}
}
