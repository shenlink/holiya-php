<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Lexer;

use Shenlink\Holiya\Token\Token;
use Shenlink\Holiya\Token\TokenType;

/**
 * 函数关键字处理器
 */
class FunctionHandler implements ITokenHandler
{
    /**
     * 判断是否可以处理
     *
     * @param Lexer $lexer 词法分析器实例
     * @return bool 是否可以处理
     */
    public function canHandle(Lexer $lexer): bool
    {
        return $lexer->peekIdentifier() === 'function';
    }

    /**
     * 返回 Token 实例
     *
     * @param Lexer $lexer 词法分析器实例
     * @return Token Token 实例
     */
    public function getToken(Lexer $lexer): Token
    {
        return new Token(TokenType::FUNCTION, $lexer->readIdentifier());
    }
}
