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

class v110_m2_update_data extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\cabot\footericons\migrations\v110_m1_update_schema'];
	}

	public function update_data()
	{
		return [
			['custom', [[$this, 'remove_empty_icons']]],
			['custom', [[$this, 'normalize_icons_order']]],
		];
	}

	/**
	 * Remove entry with empty URL (empty / NULL / only spaces).
	 */
	public function remove_empty_icons()
	{
		$sql = 'DELETE FROM ' . $this->table_prefix . 'footericons
			WHERE fi_url IS NULL OR TRIM(fi_url) = \'\'';
		$this->db->sql_query($sql);
	}

	/**
	 * Normalize icons order
	 */
	public function normalize_icons_order()
	{
		$sql = 'SELECT fi_id FROM ' . $this->table_prefix . 'footericons ORDER BY fi_order, fi_id';
		$result = $this->db->sql_query($sql);
		$order = 1;
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->db->sql_query('UPDATE ' . $this->table_prefix . 'footericons SET fi_order = ' . (int) $order . ' WHERE fi_id = ' . (int) $row['fi_id']);
			$order++;
		}
		$this->db->sql_freeresult($result);
	}
}
