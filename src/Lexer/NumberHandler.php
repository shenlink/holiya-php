<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Lexer;

use Shenlink\Holiya\Token\Token;
use Shenlink\Holiya\Token\TokenType;

/**
 * 数字处理器，包含整数和浮点数
 */
class NumberHandler implements ITokenHandler
{
    /**
     * 判断是否可以处理
     *
     * @param Lexer $lexer 词法分析器实例
     * @return bool 是否可以处理
     */
    public function canHandle(Lexer $lexer): bool
    {
        return $lexer->isDigit($lexer->getCurrentChar());
    }

    /**
     * 返回 Token 实例
     *
     * @param Lexer $lexer 词法分析器实例
     * @return Token Token 实例
     */
    public function getToken(Lexer $lexer): Token
    {
        $literal = $lexer->readNumber();
        $tokenType = (strpos($literal, '.') !== false) ? TokenType::FLOAT : TokenType::INT;
        return new Token($tokenType, $literal);
    }
}