<?php

declare(strict_types=1);

namespace Tests\Unit\Token;

use PHPUnit\Framework\TestCase;
use Shenlink\Holiya\Token\Token;
use Shenlink\Holiya\Token\TokenType;

/**
 * Token 类单元测试
 */
class TokenTest extends TestCase
{
    /**
     * 测试 Token 类型是否正确设置
     */
    public function testTokenType(): void
    {
        $tests = [
            // 特殊类型
            ['token' => new Token(TokenType::ILLEGAL, 'illegal'), 'expected' => TokenType::ILLEGAL],
            ['token' => new Token(TokenType::EOF, ''), 'expected' => TokenType::EOF],

            // 标识符
            ['token' => new Token(TokenType::IDENTIFIER, 'x'), 'expected' => TokenType::IDENTIFIER],

            // 数据类型
            ['token' => new Token(TokenType::INT, '42'), 'expected' => TokenType::INT],
            ['token' => new Token(TokenType::STRING, 'hello'), 'expected' => TokenType::STRING],
            ['token' => new Token(TokenType::FLOAT, '43.0'), 'expected' => TokenType::FLOAT],

            // 数学运算符
            ['token' => new Token(TokenType::ASSIGN, '='), 'expected' => TokenType::ASSIGN],
            ['token' => new Token(TokenType::PLUS, '+'), 'expected' => TokenType::PLUS],
            ['token' => new Token(TokenType::MINUS, '-'), 'expected' => TokenType::MINUS],
            ['token' => new Token(TokenType::MULTIPLY, '*'), 'expected' => TokenType::MULTIPLY],
            ['token' => new Token(TokenType::DIVIDE, '/'), 'expected' => TokenType::DIVIDE],
            ['token' => new Token(TokenType::MODULO, '%'), 'expected' => TokenType::MODULO],

            // 逻辑运算符
            ['token' => new Token(TokenType::BAND, '!'), 'expected' => TokenType::BAND],
            ['token' => new Token(TokenType::LOGICAL_AND, '&&'), 'expected' => TokenType::LOGICAL_AND],
            ['token' => new Token(TokenType::LOGICAL_OR, '||'), 'expected' => TokenType::LOGICAL_OR],

            // 比较运算符
            ['token' => new Token(TokenType::LT, '<'), 'expected' => TokenType::LT],
            ['token' => new Token(TokenType::GT, '>'), 'expected' => TokenType::GT],
            ['token' => new Token(TokenType::LTE, '<='), 'expected' => TokenType::LTE],
            ['token' => new Token(TokenType::GTE, '>='), 'expected' => TokenType::GTE],
            ['token' => new Token(TokenType::EQ, '=='), 'expected' => TokenType::EQ],
            ['token' => new Token(TokenType::NEQ, '!='), 'expected' => TokenType::NEQ],

            // 分隔符
            ['token' => new Token(TokenType::LPAREN, '('), 'expected' => TokenType::LPAREN],
            ['token' => new Token(TokenType::RPAREN, ')'), 'expected' => TokenType::RPAREN],
            ['token' => new Token(TokenType::LBRACE, '{'), 'expected' => TokenType::LBRACE],
            ['token' => new Token(TokenType::RBRACE, '}'), 'expected' => TokenType::RBRACE],
            ['token' => new Token(TokenType::LBRACKET, '['), 'expected' => TokenType::LBRACKET],
            ['token' => new Token(TokenType::RBRACKET, ']'), 'expected' => TokenType::RBRACKET],
            ['token' => new Token(TokenType::COMMA, ','), 'expected' => TokenType::COMMA],
            ['token' => new Token(TokenType::SEMICOLON, ';'), 'expected' => TokenType::SEMICOLON],
            ['token' => new Token(TokenType::COLON, ':'), 'expected' => TokenType::COLON],

            // 关键字
            ['token' => new Token(TokenType::FUNCTION, 'function'), 'expected' => TokenType::FUNCTION],
            ['token' => new Token(TokenType::LET, 'let'), 'expected' => TokenType::LET],
            ['token' => new Token(TokenType::TRUE, 'true'), 'expected' => TokenType::TRUE],
            ['token' => new Token(TokenType::FALSE, 'false'), 'expected' => TokenType::FALSE],
            ['token' => new Token(TokenType::IF, 'if'), 'expected' => TokenType::IF],
            ['token' => new Token(TokenType::ELSE, 'else'), 'expected' => TokenType::ELSE],
            ['token' => new Token(TokenType::RETURN, 'return'), 'expected' => TokenType::RETURN],
        ];

        foreach ($tests as $index => $test) {
            $token = $test['token'];
            $expected = $test['expected'];
            $tokenType = $token->getTokenType();
            $literal = $token->getLiteral();
            $message = "Test case #{$index}: Token '{$literal}' with type = {$tokenType}, expected {$expected}";
            $this->assertEquals($expected, $tokenType, $message);
        }
    }


    /**
     * 测试 Token 字面量是否正确设置
     */
    public function testTokenLiteral(): void
    {
        $tests = [
            // 特殊类型
            ['token' => new Token(TokenType::ILLEGAL, 'illegal'), 'expected' => 'illegal'],
            ['token' => new Token(TokenType::EOF, ''), 'expected' => ''],

            // 标识符
            ['token' => new Token(TokenType::IDENTIFIER, 'x'), 'expected' => 'x'],

            // 数据类型
            ['token' => new Token(TokenType::INT, '42'), 'expected' => '42'],
            ['token' => new Token(TokenType::STRING, 'hello'), 'expected' => 'hello'],
            ['token' => new Token(TokenType::FLOAT, '43.0'), 'expected' => '43.0'],

            // 数学运算符
            ['token' => new Token(TokenType::ASSIGN, '='), 'expected' => '='],
            ['token' => new Token(TokenType::PLUS, '+'), 'expected' => '+'],
            ['token' => new Token(TokenType::MINUS, '-'), 'expected' => '-'],
            ['token' => new Token(TokenType::MULTIPLY, '*'), 'expected' => '*'],
            ['token' => new Token(TokenType::DIVIDE, '/'), 'expected' => '/'],
            ['token' => new Token(TokenType::MODULO, '%'), 'expected' => '%'],

            // 逻辑运算符
            ['token' => new Token(TokenType::BAND, '!'), 'expected' => '!'],
            ['token' => new Token(TokenType::LOGICAL_AND, '&&'), 'expected' => '&&'],
            ['token' => new Token(TokenType::LOGICAL_OR, '||'), 'expected' => '||'],

            // 比较运算符
            ['token' => new Token(TokenType::LT, '<'), 'expected' => '<'],
            ['token' => new Token(TokenType::GT, '>'), 'expected' => '>'],
            ['token' => new Token(TokenType::LTE, '<='), 'expected' => '<='],
            ['token' => new Token(TokenType::GTE, '>='), 'expected' => '>='],
            ['token' => new Token(TokenType::EQ, '=='), 'expected' => '=='],
            ['token' => new Token(TokenType::NEQ, '!='), 'expected' => '!='],

            // 分隔符
            ['token' => new Token(TokenType::LPAREN, '('), 'expected' => '('],
            ['token' => new Token(TokenType::RPAREN, ')'), 'expected' => ')'],
            ['token' => new Token(TokenType::LBRACE, '{'), 'expected' => '{'],
            ['token' => new Token(TokenType::RBRACE, '}'), 'expected' => '}'],
            ['token' => new Token(TokenType::LBRACKET, '['), 'expected' => '['],
            ['token' => new Token(TokenType::RBRACKET, ']'), 'expected' => ']'],
            ['token' => new Token(TokenType::COMMA, ','), 'expected' => ','],
            ['token' => new Token(TokenType::SEMICOLON, ';'), 'expected' => ';'],
            ['token' => new Token(TokenType::COLON, ':'), 'expected' => ':'],

            // 关键字
            ['token' => new Token(TokenType::FUNCTION, 'function'), 'expected' => 'function'],
            ['token' => new Token(TokenType::LET, 'let'), 'expected' => 'let'],
            ['token' => new Token(TokenType::TRUE, 'true'), 'expected' => 'true'],
            ['token' => new Token(TokenType::FALSE, 'false'), 'expected' => 'false'],
            ['token' => new Token(TokenType::IF, 'if'), 'expected' => 'if'],
            ['token' => new Token(TokenType::ELSE, 'else'), 'expected' => 'else'],
            ['token' => new Token(TokenType::RETURN, 'return'), 'expected' => 'return'],
        ];

        foreach ($tests as $index => $test) {
            $token = $test['token'];
            $expected = $test['expected'];
            $tokenType = $token->getTokenType();
            $literal = $token->getLiteral();
            $message = "Test case #{$index}: Token '{$literal}' with type = {$tokenType}, expected {$expected}";
            $this->assertEquals($expected, $literal, $message);
        }
    }

    /**
     * 测试 lookupIdentifier 是否能正确识别关键字
     */
    public function testLookupIdentifier(): void
    {
        $token = new Token('', '');
        $tests = [
            ['function', TokenType::FUNCTION],
            ['let', TokenType::LET],
            ['true', TokenType::TRUE],
            ['false', TokenType::FALSE],
            ['if', TokenType::IF],
            ['else', TokenType::ELSE],
            ['return', TokenType::RETURN],
            // 非关键字应返回 IDENTIFIER 类型
            ['unknown', TokenType::IDENTIFIER],
        ];

        foreach ($tests as $test) {
            [$input, $expected] = $test;
            $result = $token->lookupIdentifier($input);
            $this->assertEquals($expected, $result, "lookupIdentifier('{$input}') = {$result}, expected {$expected}");
        }
    }
}