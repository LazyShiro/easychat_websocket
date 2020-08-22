<?php

namespace Swoft\Db\Schema;

use Swoft\Stdlib\Fluent;

/**
 * @method ColumnDefinition after(string $column) place the column "after" another column (MySQL)
 * @method ColumnDefinition always() Used as a modifier for generatedAs() (PostgreSQL)
 * @method ColumnDefinition autoIncrement() Set INTEGER columns as auto-increment (primary key)
 * @method ColumnDefinition charset(string $charset) Specify a character set for the column (MySQL)
 * @method ColumnDefinition collation(string $collation) Specify a collation for the column (MySQL/SQL Server)
 * @method ColumnDefinition comment(string $comment) Add a comment to the column (MySQL)
 * @method ColumnDefinition default(mixed $value) Specify a "default" value for the column
 * @method ColumnDefinition first() Place the column "first" in the table (MySQL)
 * @method ColumnDefinition generatedAs(string $expression) Create a SQL compliant identity column (PostgreSQL)
 * @method ColumnDefinition index(string $indexName = null) Add an index
 * @method ColumnDefinition nullable(bool $value = true) Allow NULL values to be inserted into the column
 * @method ColumnDefinition primary() Add a primary index
 * @method ColumnDefinition spatialIndex() Add a spatial index
 * @method ColumnDefinition storedAs(string $expression) Create a stored generated column (MySQL)
 * @method ColumnDefinition unique() Add a unique index
 * @method ColumnDefinition unsigned() Set the INTEGER column as UNSIGNED (MySQL)
 * @method ColumnDefinition useCurrent() Set the TIMESTAMP column to use CURRENT_TIMESTAMP as default value
 * @method ColumnDefinition virtualAs(string $expression) Create a virtual generated column (MySQL)
 * @method ColumnDefinition persisted() Mark the computed generated column as persistent (SQL Server)
 */
class ColumnDefinition extends Fluent
{
    //
}
