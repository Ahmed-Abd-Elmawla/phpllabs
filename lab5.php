class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $conn;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect() {
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function insert($table, $columns, $values) {
        $columns = implode(",", $columns);
        $values = implode("','", $values);
        $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
        if (mysqli_query($this->conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function select($table) {
        $sql = "SELECT * FROM $table";
        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $rows = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
            return $rows;
        } else {
            return false;
        }
    }

    public function update($table, $id, $fields) {
        $set = array();
        foreach ($fields as $key => $value) {
            $set[] = "$key='$value'";
        }
        $set = implode(",", $set);
        $sql = "UPDATE $table SET $set WHERE id=$id";
        if (mysqli_query($this->conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id=$id";
        if (mysqli_query($this->conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function __destruct() {
        mysqli_close($this->conn);
    }
}
