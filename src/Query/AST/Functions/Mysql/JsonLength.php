<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

/**
 * "JSON_LENGTH" "(" StringPrimary ")"
 */
class JsonLength extends MysqlJsonFunctionNode
{
	const FUNCTION_NAME = 'JSON_LENGTH';

    /** @var string[] */
    protected $requiredArgumentTypes = [self::STRING_ARG];
}
