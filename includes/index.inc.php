<?php
class DatabaseHelper {
    public static function createConnection( $values=array() ){
        $connString = $values[0];
        $user = $values[1];
        $password = $values[2];
        $pdo = new PDO($connString, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }

    public static function runQuery($connection, $sql, $parameters) {
        $statement = null;
        if(isset($parameters)) {
            if(!is_array($parameters)) {
                $parameters = array($parameters);
            }
            $statement = $connection->prepare($sql);
            $executedOk = $statement->execute($parameters);
            if(!$executedOk) throw new PDOException;
        } else {
            $statement = $connection->query($sql);
            if(!$statement) throw new PDOException;
        }
            return $statement;
    }
}

class CompanyDB {
    private static $baseSQL = 
    "SELECT c.symbol, c.name, c.sector, c.subindustry, c.address, c.exchange, c.website, c.description, c.financials
     FROM companies c";

    private $pdo;

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function getAll() {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getAllForCompany($symbol){
        $sql = self::$baseSQL . " WHERE c.symbol=UPPER(?)";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($symbol));
        return $statement->fetchAll();
    }

    public function getAllForUser($id){
        $sql = self::$baseSQL . " WHERE u.id=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($id));
        return $statement->fetchAll();
    }

    public function getAllForHistory($symbol){
        $sql = self::$baseSQL . " WHERE c.symbol=UPPER(?)";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($symbol));
        return $statement->fetchAll();
        
        $sql = "SELECT * 
        FROM users u
        LEFT JOIN portfolio p ON u.id = p.userid
        LEFT JOIN company c ON p.symbol = c.symbol";

        // "SELECT c.symbol, c.name, c.sector, c.subindustry, c.address, c.exchange, c.website, c.description, c.financials, h.date, h.volume, h.open, h.close, h.high, h.low
        // FROM companies c
        // LEFT JOIN history h ON c.symbol = h.symbol";
    }

    public function getAllForPortfolio($userid){
        $sql = self::$baseSQL . " WHERE p.userid=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($userid));
        return $statement->fetchAll();
    }
}

class HistoryDB {
    private static $baseSQL = "SELECT * FROM history";

    private $pdo;

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function getAll() {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }

    public function getAllForHistory($symbol){
        $sql = self::$baseSQL . " WHERE symbol=UPPER(?)";
        // $sql = $sql . "LIMIT 5";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($symbol));
        return $statement->fetchAll();
    }

    public function getMaxofHistoryHigh($symbol){
        $sql = "SELECT MAX(high) FROM history";
        return $this->getHistory($symbol, $sql);
    }
    public function getMinofHistoryLow($symbol){
        $sql = "SELECT MIN(low) FROM history";
        return $this->getHistory($symbol, $sql);
    }

    public function getTotalofHistoryVolume($symbol){
        $sql = "SELECT TOTAL(volume) FROM history";
        return $this->getHistory($symbol, $sql);
    }

    public function getAverageofHistoryVolume($symbol){
        $sql = "SELECT AVG(volume) FROM history";
        return $this->getHistory($symbol, $sql);
    }

    private function getHistory($symbol, $sqlOld){
        $sql = $sqlOld . " WHERE symbol=?";
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($symbol));
        return $statement->fetchAll();
    }
}

class PortfolioDB {
    private $pdo;

    private static $baseSQL = "SELECT * FROM portfolio";

    private static $portfolioSQL = "SELECT p.symbol symbol, c.name name, c.sector sector, amount, h.close*amount value
        FROM portfolio p
        LEFT JOIN history h ON p.symbol = h.symbol
        LEFT JOIN companies c ON p.symbol = c.symbol
        WHERE h.date = (
            SELECT MAX(h2.date)
            FROM history h2
            WHERE h2.symbol = h.symbol
        ) AND p.userid=?
        ORDER BY value DESC";

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function getPortfolioCount($userid){
        $sql = "SELECT COUNT(id) FROM portfolio WHERE userid=?";
        return $this->getPortfolio($userid, $sql);
    }

    public function getShareCount($userid){
        $sql = "SELECT SUM(amount) FROM portfolio WHERE userid=?";
        return $this->getPortfolio($userid, $sql);
    }

    public function getTotalValue($userid){
        // $sql = "WITH query1 AS (
        //     SELECT MAX(h.date) maxDate, h.symbol
        //     FROM portfolio p
        //     JOIN history h ON p.symbol = h.symbol
        //     WHERE p.userid=?
        //     GROUP BY h.symbol
        // )
        // SELECT SUM(h.close*p.amount) totalValue
        // FROM portfolio p
        // JOIN history h ON p.symbol = h.symbol
        // JOIN query1 q1 
        //     ON h.symbol = q1.symbol 
        //     AND h.date = q1.maxDate";
        $sqlOld = self::$portfolioSQL;
        $sql = "WITH portfolioGroup AS (" . $sqlOld . ") SELECT SUM(value) FROM portfolioGroup";
        return $this->getPortfolio($userid, $sql);
    }
    
    public function getAllForPortfolio($userid){
        $sql = self::$portfolioSQL;
        return $this->getPortfolio($userid, $sql);
    }

    private function getPortfolio($userid, $sql){
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, Array($userid));
        return $statement->fetchAll();
    }

    public function getAll() {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}

class UserDB {
    private $pdo;

    private static $baseSQL = "SELECT id, lastname, firstname FROM users ORDER BY lastname";

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function getAll() {
        $sql = self::$baseSQL;
        $statement = DatabaseHelper::runQuery($this->pdo, $sql, null);
        return $statement->fetchAll();
    }
}
?>