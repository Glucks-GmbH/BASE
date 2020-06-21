<?php
/**
 * MySQL
 *
 * @package        BASE
 * @subpackage     MVC
 * @author         Frederik Glücks <frederik@gluecks-gmbh.de>
 * @license        lgpl-3.0
 *
 */

namespace BASE\Database;

use RuntimeException;
use mysqli;

/**
 * Class MySQL
 * @package BASE\Database
 */
class MySQL
{
    /**
     * @var mysqli[] $databaseObjects Array with MySQLi objects of conntected databases
     */
    protected static array $databaseObjects = [];


    /**
     * Creates a MySQLi object for giving database.
     * If a connections already exists the existing object will be returned.
     *
     * The login data is can be stored in the environment variables
     * <pre>
     * - mysqli_host
     * - mysqli_username
     * - mysqli_password
     * </pre>
     *
     * @param string $database Database name
     * @return mysqli
     * @throws RuntimeException
     */
    public static function get(string $database): object
    {
        if (isset(self::$databaseObjects[$database]) and is_a(self::$databaseObjects[$database], 'mysqli')) {
            return self::$databaseObjects[$database];
        } else {
            if (
                !isset($_ENV['mysqli_host']) or empty($_ENV['mysqli_host']) or
                !isset($_ENV['mysqli_username']) or empty($_ENV['mysqli_username']) or
                !isset($_ENV['mysqli_password']) or empty($_ENV['mysqli_password'])
            ) {
                throw new RuntimeException("Failed to use mysql login data from environment variable", E_ERROR);
            } else {
                $host = $_ENV['mysqli_host'];
                $username = $_ENV['mysqli_username'];
                $password = $_ENV['mysqli_password'];

                $mysqliObject = new mysqli($host, $username, $password, $database);
                if ($mysqliObject->connect_errno) {
                    throw new RuntimeException("Failed to connect to MySQL: (" . $mysqliObject->connect_errno . ") " . $mysqliObject->connect_error, E_ERROR);
                } else {
                    self::$databaseObjects[$database] = $mysqliObject;
                    return self::$databaseObjects[$database];
                }
            }
        }
    }

}