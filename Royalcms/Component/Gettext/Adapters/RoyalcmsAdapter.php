<?php namespace Royalcms\Component\Gettext\Adapters;

use Royalcms\Component\Support\Facades\Royalcms;

class RoyalcmsAdapter implements AdapterInterface
{

    /**
     * Returns the adapter current locale
     */
    public function setLocale($locale)
    {
        Royalcms::setLocale(substr($locale, 0, 2));
    }

    /**
     * Sets the locale on current addapter
     */
    public function getLocale()
    {
        return Royalcms::getLocale();
    }

    /**
     * Return the application path
     */
    public function getApplicationPath()
    {
        return app_path();
    }
}
