<?php declare(strict_types=1);

namespace Swoft\Console\Advanced\Formatter;

use Swoft\Console\Advanced\MessageFormatter;
use Swoft\Console\Helper\Show;
use Swoft\Stdlib\Helper\Str;
use Swoft\Stdlib\StrBuffer;
use Toolkit\Cli\ColorTag;
use function array_keys;
use function array_merge;
use function array_sum;
use function ceil;
use function count;
use function is_string;
use function ucwords;

/**
 * Class Table - Tabular data display
 * @package Swoft\Console\Advanced\Formatter
 */
class Table extends MessageFormatter
{
    /** @var array */
    public $data = [];

    /** @var array */
    public $columns = [];

    /** @var string|array */
    public $body;

    /** @var string */
    public $title = '';

    /** @var string */
    public $titleBorder = '-';

    /** @var string */
    public $titleStyle = '-';

    /** @var string */
    public $titleAlign = self::ALIGN_LEFT;

    /**
     * Tabular data display
     *
     * @param  array  $data
     * @param  string $title
     * @param  array  $opts
     * @example
     *
     * ```php
     * // like from database query's data.
     * $data = [
     *  [ col1 => value1, col2 => value2, col3 => value3, ... ], // first row
     *  [ col1 => value4, col2 => value5, col3 => value6, ... ], // second row
     *  ... ...
     * ];
     * Show::table($data, 'a table');
     *
     * // use custom head
     * $data = [
     *  [ value1, value2, value3, ... ], // first row
     *  [ value4, value5, value6, ... ], // second row
     *  ... ...
     * ];
     * $opts = [
     *   'showBorder' => true,
     *   'columns' => [col1, col2, col3, ...]
     * ];
     * Show::table($data, 'a table', $opts);
     * ```
     * @return int
     */
    public static function show(array $data, string $title = 'Data Table', array $opts = []): int
    {
        if (!$data) {
            return -2;
        }

        $buf  = new StrBuffer();
        $opts = array_merge([
            'showBorder'     => true,
            'leftIndent'     => '  ',
            'titlePos'       => self::POS_LEFT,
            'titleStyle'     => 'bold',
            'headStyle'      => 'comment',
            'headBorderChar' => self::CHAR_EQUAL,   // default is '='
            'bodyStyle'      => '',
            'rowBorderChar'  => self::CHAR_HYPHEN,   // default is '-'
            'colBorderChar'  => self::CHAR_VERTICAL, // default is '|'
            'columns'        => [],                  // custom column names
        ], $opts);

        $hasHead       = false;
        $rowIndex      = 0;
        $head          = [];
        $tableHead     = $opts['columns'];
        $leftIndent    = $opts['leftIndent'];
        $showBorder    = $opts['showBorder'];
        $rowBorderChar = $opts['rowBorderChar'];
        $colBorderChar = $opts['colBorderChar'];

        $info = [
            'rowCount'       => count($data),
            'columnCount'    => 0,     // how many column in the table.
            'columnMaxWidth' => [], // table column max width
            'tableWidth'     => 0,      // table width. equals to all max column width's sum.
        ];

        // parse table data
        foreach ($data as $row) {
            // collection all field name
            if ($rowIndex === 0) {
                $head = $tableHead ?: array_keys($row);
                //
                $info['columnCount'] = count($row);

                foreach ($head as $index => $name) {
                    if (is_string($name)) {// maybe no column name.
                        $hasHead = true;
                    }

                    $info['columnMaxWidth'][$index] = Str::len($name, 'UTF-8');
                }
            }

            $colIndex = 0;

            foreach ((array)$row as $value) {
                // collection column max width
                if (isset($info['columnMaxWidth'][$colIndex])) {
                    $colWidth = Str::len($value, 'UTF-8');

                    // If current column width gt old column width. override old width.
                    if ($colWidth > $info['columnMaxWidth'][$colIndex]) {
                        $info['columnMaxWidth'][$colIndex] = $colWidth;
                    }
                } else {
                    $info['columnMaxWidth'][$colIndex] = Str::len((string)$value, 'UTF-8');
                }

                $colIndex++;
            }

            $rowIndex++;
        }

        $tableWidth  = $info['tableWidth'] = array_sum($info['columnMaxWidth']);
        $columnCount = $info['columnCount'];

        // output title
        if ($title) {
            $tStyle      = $opts['titleStyle'] ?: 'bold';
            $title       = ucwords(trim($title));
            $titleLength = Str::len($title, 'UTF-8');
            $padLength   = ceil($tableWidth / 2) - ceil($titleLength / 2) + ($columnCount * 2);
            $indentSpace = Str::pad(' ', (int)$padLength, ' ');
            $buf->write("  {$indentSpace}<$tStyle>{$title}</$tStyle>\n");
        }

        $border = $leftIndent . Str::pad($rowBorderChar, $tableWidth + ($columnCount * 3) + 2, $rowBorderChar);

        // output table top border
        if ($showBorder) {
            $buf->write($border . "\n");
        } else {
            $colBorderChar = '';// clear column border char
        }

        // output table head
        if ($hasHead) {
            $headStr = "{$leftIndent}{$colBorderChar} ";

            foreach ($head as $index => $name) {
                $colMaxWidth = $info['columnMaxWidth'][$index];
                // format
                $name    = Str::pad($name, $colMaxWidth, ' ');
                $name    = ColorTag::wrap($name, $opts['headStyle']);
                $headStr .= " {$name} {$colBorderChar}";
            }

            $buf->write($headStr . "\n");

            // head border: split head and body
            if ($headBorderChar = $opts['headBorderChar']) {
                $headPadLen = $tableWidth + ($columnCount * 3) + 2;
                $headBorder = Str::pad($headBorderChar, $headPadLen, $headBorderChar);
                $buf->write($leftIndent . $headBorder . "\n");
            }
        }

        $rowIndex = 0;

        // output table info
        foreach ($data as $row) {
            $colIndex = 0;
            $rowStr   = "  $colBorderChar ";

            foreach ((array)$row as $value) {
                $colMaxWidth = $info['columnMaxWidth'][$colIndex];
                // format
                $value  = Str::pad((string)$value, $colMaxWidth, ' ');
                $value  = ColorTag::wrap($value, $opts['bodyStyle']);
                $rowStr .= " {$value} {$colBorderChar}";
                $colIndex++;
            }

            $buf->write($rowStr . "\n");
            $rowIndex++;
        }

        // output table bottom border
        if ($showBorder) {
            $buf->write($border . "\n");
        }

        return Show::write($buf);
    }
}
