<?php
class Connection extends PDO {
    private $con;

    public function __construct ()
    {
        try {
            $this->con = parent::__construct($this->getDns(), $this->getUser(), 
                    $this->getPassword());
            if ($this->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql')
                $this->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->exec('SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->con;
        } catch (PDOException $e) {
            die('Serveur de BDD indisponible <br> ' . $e->getMessage());
        }
    }

    public function select ($reqSelect)
    {
        try {
            $this->con = parent::beginTransaction();
            $result = parent::prepare($reqSelect);
            $result->execute();
            $this->con = parent::commit();
           
            return $result;
        } catch (Exception $e) {
            $this->con = parent::rollBack();
           die( $e->getMessage());
        }
    }
    
    public function selectTableau ($reqSelect)
    {
        $result = parent::prepare($reqSelect);
        $result->execute();

        $resultat = $result->fetchAll();
        return $resultat;
    }
    
    private function getDns ()
    {
        return $this->getDriver().':dbname=' . $this->getDB() . ';host=' . $this->getHost();
    }
    
    private function getDB() {
		return getenv("DB_NAME");
	}
	
	private function getHost() {
		return getenv("DB_HOST");
	}
	
	private function getDriver() {
		return getenv("DB_DRIVER");
	}
	
	private function getUser() {
		return getenv("DB_USER");
	}
	
	private function getPassword() {
		return getenv("DB_PASSWD");
	}
}
