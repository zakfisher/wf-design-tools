<?php
class DB {
    function __construct() {}

    private function query($query)
    {
        global $db;
        //print $query; exit;
        $result_set = mysqli_query($db, $query) or die("Error at resultset" . mysqli_error($db));
        if (!$result_set) return array('error' => '#1 Invalid query: ' . mysqli_error($db));
        return $result_set;
    }

    function insert_into($table, $assoc_array)
    {
        global $db;
        // Compose INSERT INTO Query
        foreach ($assoc_array as $key => $value)
        {
            $values[] = "'" . $db->real_escape_string($value) . "'";
            $properties[] = $key;
        }
        $properties = implode(",", $properties);
        $values = implode(",", $values);
        $query = "INSERT INTO " . $table . " (" . $properties . ") VALUES(" . $values . ");";

        // Execute Query
        return $this->query($query);
    }

    function select_from($array, $table, $limit = 0) {
        // Compose SELECT x FROM Query
        $values = implode(",", $array);
        $query = "SELECT " . $values . " FROM " . $table;
        $query .= ($limit > 0) ? (" LIMIT " . $limit) : "";
        $query .= ";";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

    function select_from_order_by($array, $table, $field)
    {
        // Compose SELECT x FROM Query
        $values = implode(",", $array);
        $query = "SELECT " . $values . " FROM " . $table . " ORDER BY " . $field . ";";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

    function select_from_group_by($array, $table, $field)
    {
        // Compose SELECT x FROM Query
        $values = implode(",", $array);
        $query = "SELECT " . $values . " FROM " . $table . " GROUP BY " . $field . ";";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

    function select_from_where($array, $table, $column, $value)
    {
        // Compose SELECT x FROM y WHERE Query
        $values = implode(",", $array);
        $query = "SELECT " . $values . " FROM " . $table . " WHERE " . $column . " = '" . $value . "';";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

    function select_from_where_order_by($array, $table, $column, $value, $field)
    {
        // Compose SELECT x FROM y WHERE Query
        $values = implode(",", $array);
        $query = "SELECT " . $values . " FROM " . $table . " WHERE " . $column . " = '" . $value . "' ORDER BY " . $field . ";";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

    function select_from_where_and($array, $table, $column1, $value1, $column2, $value2)
    {
        // Compose SELECT x FROM y WHERE Query
        $values = implode(",", $array);
        $query = "SELECT " . $values . " FROM " . $table . " WHERE " . $column1 . " = '" . $value1 . "' AND " . $column2 . " = '" . $value2 . "';";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

    function select_from_where_or($array, $table, $column1, $value1, $column2, $value2, $limit) {
        // Compose SELECT x FROM y WHERE Query
        $values = implode(",", $array);
        $query = "SELECT " . $values . " FROM " . $table . " WHERE " . $column1 . " = '" . $value1 . "' OR " . $column2 . " = '" . $value2 . "'";
        $query .= ($limit > 0) ? (" LIMIT " . $limit) : "";
        $query .= ";";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

    function select_from_where_or_or($array, $table, $column1, $value1, $column2, $value2, $column3, $value3, $limit) {
        // Compose SELECT x FROM y WHERE Query
        $values = implode(",", $array);
        $query = "SELECT " . $values . " FROM " . $table . " WHERE " . $column1 . " = '" . $value1 . "' OR " . $column2 . " = '" . $value2 . "' OR " . $column3 . " = '" . $value3 . "'";
        $query .= ($limit > 0) ? (" LIMIT " . $limit) : "";
        $query .= ";";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

    function update_where($table, $assoc_array, $column, $value)
    {
        global $db;
        // Compose UPDATE Query
        foreach ($assoc_array as $key => $val)
        {
            $new_values[] = $key . " = '" . $db->real_escape_string($val) . "'";
        }
        $new_values = implode(",", $new_values);
        $query = "UPDATE " . $table . " SET " . $new_values . " WHERE " . $column . " = " . $value . ";";

        // Execute Query
        $this->query($query);

        return true;
    }

    function delete_from_where($table, $column, $value)
    {
        // Compose DELETE Query
        $query = "DELETE FROM " . $table . " WHERE " . $column . " = " . $value . ";";

        // Execute Query
        $this->query($query);

        return true;
    }

    function get_last_row($table, $column)
    {
        $query = "SELECT * FROM " . $table . " WHERE " . $column . " = (SELECT MAX(" . $column . ") FROM " . $table . ");";

        // Execute Query
        $result_set = $this->query($query);

        // Return Results
        while ($row = mysqli_fetch_array($result_set, MYSQL_ASSOC)) $rows[] = $row;
        return $rows;
    }

}