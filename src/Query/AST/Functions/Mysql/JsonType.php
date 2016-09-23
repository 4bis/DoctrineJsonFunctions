<?php

namespace Syslogic\DoctrineJsonFunctions\Query\AST\Functions\Mysql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "JSON_TYPE" "(" StringPrimary ")"
 */
class JsonType extends FunctionNode
{
	const FUNCTION_NAME = 'JSON_TYPE';

	/**
	 * @var \Doctrine\ORM\Query\AST\Node
	 */
	public $jsonDocExpr;

	/**
	 * @param SqlWalker $sqlWalker
	 * @return string
	 * @throws DBALException
	 */
	public function getSql(SqlWalker $sqlWalker)
	{
		$jsonDoc = $sqlWalker->walkStringPrimary($this->jsonDocExpr);

		if ($sqlWalker->getConnection()->getDatabasePlatform() instanceof MySqlPlatform)
		{
			return sprintf('%s(%s)', static::FUNCTION_NAME, $jsonDoc);
		}

		throw DBALException::notSupported(static::FUNCTION_NAME);
	}

	/**
	 * @param Parser $parser
	 * @throws \Doctrine\ORM\Query\QueryException
	 */
	public function parse(Parser $parser)
	{
		$parser->match(Lexer::T_IDENTIFIER);
		$parser->match(Lexer::T_OPEN_PARENTHESIS);

		$this->jsonDocExpr = $parser->StringPrimary();

		$parser->match(Lexer::T_CLOSE_PARENTHESIS);
	}
}
