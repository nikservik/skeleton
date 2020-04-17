<?php

namespace Nikservik\Subscriptions;

class Translatable
{
    protected $translations = [];
    protected $currentLocale;

    public function __construct($translations)
    {
        $this->currentLocale = config('app.locale');

        if (is_array($translations))
            $this->translations = $translations;
        else
            $this->translations[$this->currentLocale] = $translations;
    }

    public function __toString()
    {
        return $this->getTranslation($this->currentLocale);
    }

    public function __get($locale)
    {
        return $this->getTranslation($locale);
    }

    public function __set($locale, $value)
    {
        return $this->setTranslation($locale, $value);
    }

    public function getTranslation($locale)
    {
        if (! count($this->translations))
            return '';

        if (array_key_exists($locale, $this->translations))
            return $this->translations[$locale];
        else 
            return $this->translations[array_keys($this->translations)[0]];
    }

    public function setTranslation($locale, $value)
    {
        if (! $locale)
            return;

        if ($value)
            $this->translations[$locale] = $value;
        else 
            unset($this->translations[$locale]);
    }

    public function toArray()
    {
        return $this->translations;
    }
}