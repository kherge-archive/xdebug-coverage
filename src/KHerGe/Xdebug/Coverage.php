<?php

namespace KHerGe\Xdebug;

/**
 * Provides helper methods for handling code coverage.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Coverage
{
    /**
     * Checks if code coverage is currently enabled.
     *
     * @return boolean Returns `true` if enabled or `false` if not.
     */
    public static function isEnabled() : bool
    {
        return self::hasXdebug() && xdebug_code_coverage_started();
    }

    /**
     * Executes a callable with code coverage enabled.
     *
     * @param callable $callable The callable.
     * @param integer  $options  The new xdebug coverage options.
     *
     * @return mixed The result of the callable.
     */
    public static function with(callable $callable, int $options = 0)
    {
        $enabled = self::hasXdebug();
        $inherited = self::isEnabled();

        if ($enabled && !$inherited) {
            xdebug_start_code_coverage($options);
        }

        $result = $callable();

        if ($enabled && !$inherited) {
            xdebug_stop_code_coverage(false);
        }

        return $result;
    }

    /**
     * Executes a callable with code coverage *disabled*.
     *
     * @param callable $callable The callable.
     * @param integer  $options  The current xdebug coverage options.
     *
     * @return mixed The result of the callable.
     */
    public static function without(callable $callable, int $options = 0)
    {
        $enabled = self::hasXdebug();
        $inherited = self::isEnabled();

        if ($enabled && $inherited) {
            xdebug_stop_code_coverage(false);
        }

        $result = $callable();

        if ($enabled && $inherited) {
            xdebug_start_code_coverage($options);
        }

        return $result;
    }

    /**
     * Checks if xdebug is available.
     *
     * @return boolean Returns `true` if it is or `false` if not.
     */
    private static function hasXdebug() : bool
    {
        return extension_loaded('xdebug');
    }
}
