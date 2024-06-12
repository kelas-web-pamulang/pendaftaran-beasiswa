<?php

class ConfigDB
{
    private $host = 'localhost';
    private $db_name = 'database_beasiswa';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    public function close() {
        $this->conn->close();
    }

    public function select($table, $where = [])
    {
        $query = "SELECT id_beasiswa, nama_beasiswa, id_program_studi, id_kategori, kuota, tanggal_hapus_data FROM $table where tanggal_hapus_data is null";

        foreach ($where as $key => $value) {
            $query .= " $key '$value'";
        }

        $result = $this->conn->query($query);

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function update($table, $data, $id)
    {
        $tanggal_perbarui_data = date('Y-m-d H:i:s');
        $query = "UPDATE $table SET ";
        foreach ($data as $key => $value) {
            $query .= "$key = '$value', ";
        }
        $query .= "tanggal_perbarui_data = '$tanggal_perbarui_data' WHERE id_beasiswa='$id'";

        return $this->conn->query($query);
    }
}