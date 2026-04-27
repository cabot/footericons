<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons\services;

class footericons_service
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string */
	protected $footericons_table;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface    $db                  Database connection
	 * @param string                               $footericons_table   Table name
	 *
	 * @access public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, string $footericons_table)
	{
		$this->db = $db;
		$this->footericons_table = $footericons_table;
	}

	/**
	 * Reorder icons
	 *
	 * @param int    $id        Icon ID
	 * @param string $direction 'move_up' or 'move_down'
	 * @return bool True if moved, false otherwise
	 */
	public function move(int $id, string $direction): bool
	{
		// Get current order
		$sql = 'SELECT fi_order FROM ' . $this->footericons_table . ' WHERE fi_id = ' . (int)$id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row) {
			return false;
		}

		$current_order = (int)$row['fi_order'];
		$switch_order = $direction === 'move_up' ? $current_order - 1 : $current_order + 1;

		// Check limits
		$sql = 'SELECT MIN(fi_order) AS min_order, MAX(fi_order) AS max_order FROM ' . $this->footericons_table;
		$result = $this->db->sql_query($sql);
		$limits = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($switch_order < (int)$limits['min_order'] || $switch_order > (int)$limits['max_order']) {
			return false;
		}

		$this->db->sql_transaction('begin');

		// Update the other icon
		$this->db->sql_query(
			'UPDATE ' . $this->footericons_table . '
			SET fi_order = ' . $current_order . '
			WHERE fi_order = ' . $switch_order . '
			AND fi_id <> ' . (int)$id
		);

		$moved = (bool)$this->db->sql_affectedrows();

		if ($moved) {
			// Update the current icon
			$this->db->sql_query(
				'UPDATE ' . $this->footericons_table . '
				SET fi_order = ' . $switch_order . '
				WHERE fi_id = ' . (int)$id
			);
		}

		$this->db->sql_transaction('commit');

		return $moved;
	}

	/**
	 * Delete icon
	 *
	 * @param int $id
	 * @return bool True if deleted, false otherwise
	 */
	public function delete(int $id): bool
	{
		$this->db->sql_transaction('begin');

		$sql = 'SELECT fi_order FROM ' . $this->footericons_table . ' WHERE fi_id = ' . (int) $id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			$this->db->sql_transaction('rollback');
			return false;
		}

		$deleted_order = (int) $row['fi_order'];

		$this->db->sql_query('DELETE FROM ' . $this->footericons_table . ' WHERE fi_id = ' . (int) $id);
		$this->db->sql_query('UPDATE ' . $this->footericons_table . ' SET fi_order = fi_order - 1 WHERE fi_order > ' . $deleted_order);

		$this->db->sql_transaction('commit');
		return true;
	}
}
