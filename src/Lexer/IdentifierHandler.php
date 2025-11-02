<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Lexer;

use Shenlink\Holiya\Token\Token;

/**
 * 标识符处理器
 */
class IdentifierHandler implements ITokenHandler
{
    /**
     * 判断是否可以处理
     *
     * @param Lexer $lexer 词法分析器实例
     * @return bool 是否可以处理
     */
    public function canHandle(Lexer $lexer): bool
    {
        return $lexer->isLetter($lexer->getCurrentChar());
    }

    /**
     * 返回 Token 实例
     *
     * @param Lexer $lexer 词法分析器实例
     * @return Token Token 实例
     */
    public function getToken(Lexer $lexer): Token
    {
        $tokenType = Token::lookupIdentifier($lexer->peekIdentifier());
        return new Token($tokenType, $lexer->readIdentifier());
    }
}
