<?php

namespace app\common;

include_once __DIR__ . '/SqlToHtmlTable.php';


class Db_PostgreSQL
{

    private $db;
    private $pdo;
    private $dsn;
    private $SqlToHtmlTable;

    public function __construct()
    {
        $this->db = array(
            'host' => 'db',
            'db' => 'mydb',
            'user' => 'admin',
            'pass' => 'admin',
            'port' => "5432",

        );
        $this->dsn = "pgsql:host=" . $this->db['host'] . ";
        port=" . $this->db['port'] . ";
        dbname=" . $this->db['db'] . ";
        user=" . $this->db['user'] . ";
        password=" . $this->db['pass'];

        $this->pdo = new PDO($this->dsn);
        $this->connect();
        $this->SqlToHtmlTable = new SqlToHtmlTable();
    }

    private function connect(): void
    {

        try {
            if ($this->pdo) {
                echo "Підключення до бази даних успішне!<br>";

                // Створюємо таблицю, якщо вона не існує
                $this->pdo->exec("CREATE EXTENSION IF NOT EXISTS tablefunc;
CREATE EXTENSION IF NOT EXISTS dict_xsyn;
CREATE EXTENSION IF NOT EXISTS fuzzystrmatch;
CREATE EXTENSION IF NOT EXISTS pg_trgm;
CREATE EXTENSION IF NOT EXISTS cube;");


                $this->pdo->exec('
        CREATE TABLE IF NOT EXISTS genres (
            name text UNIQUE, position integer
                                          );
        CREATE TABLE IF NOT EXISTS movies (
            movie_id SERIAL PRIMARY KEY, 
            title text, genre cube  
        );  
        CREATE TABLE  IF NOT EXISTS actors (
            actor_id SERIAL PRIMARY KEY, 
            name text  
        ); 
        CREATE TABLE IF NOT EXISTS movies_actors (
            movie_id integer REFERENCES movies NOT NULL, 
            actor_id integer REFERENCES actors NOT NULL, 
            UNIQUE (movie_id, actor_id)  
        ); 
        CREATE INDEX IF NOT EXISTS movies_actors_movie_id ON movies_actors (movie_id); 
        CREATE INDEX IF NOT EXISTS movies_actors_actor_id ON movies_actors (actor_id);
        CREATE INDEX IF NOT EXISTS movies_title_trigram ON movies USING gist (title gist_trgm_ops); 
        CREATE INDEX IF NOT EXISTS movies_genres_cube ON movies USING gist (genre); '
                );
            } else {
                echo "Помилка extension!<br>";
                die();
            }
        } catch (PDOException $e) {
            echo "Помилка підключення до бази даних: " . $e->getMessage();
            die();
        }

    }

    public function fetchQuery($sql)
    {

        $response = $this->pdo->query($sql)->fetchAll();
        if ($response) {
            $html = $this->SqlToHtmlTable->generateTable($response);
            return $html;
        }

    }

    public function rawQuery($sql)
    {
        return $this->pdo->query($sql);
    }

}
