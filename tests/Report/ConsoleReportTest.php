<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-05-05
 * Time: 02:40
 */

namespace Chip\Tests\Report;

use Chip\Alarm;
use Chip\Report\ConsoleReport;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleReportTest extends TestCase
{
    public function testFeed()
    {
        $output = \Mockery::spy(OutputInterface::class);
        $alarm = \Mockery::mock(Alarm::class);
        $alarm->shouldReceive('formatOutput')->withAnyArgs()->andReturn([
            'level'   => 'danger',
            'message' => 'test_message',
            'lines'   => [
                ['1', 'line 1', false],
                ['2', 'line 2', true],
                ['3', 'line 3', true],
                ['4', 'line 4', false],
                ['5', 'line 5', false],
            ],
        ]);

        $report = new ConsoleReport($output);
        $report->feed('filename', 'code', $alarm);

        $output->shouldHaveReceived('writeln')->withAnyArgs()->times(6);
    }

    public function tearDown()
    {
        parent::tearDown();

        // We should add assert count to phpunit
        // referer: https://github.com/mockery/mockery/issues/376
        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }
        \Mockery::close();
    }
}
