<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Lexer;

use Shenlink\Holiya\Token\Token;

/**
 * 词法分析器
 * 
 * 负责将输入的源代码字符串分解成一个个词法单元(Token)
 * 使用工厂模式和策略模式来处理不同类型的Token
 */
class Lexer
{
    /**
     * @var string 结束符
     */
    const EOF = '';

    /**
     * @var string 输入字符串
     */
    private string $input;

    /**
     * @var string 当前字符
     */
    private string $currentChar;

    /**
     * @var int 当前字符的位置
     */
    private int $position;

    /**
     * @var int 下一个字符的位置
     */
    private int $nextPosition = 0;

    /**
     * 构造函数，初始化词法分析器
     * 
     * @param string $input 输入的字符串
     */
    public function __construct(string $input)
    {
        $this->input = $input;
        // 读取一个字符，并正确设置 position 和 nextPosition
        $this->readChar();
    }

    /**
     * 获取下一个词法单元
     *
     * @return Token 返回下一个Token实例
     */
    public function nextToken(): Token
    {
        $this->skipWhitespace();
        $this->skipComment();

        $handler = TokenHandlerFactory::getInstance()->getHandler($this);
        return $handler->getToken($this);
    }

    /**
     * 跳过空白字符
     *
     * @return void
     */
    public function skipWhitespace(): void
    {
        while ($this->currentChar == ' ' || $this->currentChar == "\t"
            || $this->currentChar == "\n" || $this->currentChar == "\r") {
            $this->readChar();
        }
    }

    /**
     * 跳过注释
     *
     * @return void
     */
    public function skipComment(): void
    {
        while ($this->currentChar == '/' && $this->peekChar() == '/') {
            $this->readChar();
            $this->readChar();
            while ($this->currentChar != "\n") {
                if ($this->currentChar == '') {
                    break;
                }
                $this->readChar();
            }
            $this->skipWhitespace();
        }
    }

    /**
     * 读取一个字符
     *
     * @return void
     */
    public function readChar(): void
    {
        if ($this->nextPosition >= strlen($this->input)) {
            $this->currentChar = self::EOF;
        } else {
            $this->currentChar = $this->input[$this->nextPosition];
        }
        $this->position = $this->nextPosition;
        $this->nextPosition++;
    }

    /**
     * 获取当前字符
     *
     * @return string 当前字符
     */
    public function getCurrentChar(): string
    {
        return $this->currentChar;
    }

    /**
     * 获取并前进到下一个字符
     * 
     * @return string 当前字符
     */
    public function nextChar(): string
    {
        $char = $this->currentChar;
        $this->readChar();
        return $char;
    }

    /**
     * 获取下一个字符但不移动指针
     *
     * @return string 下一个字符
     */
    public function peekChar(): string
    {
        if ($this->nextPosition >= strlen($this->input)) {
            return self::EOF;
        }
        return $this->input[$this->nextPosition];
    }

    /**
     * 读取字符串
     *
     * @return string 字符串内容
     */
    public function readString(): string
    {
        $position = $this->position + 1;
        while (true) {
            $this->readChar();
            if ($this->currentChar == '"' || $this->currentChar == '') {
                break;
            }
        }
        $this->readChar();
        return substr($this->input, $position, $this->position - $position - 1);
    }

    /**
     * 判断是否是字母或下划线
     *
     * @param string $char 当前字符
     * @return bool 返回判断结果，true为是，false为否
     */
    public function isLetter(string $char): bool
    {
        return $char == '_' || ($char >= 'a' && $char <= 'z') || ($char >= 'A' && $char <= 'Z');
    }

    /**
     * 判断是否是数字
     *
     * @param string $char 当前字符
     * @return bool 返回判断结果，true为是，false为否
     */
    public function isDigit(string $char): bool
    {
        return $char >= '0' && $char <= '9';
    }

    /**
     * 读取标识符
     *
     * @return string 标识符
     */
    public function readIdentifier(): string
    {
        $position = $this->position;
        while ($this->isLetter($this->currentChar) || $this->isDigit($this->currentChar)) {
            $this->readChar();
        }
        return substr($this->input, $position, $this->position - $position);
    }

    /**
     * 预读取标识符，但不移动指针
     *
     * @return string 标识符
     */
    public function peekIdentifier(): string
    {
        $position = $this->position;
        while ($this->isLetter($this->currentChar) || $this->isDigit($this->currentChar)) {
            $this->readChar();
        }
        $identifier = substr($this->input, $position, $this->position - $position);
        $this->position = $position;
        $this->nextPosition = $this->position + 1;
        $this->currentChar = $this->input[$this->position];
        return $identifier;
    }

    /**
     * 读取数字，包含整数和浮点数
     *
     * @return string 数字字符串
     */
    public function readNumber(): string
    {
        $position = $this->position;
        
        // 读取整数部分
        while ($this->isDigit($this->currentChar)) {
            $this->readChar();
        }
        
        // 如果有小数点，且小数点后还有数字，读取小数部分
        if ($this->currentChar === '.' && $this->isDigit($this->peekChar())) {
            $this->readChar(); // 读取小数点
            
            // 读取小数部分
            while ($this->isDigit($this->currentChar)) {
                $this->readChar();
            }
        }

        return substr($this->input, $position, $this->position - $position);
    }
}