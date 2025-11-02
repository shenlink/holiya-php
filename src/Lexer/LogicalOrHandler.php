<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Lexer;

use Shenlink\Holiya\Token\Token;
use Shenlink\Holiya\Token\TokenType;

/**
 * 逻辑或运算符处理器
 */
class LogicalOrHandler implements ITokenHandler
{
    /**
     * 判断是否可以处理
     *
     * @param Lexer $lexer 词法分析器实例
     * @return bool 是否可以处理
     */
    public function canHandle(Lexer $lexer): bool
    {
        return $lexer->getCurrentChar() === '|' && $lexer->peekChar() === '|';
    }

    /**
     * 返回 Token 实例
     *
     * @param Lexer $lexer 词法分析器实例
     * @return Token Token 实例
     */
    public function getToken(Lexer $lexer): Token
    {
        return new Token(TokenType::LOGICAL_OR, $lexer->nextChar() . $lexer->nextChar());
    }
}
