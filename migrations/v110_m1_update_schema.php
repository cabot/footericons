<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\migrations;

class v110_m1_update_schema extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\cabot\footericons\migrations\footericons_install'];
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'footericons' => [
					'fi_order' => ['UINT', 0],
				],
			],
			'add_index'  => [
				$this->table_prefix . 'footericons' => [
					'fi_order' => ['fi_order'],
				],
			],
			'change_columns' => [
				$this->table_prefix . 'footericons' => [
					'fi_open' => ['BOOL', 0],
					'fi_bg'   => ['TINT:1', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'change_columns' => [
				$this->table_prefix . 'footericons' => [
					'fi_open' => ['VCHAR', 0],
					'fi_bg'   => ['VCHAR', ''],
				],
			],
			'drop_keys' => [
				$this->table_prefix . 'footericons' => ['fi_order'],
			],
			'drop_columns' => [
				$this->table_prefix . 'footericons' => [
					'fi_order',
				],
			],
		];
	}
}
