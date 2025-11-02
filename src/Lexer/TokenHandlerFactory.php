<?php

declare(strict_types=1);

namespace Shenlink\Holiya\Lexer;

use RuntimeException;

class TokenHandlerFactory
{
    /**
     * @var TokenHandlerFactory 实例
     */
    private static $instance;

    /**
     * @var ITokenHandler[] 处理器列表
     */
    private static array $handlers = [];

    /**
     * 禁止 new 实例化对象
     */
    private function __construct() {}

    /**
     * 获取单例
     *
     * @return TokenHandlerFactory 实例
     */
    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * 防止克隆
     *
     * @return void
     */
    private function __clone() {}

    /**
     * 禁止反序列化
     *
     * @return void
     */
    public function __wakeup()
    {
        if (self::$instance !== null) {
            throw new RuntimeException('反序列化不被允许');
        }

        self::$instance = $this;
    }

    public function getHandler(Lexer $lexer): ITokenHandler
    {
        $handlers = $this->getHandlers();
        foreach ($handlers as $handler) {
            if ($handler->canHandle($lexer)) {
                return $handler;
            }
        }
        return new IllegalHandler();
    }

    private static function getHandlers(): array
    {
        if (!empty(self::$handlers)) {
            return self::$handlers;
        }
        self::$handlers = array(
            new AssignHandler(),
            new PlusHandler(),
            new MinusHandler(),
            new MultiplyHandler(),
            new DivideHandler(),
            new ModuloHandler(),
            new BandHandler(),
            new LessThanHandler(),
            new GreaterThanHandler(),
            new EqualHandler(),
            new NotEqualHandler(),
            new LessThanEqualHandler(),
            new GreaterThanEqualHandler(),
            new LogicalAndHandler(),
            new LogicalOrHandler(),
            new LeftParenHandler(),
            new RightParenHandler(),
            new LeftBraceHandler(),
            new RightBraceHandler(),
            new LeftBracketHandler(),
            new RightBracketHandler(),
            new CommaHandler(),
            new SemicolonHandler(),
            new ColonHandler(),
            new StringHandler(),
            new FunctionHandler(),
            new LetHandler(),
            new TrueHandler(),
            new FalseHandler(),
            new IfHandler(),
            new ElseHandler(),
            new ReturnHandler(),
            new IdentifierHandler(),
            new NumberHandler(),
            new IllegalHandler(),
            new EofHandler(),
        );
        return self::$handlers;
    }
}
