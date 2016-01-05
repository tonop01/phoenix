<?php

namespace Phoenix\QueryBuilder;

use InvalidArgumentException;

class Index
{
    const TYPE_NORMAL = '';
    const TYPE_UNIQUE = 'UNIQUE';
    const TYPE_FULLTEXT = 'FULLTEXT';
    
    const METHOD_DEFAULT = '';
    const METHOD_BTREE = 'BTREE';
    const METHOD_HASH = 'HASH';
    
    private $columns = [];
    
    private $type;
    
    private $method;
    
    public function __construct($columns, $type = self::TYPE_NORMAL, $method = self::METHOD_DEFAULT)
    {
        $this->type = strtoupper($type);
        if (!in_array($this->type, [self::TYPE_NORMAL, self::TYPE_UNIQUE, self::TYPE_FULLTEXT])) {
            throw new InvalidArgumentException('Index type "' . $type . '" is not allowed');
        }
        
        $this->method = strtoupper($method);
        if (!in_array($this->method, [self::METHOD_DEFAULT, self::METHOD_BTREE, self::METHOD_HASH])) {
            throw new InvalidArgumentException('Index method "' . $method . '" is not allowed');
        }
        
        if (is_array($columns)) {
            $this->columns = $columns;
        } elseif (is_string($columns)) {
            $this->columns[] = $columns;
        }
    }
    
    public function getName()
    {
        return implode('_', $this->columns);
    }
    
    public function getColumns()
    {
        return $this->columns;
    }
    
    public function getType()
    {
        return $this->type ? $this->type . ' INDEX' : 'INDEX';
    }
    
    public function getMethod()
    {
        return $this->method ? 'USING ' . $this->method : '';
    }
}
