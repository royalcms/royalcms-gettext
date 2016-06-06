<?php namespace Royalcms\Component\Gettext\Session;

use Royalcms\Component\Support\Facades\Session;

class SessionHandler{

	/**
	 * Session identifier to store active locale 
	 */
	const SESSION_IDENTIFIER = "gettext-locale";

	/**
	 * Returns the locale identifier from 
	 * the main session adapter
	 */
	public function get($default)
    {

		$locale = $default;
		
		if(Session::has(self::SESSION_IDENTIFIER)){
			$locale = Session::get(self::SESSION_IDENTIFIER);
		}

		return $locale;

	}

	/**
	 * Sets the given locale on session
	 */	
	public function set($locale)
    {
		Session::set(self::SESSION_IDENTIFIER, $locale);
	}
}
