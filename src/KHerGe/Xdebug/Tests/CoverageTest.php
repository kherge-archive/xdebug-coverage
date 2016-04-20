<?php

namespace KHerGe\Xdebug\Tests {

    use KHerGe\Xdebug\Coverage;
    use PHPUnit_Framework_TestCase as TestCase;

    /**
     * Verify that the code coverage class functions as intended.
     *
     * @author Kevin Herrera <kevin@herrera.io>
     *
     * @coversDefaultClass \KHerGe\Xdebug\Coverage
     */
    class CoverageTest extends TestCase
    {
        /**
         * The test coverage mode.
         *
         * @var boolean
         */
        public static $covering;

        /**
         * The number of times coverage was started.
         *
         * @var integer
         */
        public static $started;

        /**
         * The number of times coverage was stopped.
         *
         * @var integer
         */
        public static $stopped;

        /**
         * Verify that we can disable coverage for a code block.
         *
         * @covers ::ignore
         * @covers ::isCovering
         */
        public function testIgnore()
        {
            self::$covering = true;

            $called = false;

            Coverage::ignore(
                function () use (&$called) {
                    self::assertEquals(
                        1,
                        self::$stopped,
                        'The code coverage was not stopped.'
                    );

                    $called = true;
                }
            );

            self::assertTrue(
                $called,
                'The callback was not invoked.'
            );

            self::assertEquals(
                1,
                self::$started,
                'The code coverage was not resumed.'
            );
        }

        /**
         * Verify that we can get the original code coverage status.
         *
         * @depends testIgnore
         *
         * @covers ::isCovering
         */
        public function testIsCovering()
        {
            self::$covering = false;

            self::assertTrue(
                Coverage::isCovering(),
                'The original code coverage status was not returned.'
            );
        }

        /**
         * Verify that we can get the current coverage mode.
         *
         * @covers ::isCurrentlyCovering
         */
        public function testIsCurrentCovering()
        {
            self::$covering = true;

            self::assertTrue(
                Coverage::isCurrentlyCovering(),
                'The current coverage status was not returned.'
            );

            self::$covering = false;

            self::assertFalse(
                Coverage::isCurrentlyCovering(),
                'The current coverage status was not returned.'
            );
        }

        /**
         * Verify that we can stop and resume code coverage.
         *
         * @covers ::resume
         * @covers ::stop
         */
        public function testStopAndResumeCoverage()
        {
            self::$covering = true;

            Coverage::isCovering(true);
            Coverage::stop();

            self::assertEquals(
                1,
                self::$stopped,
                'Code coverage was not stopped.'
            );

            Coverage::resume();

            self::assertEquals(
                1,
                self::$started,
                'Code coverage was not resumed.'
            );
        }

        /**
         * Resets the invocation counters.
         */
        protected function setUp()
        {
            self::$covering = null;
            self::$started = 0;
            self::$stopped = 0;
        }
    }

}

namespace KHerGe\Xdebug {

    use KHerGe\Xdebug\Tests\CoverageTest;

    /**
     * A mock function for testing coverage mode.
     *
     * @return boolean Returns `true` if covering, `false` if not.
     */
    function xdebug_code_coverage_started()
    {
        return CoverageTest::$covering;
    }

    /**
     * A mock function for testing coverage mode.
     */
    function xdebug_start_code_coverage()
    {
        CoverageTest::$started++;
    }

    /**
     * A mock function for testing coverage mode.
     */
    function xdebug_stop_code_coverage()
    {
        CoverageTest::$stopped++;
    }

}
