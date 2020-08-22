<?php declare(strict_types=1);

namespace Swoft\Console\Advanced\Formatter;

use Swoft\Console\Advanced\MessageFormatter;
use Swoft\Console\Console;
use Swoft\Console\Helper\FormatUtil;
use Toolkit\Cli\ColorTag;
use function array_merge;
use function trim;
use function ucwords;
use const PHP_EOL;

/**
 * Class SingleList - Format and render a single list
 * @package Swoft\Console\Advanced\Formatter
 */
class SingleList extends MessageFormatter
{
    /**
     * Format and render a single list
     *
     * ```php
     * $title = 'list title';
     * $data = [
     *      'name'  => 'value text',
     *      'name2' => 'value text 2',
     * ];
     * ```
     *
     * @param array  $data
     * @param string $title
     * @param array  $opts More {@see FormatUtil::spliceKeyValue()}
     * @return int|string
     */
    public static function show($data, string $title = '', array $opts = [])
    {
        $string = '';
        $opts   = array_merge([
            'leftChar'    => '  ',
            // 'sepChar' => '  ',
            'keyStyle'    => 'info',
            'keyMinWidth' => 8,
            'titleStyle'  => 'comment',
            'returned'    => false,
            'ucFirst'     => false,
            'lastNewline' => true,
        ], $opts);

        // title
        if ($title) {
            $title  = ucwords(trim($title));
            $string .= ColorTag::wrap($title, $opts['titleStyle']) . PHP_EOL;
        }

        // handle item list
        $string .= FormatUtil::spliceKeyValue((array)$data, $opts);

        // return formatted string.
        if ($opts['returned']) {
            return $string;
        }

        return Console::write($string, $opts['lastNewline']);
    }
}
