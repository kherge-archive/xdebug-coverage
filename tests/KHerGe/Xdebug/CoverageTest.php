<?php

namespace KHerGe\Xdebug;

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the coverage helper functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @covers \KHerGe\Xdebug\Coverage
 */
class CoverageTest extends TestCase
{
    /**
     * Verify that the result for a covered callable is returned.
     */
    public function testGetResultForCoveredCallable()
    {
        self::assertEquals(
            123,
            Coverage::with(
                function () {
                    return 123;
                }
            ),
            'The result for the covered callable was not returned.'
        );
    }

    /**
     * Verify that the result for a uncovered callable is returned.
     */
    public function testGetResultForUncoveredCallable()
    {
        self::assertEquals(
            123,
            Coverage::without(
                function () {
                    return 123;
                }
            ),
            'The result for the uncovered callable was not returned.'
        );
    }

    /**
     * Verify that the current coverage state is returned.
     */
    public function testCoverageStateIsReturned()
    {
        self::assertSame(
            extension_loaded('xdebug') && xdebug_code_coverage_started(),
            Coverage::isEnabled(),
            'The code coverage state is not properly reported.'
        );
    }
}
