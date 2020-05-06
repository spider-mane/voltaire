<?php

namespace WebTheory\Voltaire\Helpers;

class ThemeSupport
{
    /**
     *
     */
    public static function set(array $supports)
    {
        foreach ($supports as $feature => $args) {

            if (is_int($feature)) {
                add_theme_support($args);
            } else {
                add_theme_support($feature, $args);
            }
        }
    }
}
