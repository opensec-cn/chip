<?php
/**
 * Created by PhpStorm.
 * User: shiyu
 * Date: 2019-05-05
 * Time: 16:35
 */

namespace Chip\Tests;

use Chip\Alarm;
use Chip\AlarmLevel;
use Chip\Visitor\Assert_;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPUnit\Framework\TestCase;

class AlarmTest extends TestCase
{
    /**
     * @var Alarm
     */
    protected $alarm;

    public function setUp()
    {
        parent::setUp();

//        $node = TestHelper::createNodeFromCode('assert($data);');
//        $this->alarm = new Alarm(AlarmLevel::DANGER(), Assert_::class, 'message', $node);
    }

    public function testPlainFormat()
    {
        $code = "<?php \n" . 'assert($data);';
        $node = TestHelper::createNodeFromCode($code);
        $alarm = new Alarm(AlarmLevel::DANGER(), Assert_::class, 'message', $node);

        $ctx = $alarm->formatOutput($code);
        $this->assertEquals($ctx['level'], 'danger');
        $this->assertCount(2, $ctx['lines']);
        $this->assertTrue($ctx['lines'][1][2]);
        $this->assertFalse($ctx['lines'][0][2]);
        $this->assertEquals($ctx['lines'][1][0], 2);
    }

    public function testFunctionFormat()
    {
        $code = "<?php\n\n\n\nfunction test() {\n\tassert(\$data);\n}\n";
        $node = TestHelper::createNodeFromCode('assert($data);');
        $node->setAttribute('startLine', 6);
        $node->setAttribute('endLine', 6);
        $function = TestHelper::createNodeFromCode($code);
        $alarm = new Alarm(AlarmLevel::DANGER(), Assert_::class, 'message', $node, $function);

        $ctx = $alarm->formatOutput($code);
        $this->assertEquals($ctx['level'], 'danger');
        $this->assertCount(3, $ctx['lines']);
        $this->assertTrue($ctx['lines'][1][2]);
        $this->assertFalse($ctx['lines'][0][2]);
        $this->assertEquals($ctx['lines'][0][0], 5);
    }

    public function testFileFormat()
    {
        $code = "<?php\n\n\n\nfunction test() {\n\tassert(\$data);\n}\n";
        $alarm = new Alarm(AlarmLevel::DANGER(), Assert_::class, 'message');

        $ctx = $alarm->formatOutput($code);
        $this->assertEquals($ctx['level'], 'danger');
        $this->assertCount(8, $ctx['lines']);
        $this->assertTrue($ctx['lines'][6][2]);
        $this->assertTrue($ctx['lines'][3][2]);
        $this->assertEquals($ctx['lines'][0][0], 1);
    }
}
