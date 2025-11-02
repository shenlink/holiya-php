<?php

declare(strict_types=1);

namespace Tests\Unit\Lexer;

use PHPUnit\Framework\TestCase;
use Shenlink\Holiya\Lexer\Lexer;
use Shenlink\Holiya\Token\TokenType;

/**
 * 词法分析器测试类
 * 
 * 包含对词法分析器各种功能的测试用例
 */
class LexerTest extends TestCase
{
    /**
     * 测试词法分析器生成Token的功能
     * 
     * 测试各种词法单元的识别，包括：
     * - 变量声明(let)
     * - 函数定义(function)
     * - 控制流(if/else)
     * - 各种操作符(算术、比较、逻辑)
     * - 数据类型(整数、浮点数、字符串、数组)
     *
     * @return void
     */
    public function testNextToken(): void
    {
        $input = '
let five = 5;
let ten = 10;

let add = function(x, y) {
  x + y;
};

let result = add(five, ten);
!-/*5;
5 < 10 > 5;

if (5 < 10) {
	return true;
} else {
	return false;
}

10 == 10;
10 != 9;
10 >= 5;
5 <= 10;
"foobar";
"foo bar";
[1, 2];
{"foo": "bar"};
10.5;
10.0;
0.5;
10 == 10 && 5 != 3 || 7 <= 8;
';

        $tests = [
            [TokenType::LET, "let"],
            [TokenType::IDENTIFIER, "five"],
            [TokenType::ASSIGN, "="],
            [TokenType::INT, "5"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LET, "let"],
            [TokenType::IDENTIFIER, "ten"],
            [TokenType::ASSIGN, "="],
            [TokenType::INT, "10"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LET, "let"],
            [TokenType::IDENTIFIER, "add"],
            [TokenType::ASSIGN, "="],
            [TokenType::FUNCTION, "function"],
            [TokenType::LPAREN, "("],
            [TokenType::IDENTIFIER, "x"],
            [TokenType::COMMA, ","],
            [TokenType::IDENTIFIER, "y"],
            [TokenType::RPAREN, ")"],
            [TokenType::LBRACE, "{"],
            [TokenType::IDENTIFIER, "x"],
            [TokenType::PLUS, "+"],
            [TokenType::IDENTIFIER, "y"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::RBRACE, "}"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LET, "let"],
            [TokenType::IDENTIFIER, "result"],
            [TokenType::ASSIGN, "="],
            [TokenType::IDENTIFIER, "add"],
            [TokenType::LPAREN, "("],
            [TokenType::IDENTIFIER, "five"],
            [TokenType::COMMA, ","],
            [TokenType::IDENTIFIER, "ten"],
            [TokenType::RPAREN, ")"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::BAND, "!"],
            [TokenType::MINUS, "-"],
            [TokenType::DIVIDE, "/"],
            [TokenType::MULTIPLY, "*"],
            [TokenType::INT, "5"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::INT, "5"],
            [TokenType::LT, "<"],
            [TokenType::INT, "10"],
            [TokenType::GT, ">"],
            [TokenType::INT, "5"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::IF, "if"],
            [TokenType::LPAREN, "("],
            [TokenType::INT, "5"],
            [TokenType::LT, "<"],
            [TokenType::INT, "10"],
            [TokenType::RPAREN, ")"],
            [TokenType::LBRACE, "{"],
            [TokenType::RETURN, "return"],
            [TokenType::TRUE, "true"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::RBRACE, "}"],
            [TokenType::ELSE, "else"],
            [TokenType::LBRACE, "{"],
            [TokenType::RETURN, "return"],
            [TokenType::FALSE, "false"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::RBRACE, "}"],
            [TokenType::INT, "10"],
            [TokenType::EQ, "=="],
            [TokenType::INT, "10"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::INT, "10"],
            [TokenType::NEQ, "!="],
            [TokenType::INT, "9"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::INT, "10"],
            [TokenType::GTE, ">="],
            [TokenType::INT, "5"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::INT, "5"],
            [TokenType::LTE, "<="],
            [TokenType::INT, "10"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::STRING, "foobar"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::STRING, "foo bar"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LBRACKET, "["],
            [TokenType::INT, "1"],
            [TokenType::COMMA, ","],
            [TokenType::INT, "2"],
            [TokenType::RBRACKET, "]"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::LBRACE, "{"],
            [TokenType::STRING, "foo"],
            [TokenType::COLON, ":"],
            [TokenType::STRING, "bar"],
            [TokenType::RBRACE, "}"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::FLOAT, "10.5"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::FLOAT, "10.0"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::FLOAT, "0.5"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::INT, "10"],
            [TokenType::EQ, "=="],
            [TokenType::INT, "10"],
            [TokenType::LOGICAL_AND, "&&"],
            [TokenType::INT, "5"],
            [TokenType::NEQ, "!="],
            [TokenType::INT, "3"],
            [TokenType::LOGICAL_OR, "||"],
            [TokenType::INT, "7"],
            [TokenType::LTE, "<="],
            [TokenType::INT, "8"],
            [TokenType::SEMICOLON, ";"],
            [TokenType::EOF, ""],
        ];

        $lexer = new Lexer($input);
        foreach ($tests as $i => $tt) {
            $token = $lexer->nextToken();
            [$expectedType, $expectedLiteral] = $tt;
            
            $this->assertEquals($expectedType, $token->getTokenType(), 
                sprintf("tests[%d] - token type wrong. expected=%s, got=%s",
                    $i, $expectedType, $token->getTokenType()));

            $this->assertEquals($expectedLiteral, $token->getLiteral(), 
                sprintf("tests[%d] - literal wrong. expected=%s, got=%s",
                    $i, $expectedLiteral, $token->getLiteral()));
        }
        
        // 测试边缘情况
        $input = "0.123 123.0 .456 ! != <= >= && || \"\";";

        $tests = [
            [TokenType::FLOAT, "0.123"],
            [TokenType::FLOAT, "123.0"],
            [TokenType::ILLEGAL, "."],
            [TokenType::INT, "456"],
            [TokenType::BAND, "!"],
            [TokenType::NEQ, "!="],
            [TokenType::LTE, "<="],
            [TokenType::GTE, ">="],
            [TokenType::LOGICAL_AND, "&&"],
            [TokenType::LOGICAL_OR, "||"],
            [TokenType::STRING, ""],
            [TokenType::SEMICOLON, ";"],
            [TokenType::EOF, ""],
        ];

        $lexer = new Lexer($input);
        foreach ($tests as $i => $tt) {
            $token = $lexer->nextToken();
            [$expectedType, $expectedLiteral] = $tt;
            
            $this->assertEquals($expectedType, $token->getTokenType(), 
                sprintf("Edge case tests[%d] - token type wrong. expected=%s, got=%s",
                    $i, $expectedType, $token->getTokenType()));

            $this->assertEquals($expectedLiteral, $token->getLiteral(), 
                sprintf("Edge case tests[%d] - literal wrong. expected=%s, got=%s",
                    $i, $expectedLiteral, $token->getLiteral()));
        }
    }

    /**
     * 测试获取当前字符的方法
     *
     * @return void
     */
    public function testGetCurrentChar(): void
    {
        $input = "let x = 5;";
        $lexer = new Lexer($input);
        
        $this->assertEquals('l', $lexer->getCurrentChar());
        
        $lexer->readChar();
        $this->assertEquals('e', $lexer->getCurrentChar());
        
        $lexer->readChar();
        $this->assertEquals('t', $lexer->getCurrentChar());
    }

    /**
     * 测试读取字符的方法
     * 包括正常情况和边界情况（如空字符串）的测试
     *
     * @return void
     */
    public function testReadChar(): void
    {
        // 测试正常情况
        $input = "abc";
        $lexer = new Lexer($input);
        
        // 构造函数已经读取了第一个字符
        $this->assertEquals('a', $lexer->getCurrentChar());
        // readChar方法会更新当前字符
        $lexer->readChar();
        $this->assertEquals('b', $lexer->getCurrentChar());
        $lexer->readChar();
        $this->assertEquals('c', $lexer->getCurrentChar());
        // 到达文件末尾
        $lexer->readChar();
        $this->assertEquals('', $lexer->getCurrentChar());
        // 验证在文件末尾后继续读取仍然保持EOF
        $lexer->readChar();
        $this->assertEquals('', $lexer->getCurrentChar());
        
        // 测试空字符串情况
        $emptyLexer = new Lexer("");
        $this->assertEquals('', $emptyLexer->getCurrentChar());
        $emptyLexer->readChar();
        $this->assertEquals('', $emptyLexer->getCurrentChar());
    }

    /**
     * 测试获取并前进到下一个字符的方法
     *
     * @return void
     */
    public function testNextChar(): void
    {
        $input = "ab";
        $lexer = new Lexer($input);
        
        $this->assertEquals('a', $lexer->nextChar());
        $this->assertEquals('b', $lexer->getCurrentChar());
    }

    /**
     * 测试预读取下一个字符的方法
     *
     * @return void
     */
    public function testPeekChar(): void
    {
        $input = "ab";
        $lexer = new Lexer($input);
        
        $this->assertEquals('b', $lexer->peekChar());
        $this->assertEquals('a', $lexer->getCurrentChar()); // peekChar不应该改变当前字符
        
        $lexer->readChar(); // 移动到下一个字符
        $this->assertEquals('b', $lexer->getCurrentChar());
        $this->assertEquals('', $lexer->peekChar()); // 文件结尾
    }

    /**
     * 测试跳过空白字符的方法
     *
     * @return void
     */
    public function testSkipWhitespace(): void
    {
        $input = " \t\n\rabc";
        $lexer = new Lexer($input);
        
        $lexer->skipWhitespace();
        $this->assertEquals('a', $lexer->getCurrentChar());
    }

    /**
     * 测试跳过注释的方法
     *
     * @return void
     */
    public function testSkipComment(): void
    {
        // 让我们创建一个更简单的测试输入
        $input = "//comment\ntest";
        $lexer = new Lexer($input);
        
        // 构造函数已经读取了第一个字符 '/'
        $firstChar = $lexer->getCurrentChar();
        $this->assertEquals('/', $firstChar, "Expected '/' but got '{$firstChar}'");
        
        // 查看下一个字符是否也是 '/'
        $secondChar = $lexer->peekChar();
        $this->assertEquals('/', $secondChar, "Expected '/' but got '{$secondChar}'");
        
        $lexer->skipComment();
        $this->assertEquals('t', $lexer->getCurrentChar());
    }

    /**
     * 测试判断是否为字母的方法
     *
     * @return void
     */
    public function testIsLetter(): void
    {
        $lexer = new Lexer("");
        
        $this->assertTrue($lexer->isLetter('a'));
        $this->assertTrue($lexer->isLetter('z'));
        $this->assertTrue($lexer->isLetter('A'));
        $this->assertTrue($lexer->isLetter('Z'));
        $this->assertTrue($lexer->isLetter('_'));
        $this->assertFalse($lexer->isLetter('0'));
        $this->assertFalse($lexer->isLetter('-'));
    }

    /**
     * 测试判断是否为数字的方法
     *
     * @return void
     */
    public function testIsDigit(): void
    {
        $lexer = new Lexer("");
        
        $this->assertTrue($lexer->isDigit('0'));
        $this->assertTrue($lexer->isDigit('9'));
        $this->assertFalse($lexer->isDigit('a'));
        $this->assertFalse($lexer->isDigit('_'));
    }

    /**
     * 测试读取标识符的方法
     *
     * @return void
     */
    public function testReadIdentifier(): void
    {
        $input = "let x = 5;";
        $lexer = new Lexer($input);
        
        $this->assertEquals("let", $lexer->readIdentifier());
    }

    /**
     * 测试预读取标识符的方法
     *
     * @return void
     */
    public function testPeekIdentifier(): void
    {
        $input = "let x = 5;";
        $lexer = new Lexer($input);
        
        $this->assertEquals("let", $lexer->peekIdentifier());
        $this->assertEquals("l", $lexer->getCurrentChar()); // peekIdentifier不应该改变当前位置
    }

    /**
     * 测试读取数字的方法
     *
     * @return void
     */
    public function testReadNumber(): void
    {
        // 测试整数
        $lexer = new Lexer("123 ");
        $this->assertEquals("123", $lexer->readNumber());
        
        // 测试浮点数
        $lexer = new Lexer("123.45 ");
        $this->assertEquals("123.45", $lexer->readNumber());
        
        // 测试整数后面跟着非数字字符
        $lexer = new Lexer("123;");
        $this->assertEquals("123", $lexer->readNumber());
        
        // 测试浮点数后面跟着非数字字符
        $lexer = new Lexer("123.45;");
        $this->assertEquals("123.45", $lexer->readNumber());
    }

    /**
     * 测试读取字符串的方法
     *
     * @return void
     */
    public function testReadString(): void
    {
        $input = '"hello world"';
        $lexer = new Lexer($input);
        
        $this->assertEquals("hello world", $lexer->readString());
    }
}