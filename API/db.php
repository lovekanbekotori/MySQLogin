<?php

class DB
{
    private $host = '';
    private $user = '';
    private $password = '';
    private $database = '';

    /**
     * Initialize a PDO instance.
     *
     * @return PDO
     */
    public static function connect()
    {
        try {
            $db = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->database);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            return false;
        }

        return $db;
    }

    /**
     * Execute a query.
     *
     * @param  PDOStatement  $query  The query
     * @param  array  $arguments  Arguments to be added for prepared statements
     *
     * @return mixed
     */
    public static function execute($query, $arguments)
    {
        try {
            $query->execute($arguments);
        } catch (PDOException $e) {
            // This needs to be improved.
            die();
        }

        return $query;
    }
}
