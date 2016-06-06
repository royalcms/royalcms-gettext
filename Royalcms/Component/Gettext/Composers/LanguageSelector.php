<?php namespace Royalcms\Component\Gettext\Composers;

use Royalcms\Component\Gettext\Gettext;
use Royalcms\Component\Support\Facades\Config;

/**
 * Simple language selector generator.
 * @author Nicolás Daniel Palumbo 
 */
class LanguageSelector
{

	/**
	 * Language labels
	 * @var Array
	 */
	protected $labels = [];

	/**
	 * royalcms gettext wrapper
	 * @var Gettext
	 */
	protected $gettext;

	/**
	 * Creates a new instance of language selector
	 * @param Array $labels 
	 */		
	public function __construct($labels = [], Gettext $gettext)
	{
		$this->labels = $labels;
		$this->gettext = $gettext;
	}

	/**
	 * Creates a new selector instance
	 * @return void 
	 */
	public static function create($labels = [], Gettext $gettext)
	{
		return new LanguageSelector($labels, $gettext);
	}

	/**
	 * Renders the language selector
	 * @return String 
	 */
	public function render()
	{
		$html = '<ul class="language-selector">';

		foreach (Config::get('gettext::config.supported-locales') as $locale) {

			if(count($this->labels) && array_key_exists($locale, $this->labels)){
				$localeLabel = $this->labels[$locale];
			} else {
				$localeLabel = $locale;
			}
			
			if($locale == $this->gettext->getLocale()){
				$html .= '<li><strong class="active ' . $locale . '">' . $localeLabel . '</strong></li>';
			} else {
				$html .= '<li><a href="/lang/' . $locale . '" class="' . $locale . '">' . $localeLabel . '</a></li>';
			}

		}

		$html .= '</ul>';

		return $html;
	}

	/**
	 * String conversion
	 * @return string 
	 */
	public function __toString()
	{
		return $this->render();
	}

}