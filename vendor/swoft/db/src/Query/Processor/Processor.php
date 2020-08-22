<?php declare(strict_types=1);

namespace Swoft\Db\Query\Processor;

use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\Exception\DbException;
use Swoft\Db\Query\Builder;

/**
 * Class Processor
 *
 * @since 2.0
 *
 * @Bean()
 */
class Processor
{
    /**
     * Process the results of a "select" query.
     *
     * @param Builder $query
     * @param array   $results
     *
     * @return array
     */
    public function processSelect(Builder $query, $results): array
    {
        return $results;
    }

    /**
     * Process an  "insert get ID" query.
     *
     * @param Builder $query
     * @param string  $sql
     * @param array   $values
     * @param string  $sequence
     *
     * @return string
     * @throws DbException
     */
    public function processInsertGetId(Builder $query, $sql, $values, string $sequence = null): string
    {
        return $query->getConnection()->insertGetId($sql, $values, $sequence);
    }

    /**
     * Process the results of a column listing query.
     *
     * @param array $results
     *
     * @return array
     */
    public function processColumnListing($results)
    {
        return $results;
    }
}
