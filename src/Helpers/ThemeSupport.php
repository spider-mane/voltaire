<?php

namespace WebTheory\Voltaire\Helpers;

class ThemeSupport
{
    /**
     *
     */
    public static function postThumbnails(string ...$postTypes)
    {
        add_theme_support('post-thumbnails', ...$postTypes);
    }

    /**
     *
     */
    public static function postFormats(array $formats)
    {
        add_theme_support('post-formats', $formats);
    }

    /**
     *
     */
    public static function html5(array $tags)
    {
        add_theme_support('html5', $tags);
    }

    /**
     *
     */
    public static function customLogo(string $defaults)
    {
        add_theme_support('custom-logo', $defaults);
    }

    /**
     *
     */
    public static function customHeaderUploads()
    {
        add_theme_support('custom-header-uploads');
    }

    /**
     *
     */
    public static function customHeader(array $defaults)
    {
        add_theme_support('custom-header', $defaults);
    }

    /**
     *
     */
    public static function customBackground(array $defaults)
    {
        add_theme_support('custom-background', $defaults);
    }

    /**
     *
     */
    public static function titleTag()
    {
        add_theme_support('title-tag');
    }
}
