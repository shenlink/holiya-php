<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Token;

/**
 * Token 类
 */
class Token
{
    /**
     * @var string token 类型
     */
    private string $tokenType;

    /**
     * @var string token 值
     */
    private string $literal;

    public function __construct(string $tokenType, string $literal)
    {
        $this->tokenType = $tokenType;
        $this->literal = $literal;
    }

    /**
     * 获取 token 类型
     *
     * @return string token 类型
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * 获取 token 值
     *
     * @return string token 值
     */
    public function getLiteral(): string
    {
        return $this->literal;
    }

    /**
     * 获取标识符类型
     *
     * @param string $identifier 标识符
     * @return string 返回标识符对应的 Token 类型，如果未找到则返回 IDENTIFIER 类型
     */
    public function lookupIdentifier(string $identifier): string
    {
        $keywords = $this->getKeywords();
        return $keywords[$identifier] ?? TokenType::IDENTIFIER;
    }

    /**
     * 获取关键字数组
     *
     * @return array
     */
    private function getKeywords(): array
    {
        return [
            'function' => TokenType::FUNCTION,
            'let' => TokenType::LET,
            'true' => TokenType::TRUE,
            'false' => TokenType::FALSE,
            'if' => TokenType::IF,
            'else' => TokenType::ELSE,
            'return' => TokenType::RETURN,
        ];
    }
}