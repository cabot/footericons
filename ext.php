<?php
/**
 *
 * Footer Icons extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2023-2026 - cabot
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace cabot\footericons;

class ext extends \phpbb\extension\base
{
	const FA_BRANDS_SUPPORT_PATH = 'assets/fontawesome/fa_brands_support.css';
	const FA_BRANDS_ICONS_PATH = 'assets/fontawesome/css/brands.min.css';
	private const PHPBB_MIN_VERSION = '3.3.11';
	private const PHP_MIN_VERSION = '7.2.0';

	/**
	 * {@inheritdoc}
	 */
	public function is_enableable(): bool
	{
		$config = $this->container->get('config');
		$phpbb_ok = $this->version_check($config['version']) && $this->version_check(PHPBB_VERSION);

		$php_ok = version_compare(PHP_VERSION, self::PHP_MIN_VERSION, '>=');

		return $phpbb_ok && $php_ok;
	}

	/**
	 * Enable version check
	 *
	 * @param string|int $version The version to check
	 * @return bool
	 */
	protected function version_check($version): bool
	{
		return phpbb_version_compare($version, self::PHPBB_MIN_VERSION, '>=');
	}
}
