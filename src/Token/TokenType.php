<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Token;

/**
 * Token 类型
 */
class TokenType
{
    /**
     * @var string 非法字符
     */
    const ILLEGAL = 'ILLEGAL';

    /**
     * @var string 结束符
     */
    const EOF = 'EOF';

    /**
     * @var string 标识符
     */
    const IDENTIFIER = 'IDENTIFIER';

    /**
     * @var string 整数
     */
    const INT = 'INT';

    /**
     * @var string 浮点数
     */
    const FLOAT = 'FLOAT';

    /**
     * @var string 字符串
     */
    const STRING = 'STRING';

    /**
     * @var string 赋值
     */
    const ASSIGN = '=';

    /**
     * @var string 加号
     */
    const PLUS = '+';

    /**
     * @var string 减号
     */
    const MINUS = '-';

    /**
     * @var string 乘号
     */
    const MULTIPLY = '*';

    /**
     * @var string 除号
     */
    const DIVIDE = '/';

    /**
     * @var string 模运算符
     */
    const MODULO = '%';

    /**
     * @var string 逻辑非
     */
    const BAND = '!';

    /**
     * @var string 逻辑与
     */
    const LOGICAL_AND = '&&';

    /**
     * @var string 逻辑或
     */
    const LOGICAL_OR = '||';

    /**
     * @var string 小于
     */
    const LT = '<';

    /**
     * @var string 大于
     */
    const GT = '>';

    /**
     * @var string 小于等于
     */
    const LTE = '<=';

    /**
     * @var string 大于等于
     */
    const GTE = '>=';

    /**
     * @var string 等于
     */
    const EQ = '==';

    /**
     * @var string 不等于
     */
    const NEQ = '!=';

    /**
     * @var string 左括号
     */
    const LPAREN = '(';

    /**
     * @var string 右括号
     */
    const RPAREN = ')';

    /**
     * @var string 左大括号
     */
    const LBRACE = '{';

    /**
     * @var string 右大括号
     */
    const RBRACE = '}';

    /**
     * @var string 左中括号
     */
    const LBRACKET = '[';

    /**
     * @var string 右中括号
     */
    const RBRACKET = ']';

    /**
     * @var string 逗号
     */
    const COMMA = ',';

    /**
     * @var string 分号
     */
    const SEMICOLON = ';';

    /**
     * @var string 冒号
     */
    const COLON = ':';

    /**
     * @var string 函数
     */
    const FUNCTION = 'FUNCTION';

    /**
     * @var string 变量声明
     */
    const LET = 'LET';

    /**
     * @var string 逻辑TRUE
     */
    const TRUE = 'TRUE';

    /**
     * @var string 逻辑FALSE
     */
    const FALSE = 'FALSE';

    /**
     * @var string 如果
     */
    const IF = 'IF';

    /**
     * @var string 否则
     */
    const ELSE = 'ELSE';

    /**
     * @var string 函数返回
     */
    const RETURN = 'RETURN';
}