<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/29
 * Time: 0:24
 */

namespace Chip\Tests\Traits;

use Chip\Traits\TypeHelper;
use PhpParser\Node;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class TypeHelperTest extends TestCase
{
    /**
     * @var TypeHelper $typeHelperTrait
     */
    protected $typeHelperTrait = null;

    /**
     * @before
     * @throws \Exception
     */
    public function beforeTest()
    {
        $this->typeHelperTrait = $this->getMockForTrait(TypeHelper::class);
    }

    /**
     * @throws \Exception
     */
    public function testIsArray()
    {
        $node = new Node\Expr\Array_([], [
            'kind' => Node\Expr\Array_::KIND_SHORT
        ]);
        $this->assertTrue($this->typeHelperTrait->isArray($node));
    }

    /**
     * @throws \Exception
     */
    public function testIsString()
    {
        $node = new Node\Scalar\String_('tests', [
            'kind' => Node\Scalar\String_::KIND_SINGLE_QUOTED
        ]);
        $this->assertTrue($this->typeHelperTrait->isString($node));

        $node = new Node\Scalar\EncapsedStringPart('tests');
        $this->assertTrue($this->typeHelperTrait->isString($node));

        $node = new Node\Scalar\Encapsed([$node, new Node\Expr\Variable('variable')]);
        $this->assertFalse($this->typeHelperTrait->isString($node));
    }

    /**
     * @throws \Exception
     */
    public function testIsClosure()
    {
        $node = new Node\Expr\Closure();
        $this->assertTrue($this->typeHelperTrait->isClosure($node));
    }

    /**
     * @throws \Exception
     */
    public function testIsVariable()
    {
        $node = new Node\Expr\Variable('variable');
        $this->assertTrue($this->typeHelperTrait->isVariable($node));
    }

    /**
     * @throws \Exception
     */
    public function testIsConstant()
    {
        $c1 = new Node\Expr\ConstFetch(new Node\Name('C1'));
        $c2 = new Node\Expr\ConstFetch(new Node\Name('C2'));
        $c3 = new Node\Expr\ConstFetch(new Node\Name('C3'));
        $c4 = new Node\Expr\ConstFetch(new Node\Name('C4'));

        $this->assertTrue($this->typeHelperTrait->isConstant($c1));

        $b1 = new Node\Expr\BinaryOp\BitwiseOr($c1, $c2);
        $this->assertTrue($this->typeHelperTrait->isConstant($b1));

        $b2 = new Node\Expr\BinaryOp\BitwiseAnd($b1, $c3);
        $this->assertTrue($this->typeHelperTrait->isConstant($b2));

        $b3 = new Node\Expr\BinaryOp\BitwiseOr($c3, $c4);
        $b4 = new Node\Expr\BinaryOp\BitwiseAnd($b1, $b3);
        $this->assertTrue($this->typeHelperTrait->isConstant($b4));

        $b5 = new Node\Expr\BinaryOp\BitwiseOr($c4, new Node\Expr\Variable('variable'));
        $this->assertFalse($this->typeHelperTrait->isConstant($b5));
    }

    /**
     * @throws \Exception
     * @expectedException \Chip\Exception\NodeTypeException
     */
    public function testGetFunctionName()
    {
        $node = new Node\Expr\FuncCall(new Node\Name('phpinfo'));
        $this->assertEquals('phpinfo', $this->typeHelperTrait->getFunctionName($node));

        $node = new Node\Expr\FuncCall(new Node\Name('PHPInfo'));
        $this->assertEquals('phpinfo', $this->typeHelperTrait->getFunctionName($node));

        $node = new Node\Expr\FuncCall(new Node\Scalar\String_('phpinfo'));
        $this->assertEquals('phpinfo', $this->typeHelperTrait->getFunctionName($node));

        $node = new Node\Expr\FuncCall(new Node\Scalar\String_('phpINFO'));
        $this->assertEquals('phpinfo', $this->typeHelperTrait->getFunctionName($node));

        $node = new Node\Expr\FuncCall(new Node\Expr\Variable('variable'));
        $this->typeHelperTrait->getFunctionName($node);
    }

    /**
     * @throws \Exception
     * @expectedException \Chip\Exception\NodeTypeException
     */
    public function testGetMethodName()
    {
        $node = new Node\Expr\MethodCall(new Node\Expr\Variable('variable'), new Node\Identifier('test'));
        $this->assertEquals('test', $this->typeHelperTrait->getMethodName($node));

        $node = new Node\Expr\MethodCall(new Node\Expr\Variable('variable'), new Node\Identifier('TEST'));
        $this->assertEquals('test', $this->typeHelperTrait->getMethodName($node));

        $node = new Node\Expr\MethodCall(new Node\Expr\Variable('variable'), new Node\Expr\Variable('test'));
        $this->typeHelperTrait->getMethodName($node);

        $node = new Node\Expr\StaticCall(new Node\Name('FOO'), new Node\Identifier('BAR'));
        $this->assertEquals('bar', $this->typeHelperTrait->getMethodName($node));

        $node = new Node\Expr\StaticCall(new Node\Name('FOO'), new Node\Expr\Variable('variable'));
        $this->typeHelperTrait->getMethodName($node);
    }

    /**
     * @throws \Exception
     */
    public function testIsBitwise()
    {
        $var1 = new Node\Expr\Variable('variable');
        $var2 = new Node\Scalar\LNumber(1024);
        $var3 = new Node\Scalar\DNumber(0.5);

        $node = new Node\Expr\BinaryOp\BitwiseOr($var1, $var2);
        $this->assertTrue($this->typeHelperTrait->isBitwise($node));

        $node = new Node\Expr\BinaryOp\BitwiseAnd($var2, $var3);
        $this->assertTrue($this->typeHelperTrait->isBitwise($node));

        $node = new Node\Expr\BinaryOp\BitwiseXor($var2, $var3);
        $this->assertTrue($this->typeHelperTrait->isBitwise($node));

        $node = new Node\Expr\AssignOp\BitwiseAnd($var1, $var2);
        $this->assertFalse($this->typeHelperTrait->isBitwise($node));
    }

    /**
     * @throws \Exception
     */
    public function testIsQualify()
    {
        $node = new Node\Name('FOO');
        $this->assertTrue($this->typeHelperTrait->isQualify($node));

        $node = new Node\Identifier('FOO');
        $this->assertTrue($this->typeHelperTrait->isQualify($node));

        $node = new Node\Expr\Variable('varaible');
        $this->assertFalse($this->typeHelperTrait->isQualify($node));

        $node = new Node\Expr\FuncCall(new Node\Name('FOO'));
        $this->assertFalse($this->typeHelperTrait->isQualify($node));
    }

    /**
     * @throws \Exception
     */
    public function testIsName()
    {
        $node = new Node\Name('FOO');
        $this->assertTrue($this->typeHelperTrait->isName($node));
    }

    /**
     * @throws \Exception
     */
    public function testIsIdentifier()
    {
        $node = new Node\Identifier('FOO');
        $this->assertTrue($this->typeHelperTrait->isIdentifier($node));
    }

    /**
     * @throws \Exception
     */
    public function testIsNumber()
    {
        $node = new Node\Scalar\LNumber(1024);
        $this->assertTrue($this->typeHelperTrait->isNumber($node));

        $node = new Node\Scalar\DNumber(0.5);
        $this->assertTrue($this->typeHelperTrait->isNumber($node));

        $node = new Node\Expr\Variable('1000');
        $this->assertFalse($this->typeHelperTrait->isNumber($node));
    }
}
