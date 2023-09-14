<?php

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

const PATH_MIGRATIONS_SQL_FILES = __DIR__ . '/../db/migrations/';
const CREATE_MIGRATION_HISTORY = __DIR__ . '/../db/create_migrations_history.sql';

const MIGRATIONS_FILES = [
    PATH_MIGRATIONS_SQL_FILES . '001_create_table_authors.sql',
    PATH_MIGRATIONS_SQL_FILES . '002_create_table_books_authors.sql',
    PATH_MIGRATIONS_SQL_FILES . '003_ data_author_migration.sql',
    PATH_MIGRATIONS_SQL_FILES . '004_book_author_relation.sql',
    PATH_MIGRATIONS_SQL_FILES . '005_drop_author_column.sql'
];

const CHECK_EXECUTED = "SELECT * FROM migration_history WHERE migration_name = ?";
const INSERT_MIGRATION = "INSERT INTO migration_history (migration_name, executed_at) VALUES (?, NOW())";

function callMigrations()
{
    try {
        $db = \App\Models\ConnectDB::getInstance();

        $createTableMigrationsQuery = file_get_contents(CREATE_MIGRATION_HISTORY);
        $db->query($createTableMigrationsQuery);

        foreach (MIGRATIONS_FILES as $file) {
            $stmtCheckExec = $db->prepare(CHECK_EXECUTED);
            $stmtCheckExec->bind_param("s", $file);
            $stmtCheckExec->execute();

            $checkExecute = $stmtCheckExec->get_result();

            if ($checkExecute->num_rows !== 1) {
                // exec migrations
                $migrationQuery = file_get_contents($file);
                $db->query($migrationQuery);

                $stmtInsertExec = $db->prepare(INSERT_MIGRATION);
                $stmtInsertExec->bind_param("s", $file);
                $stmtInsertExec->execute();
                $stmtInsertExec->close();
            }

            $stmtCheckExec->close(); 
        }

    } catch (\Exception $e) {
        http_response_code(500);
        require_once(__DIR__ . '/../views/error.php');
    }

}

?>

