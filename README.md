# Holiya 编程语言 (PHP 版本)

Holiya 是一个基于 PHP 语言实现的解释型编程语言项目，灵感来源于《用Go语言自制解释器》一书。这是该项目的 PHP 实现版本，在功能和设计理念上与 Go 版本保持一致，并针对 PHP 语言特性进行了适配。

## 快速开始

### 1. 安装 PHP 环境
确保您的系统已安装 PHP 7.4 或更高版本。可以通过以下命令检查 PHP 是否正确安装：

```bash
php -v
```

如果尚未安装 PHP，请参考 [PHP 官方文档](https://www.php.net/manual/en/install.php) 进行安装。

### 2. 克隆项目

- [Gitee 地址](https://gitee.com/shenlink/holiya-php)
```shell
git clone https://gitee.com/shenlink/holiya-php.git
```

- [GitHub 地址](https://github.com/shenlink/holiya-php)
```shell
git clone https://github.com/shenlink/holiya-php.git
```

### 3. 运行项目

进入项目目录后，可以直接使用 PHP 执行主入口文件：

```shell
cd holiya-php
php holiya.php
```

这将启动 REPL（交互式解释器）模式，您可以直接输入 Holiya 代码并立即看到执行结果。

也可以通过传递 `.holiya` 文件作为参数来执行特定脚本：

```shell
php holiya.php filename.holiya
```

### 4. 示例程序

创建一个简单的 Holiya 脚本文件 `hello.holiya`：

```holiya
print("Hello, Holiya!");
```

然后运行它：

```shell
php holiya.php hello.holiya
```

## 许可证

本项目采用 [MIT 许可证](LICENSE)