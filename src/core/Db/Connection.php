<?php

namespace Db;

/**
 * Database connection
 *
 * @author Inchoo
 */
class Connection
{
    /**
     * @var Connection|null
     */
    private static $instance = null;

    /**
     * @var \Pdo|null
     */
    private $db = null;

    private $config = [];

    /**
     * Connection constructor.
     * @param string[] $config
     */
    private function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Returns the singleton instance
     *
     * @param string[] $config
     * @return Connection
     */
    public static function getInstance($config): Connection
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    /**
     * Returns the PDO instance
     *
     * @return \PDO
     */
    public function getDb(): \PDO
    {
        if ($this->db === null) {

            $dsn = 'mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['name'] . ';charset=utf8';

            $this->db = new \PDO(
                $dsn,
                $this->config['user'],
                $this->config['pass']
            );

            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }

        return $this->db;
    }
}
