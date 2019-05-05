<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-05-05
 * Time: 18:21
 */

namespace Chip\Tests;

use Chip\ChipFactory;
use Chip\ChipManager;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class FactoryTest extends TestCase
{
    public function testCreateFromDir()
    {
        vfsStream::create([
            'visitors'  => [
                'Test1.php' => 'test',
                'Test2.php' => 'test',
                'Test3.php' => 'test',
                'other.txt' => 'other text',
                'Test4.php' => 'test',
                'Test5.php' => 'test',
            ],
            'Other.php' => 'other',
        ], vfsStream::setup('root'));

        $manager = \Mockery::mock('overload:' . ChipManager::class);
        $manager->shouldReceive('addVisitor')->with(\Mockery::pattern('/^Chip\\\\Visitor\\\\\w+$/'))->times(5);

        $factory = new ChipFactory();
        $factory->createFromDir(vfsStream::url('root/visitors'));
    }

    public function tearDown()
    {
        parent::tearDown();

        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }
        \Mockery::close();
    }
}
