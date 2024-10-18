<?php
require __DIR__ . '/vendor/autoload.php';

use app\common\Db_PostgreSQL;



include_once __DIR__ . '/common/posgress_db.php';

function PostgreSQL()
{

    $Db_PostgreSQL = new Db_PostgreSQL();
    echo '<h2>ILIKE</h2>';
    echo $Db_PostgreSQL -> fetchQuery("SELECT title FROM movies WHERE title ILIKE 'Star Trek%';");
    echo '<h2>Регулярні вирази </h2>';
    echo '<pre>';
    print_r($Db_PostgreSQL -> rawQuery("SELECT COUNT(*) FROM movies WHERE title !~* '^the.';") -> fetchAll());
    echo '</pre>';
    echo '<h2>Відстань Левенштейна </h2>';
    echo '<pre>';
    print_r($Db_PostgreSQL -> fetchQuery("SELECT movie_id, title FROM movies WHERE levenshtein(lower(title), lower('ghost')) <= 3;"));
    echo '</pre>';
    echo '<h2>Триграми </h2>';
    echo '<pre>';
    print_r($Db_PostgreSQL -> fetchQuery("SELECT show_trgm('Star');"));
    echo '</pre>';
    echo '<h2>Повнотекстовий пошук за лексемами </h2>';
    echo '<pre>';
    print_r($Db_PostgreSQL -> fetchQuery("SELECT title FROM movies WHERE title @@ 'The Kill';"));
    echo '</pre>';
    echo '<h2>Метафони </h2>';
    echo '<pre>';
    print_r($Db_PostgreSQL -> fetchQuery("SELECT * 
FROM movies 
JOIN movies_actors ON movies.movie_id = movies_actors.movie_id 
JOIN actors ON movies_actors.actor_id = actors.actor_id 
WHERE metaphone(actors.name, 6) = metaphone('Cameron Diaz', 6);"));
    echo '</pre>';
}



PostgreSQL();





