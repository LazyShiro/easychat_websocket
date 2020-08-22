<?php declare(strict_types=1);

namespace Swoft\Console\Helper;

use Closure;
use RuntimeException;
use Swoft\Console\Advanced\Interact\Checkbox;
use Swoft\Console\Advanced\Interact\Choose;
use Swoft\Console\Advanced\Interact\Confirm;
use Swoft\Console\Advanced\Interact\LimitedAsk;
use Swoft\Console\Advanced\Interact\Password;
use Swoft\Console\Advanced\Interact\Question;
use Swoft\Console\Console;
use function sprintf;
use function strtolower;
use function trim;
use const STDIN;

/**
 * Class Interact
 * @since 2.o
 */
class Interact extends Show
{
    /**
     * read line from CLI input
     * @param mixed $message
     * @param bool  $nl
     * @param array $opts
     * [
     *   'stream' => \STDIN
     * ]
     * @return string
     */
    public static function readln($message = null, $nl = false, array $opts = []): string
    {
        if ($message) {
            self::write($message, $nl);
        }

        $stream = $opts['stream'] ?? STDIN;

        return trim(fgets($stream));
    }

    /**
     * 读取输入信息
     * @param  mixed $message 若不为空，则先输出文本
     * @param  bool  $nl true 会添加换行符 false 原样输出，不添加换行符
     * @return string
     */
    public static function readRow($message = null, $nl = false): string
    {
        return self::readln($message, $nl);
    }

    /**
     * @param null|mixed $message
     * @param bool       $nl
     * @return string
     */
    public static function readFirst($message = null, $nl = false): string
    {
        $input = self::readln($message, $nl);

        if ($input && ($f = $input[0])) {
            return $f;
        }

        return '';
    }

    /**************************************************************************************************
     * Interactive method (select/confirm/question/loopAsk)
     **************************************************************************************************/

    /**
     * alias of the `select()`
     * @param  string       $description 说明
     * @param  string|array $options 选项数据
     * @param  int|string   $default 默认选项
     * @param  bool         $allowExit 有退出选项 默认 true
     * @return string
     */
    public static function select(string $description, $options, $default = null, bool $allowExit = true): string
    {
        return self::choice($description, $options, $default, $allowExit);
    }

    /**
     * Choose one of several options
     * @param string       $description
     * @param string|array $options Option data
     * e.g
     * [
     *    // option => value
     *    '1' => 'chengdu',
     *    '2' => 'beijing'
     * ]
     * @param string|int   $default Default option
     * @param bool         $allowExit
     * @return string
     */
    public static function choice(string $description, $options, $default = null, bool $allowExit = true): string
    {
        return Choose::one($description, $options, $default, $allowExit);
    }

    /**
     * alias of the `multiSelect()`
     * @param string       $description
     * @param string|array $options
     * @param null|mixed   $default
     * @param bool         $allowExit
     * @return array
     */
    public static function checkbox(string $description, $options, $default = null, bool $allowExit = true): array
    {
        return self::multiSelect($description, $options, $default, $allowExit);
    }

    /**
     * List multiple options and allow multiple selections
     *
     * @param string       $description
     * @param string|array $options
     * @param null|mixed   $default
     * @param bool         $allowExit
     * @return array
     */
    public static function multiSelect(string $description, $options, $default = null, bool $allowExit = true): array
    {
        return Checkbox::select($description, $options, $default, $allowExit);
    }

    /**
     * Send a message request confirmation
     *
     * @param string $question The question message
     * @param bool   $default  Default value
     * @param bool   $nl
     *
     * @return bool
     */
    public static function confirm(string $question, bool $default = true, bool $nl = true): bool
    {
        return Confirm::ask($question, $default, $nl);
    }

    /**
     * Send a message request confirmation
     *
     * @param string $question The question message
     * @param bool   $default Default value
     * @param bool   $nl
     *
     * @return bool
     */
    public static function unConfirm(string $question, bool $default = true, bool $nl = true): bool
    {
        return Confirm::not($question, $default, $nl);
    }

    /**
     * Usage:
     *
     * ```php
     *  echo "are you ok?";
     *  $ok = Interact::answerIsYes();
     * ```
     *
     * @param bool|null $default
     * @return bool
     */
    public static function answerIsYes(bool $default = null): bool
    {
        $mark = ' [yes|no]: ';

        if ($default !== null) {
            $defMsg = $default ? 'yes' : 'no';
            $mark   = sprintf(' [yes|no](default <cyan>%s</cyan>): ', $defMsg);
        }

        if ($answer = Console::readFirst($mark)) {
            $answer = strtolower($answer);

            if ($answer === 'y') {
                return true;
            }

            if ($answer === 'n') {
                return false;
            }
        } elseif ($default !== null) {
            return $default;
        }

        print 'Please try again';
        return self::answerIsYes();
    }

    /**
     * alias of the `question()`
     * @param string   $question question message
     * @param string   $default default value
     * @param Closure $validator The validate callback. It must return bool.
     * @return string
     */
    public static function ask(string $question, string $default = '', Closure $validator = null): string
    {
        return self::question($question, $default, $validator);
    }

    /**
     * Ask a question, ask for results; return the result of the input
     * @see Question::ask()
     * @param string        $question
     * @param string        $default
     * @param Closure|null $validator Validator, must return bool.
     * @return string
     */
    public static function question(string $question, string $default = '', Closure $validator = null): string
    {
        return Question::ask($question, $default, $validator);
    }

    /**
     * Ask a question, ask for a limited number of times
     * @see LimitedAsk::ask()
     * @param string   $question 问题
     * @param string   $default 默认值
     * @param Closure $validator (默认验证输入是否为空)自定义回调验证输入是否符合要求; 验证成功返回true 否则 可返回错误消息
     * @param int      $times Allow input times
     * @return string
     */
    public static function limitedAsk(
        string $question,
        string $default = '',
        Closure $validator = null,
        int $times = 3
    ): string {
        return LimitedAsk::ask($question, $default, $validator, $times);
    }

    /**************************************************************************************************
     * password ask
     **************************************************************************************************/

    /**
     * Interactively prompts for input without echoing to the terminal.
     * Requires a bash shell or Windows and won't work with
     * safe_mode settings (Uses `shell_exec`)
     * @param string $prompt
     * @return string
     * @link https://stackoverflow.com/questions/187736/command-line-password-prompt-in-php
     * @link http://www.sitepoint.com/blogs/2009/05/01/interactive-cli-password-prompt-in-php
     * @throws RuntimeException
     */
    public static function promptSilent(string $prompt = 'Enter Password:'): string
    {
        return Password::ask($prompt);
    }

    /**
     * alias of the method `promptSilent()`
     * @param string $prompt
     * @return string
     * @throws RuntimeException
     */
    public static function askHiddenInput(string $prompt = 'Enter Password:'): string
    {
        return self::promptSilent($prompt);
    }

    /**
     * alias of the method `promptSilent()`
     * @param string $prompt
     * @return string
     * @throws RuntimeException
     */
    public static function askPassword(string $prompt = 'Enter Password:'): string
    {
        return self::promptSilent($prompt);
    }
}
