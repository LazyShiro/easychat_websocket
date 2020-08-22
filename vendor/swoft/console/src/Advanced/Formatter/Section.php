<?php declare(strict_types=1);

namespace Swoft\Console\Advanced\Formatter;

use Swoft\Console\Advanced\MessageFormatter;
use Swoft\Console\Helper\FormatUtil;
use Swoft\Console\Helper\Show;
use Swoft\Stdlib\Helper\Str;
use function array_merge;
use function ceil;
use function implode;
use function is_array;
use function trim;
use function ucwords;
use const PHP_EOL;

/**
 * Class Section
 * @package Swoft\Console\Advanced\Formatter
 */
class Section extends MessageFormatter
{
    /**
     * @param string       $title The title text
     * @param string|array $body The section body message
     * @param array        $opts
     */
    public static function show(string $title, $body, array $opts = []): void
    {
        $opts = array_merge([
            'width'        => 80,
            'char'         => self::CHAR_HYPHEN,
            'titlePos'     => self::POS_LEFT,
            'indent'       => 2,
            'topBorder'    => true,
            'bottomBorder' => true,
        ], $opts);

        // list($sW, $sH) = Helper::getScreenSize();
        $width     = (int)$opts['width'];
        $char      = trim($opts['char']);
        $indent    = (int)$opts['indent'] >= 0 ? $opts['indent'] : 2;
        $indentStr = Str::pad(self::CHAR_SPACE, $indent, self::CHAR_SPACE);

        $title   = ucwords(trim($title));
        $tLength = Str::len($title);
        $width   = $width > 10 ? $width : 80;

        // title position
        if ($tLength >= $width) {
            $titleIndent = Str::pad(self::CHAR_SPACE, $indent, self::CHAR_SPACE);
        } elseif ($opts['titlePos'] === self::POS_RIGHT) {
            $titleIndent = Str::pad(self::CHAR_SPACE, ceil($width - $tLength) + $indent, self::CHAR_SPACE);
        } elseif ($opts['titlePos'] === self::POS_MIDDLE) {
            $titleIndent = Str::pad(self::CHAR_SPACE, ceil(($width - $tLength) / 2) + $indent, self::CHAR_SPACE);
        } else {
            $titleIndent = Str::pad(self::CHAR_SPACE, $indent, self::CHAR_SPACE);
        }

        $template  = "%s\n%s%s\n%s";// title topBorder body bottomBorder
        $topBorder = $bottomBorder = '';
        $titleLine = "$titleIndent<bold>$title</bold>";

        $showTBorder = (bool)$opts['topBorder'];
        $showBBorder = (bool)$opts['bottomBorder'];

        if ($showTBorder || $showBBorder) {
            $border = Str::pad($char, $width, $char);

            if ($showTBorder) {
                $topBorder = "{$indentStr}$border\n";
            }

            if ($showBBorder) {
                $bottomBorder = "{$indentStr}$border\n";
            }
        }

        $body = is_array($body) ? implode(PHP_EOL, $body) : $body;
        $body = FormatUtil::wrapText($body, 4, $opts['width']);

        Show::writef($template, $titleLine, $topBorder, $body, $bottomBorder);
    }
}
