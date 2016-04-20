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
     * The original code coverage mode.
     *
     * @var boolean
     */
    private static $covering;

    /**
     * Executes a callback with code coverage temporarily disabled.
     *
     * @param callable $callback The callback.
     */
    public static function ignore(callable $callback)
    {
        self::stop();

        $callback();

        self::resume();
    }

    /**
     * Returns the original code coverage mode.
     *
     * @param boolean $reset Allows the cached mode to be reset.
     *
     * @return boolean Returns `true` if covering, `false` if not.
     */
    public static function isCovering($reset = false)
    {
        if ($reset || (null === self::$covering)) {
            self::$covering = xdebug_code_coverage_started();
        }

        return self::$covering;
    }

    /**
     * Checks if code coverage is currently active.
     *
     * @return boolean Returns `true` if active, `false` if not.
     */
    public static function isCurrentlyCovering()
    {
        return xdebug_code_coverage_started();
    }

    /**
     * Resumes code coverage.
     */
    public static function resume()
    {
        if (self::isCovering()) {
            xdebug_start_code_coverage();
        }
    }

    /**
     * Stops code coverage.
     */
    public static function stop()
    {
        if (self::isCovering()) {
            xdebug_stop_code_coverage();
        }
    }
}
