<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Lexer;

use Shenlink\Holiya\Token\Token;

/**
 * Token 处理器接口
 * 
 * 定义了 Token 处理器的基本行为，用于词法分析过程中识别和生成特定类型的 Token
 */
interface ITokenHandler
{
    /**
     * 检查给定字符是否可以由此处理器处理
     *
     * @param Lexer $lexer 词法分析器实例、
     * @return bool 返回 true 表示可以处理当前字符，false 表示不能处理
     */
    public function canHandle(Lexer $lexer): bool;

    /**
     * 根据词法分析器状态生成对应的 Token 实例
     *
     * @param Lexer $lexer 词法分析器实例
     * @return Token 返回生成的 Token 实例
     */
    public function getToken(Lexer $lexer): Token;
}