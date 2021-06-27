<?php

class DB extends stdClass
{
    private static $connection;
    public static $in_transaction = FALSE;
    public static $num_queries = 0;
    public static $query_result = FALSE;

    public static function Init($server, $username, $password, $database)
    {

        self::$connection = new mysqli($server, $username, $password, $database);

        if (self::$connection->connect_error) {

            die("Error: Can't connect to the database!");
        }
    }

    /**
     * Execute query
     * @param type $query
     * @param type $transaction
     * @return boolean
     */
    public static function query($query = "", $transaction = FALSE)
    {
        //
        // Remove any pre-existing queries
        //
        self::$query_result = FALSE;
        if ($query != "") {
            self::$num_queries++;
            if ($transaction == "BEGIN_TRANSACTION" && !self::$in_transaction) {
                $result = mysqli_query(self::$connection, "BEGIN");
                if (!$result) {
                    return false;
                }
                self::$in_transaction = TRUE;
            }
            self::$query_result = mysqli_query(self::$connection, $query);
        } else {
            if ($transaction == "END_TRANSACTION" && self::$in_transaction) {
                $result = mysqli_query(self::$connection, "COMMIT");
            }
        }

        if (self::$query_result) {
            if ($transaction == "END_TRANSACTION" && self::$in_transaction) {
                self::$in_transaction = FALSE;
                if (!mysqli_query(self::$connection, "COMMIT")) {
                    mysqli_query(self::$connection, "ROLLBACK");
                    return false;
                }
            }
            return self::$query_result;
        } else {
            if (self::$in_transaction) {
                mysqli_query(self::$connection, "ROLLBACK");
                self::$in_transaction = FALSE;
            }
            return false;
        }
    }

    /**
     * Execute prepared query
     * @param string $query
     * @param array $params
     * @param string $types
     * @param type $transaction
     * @return boolean
     */
    public static function preparedQuery($query, $params, $types, $transaction = FALSE)
    {
        //
        // Remove any pre-existing queries
        //
        self::$query_result = FALSE;
        if ($query != "") {
            self::$num_queries++;
            if ($transaction == "BEGIN_TRANSACTION" && !self::$in_transaction) {
                $result = mysqli_query(self::$connection, "BEGIN");
                if (!$result) {
                    return false;
                }
                self::$in_transaction = TRUE;
            }
            // prepare
            $stmt = self::$connection->prepare($query);

            // check prepare for error
            if(!$stmt){
                print_r(self::$connection->error);
                return false;
            }

            if (count($params)) {
                $stmt->bind_param($types, ...$params);
            }

            // Execute statement
            if ($stmt->execute()) {
                // !!! this returns false on INSERT, UPDATE and DELETE query
                self::$query_result = $stmt->get_result();
                $stmt->close();
                return self::$query_result;
            }

            $stmt->close();
            return false;
        } else {
            if ($transaction == "END_TRANSACTION" && self::$in_transaction) {
                $result = mysqli_query(self::$connection, "COMMIT");
            }
        }

        if (self::$query_result) {
            if ($transaction == "END_TRANSACTION" && self::$in_transaction) {
                self::$in_transaction = FALSE;
                if (!mysqli_query(self::$connection, "COMMIT")) {
                    mysqli_query(self::$connection, "ROLLBACK");
                    return false;
                }
            }
            return self::$query_result;
        } else {
            if (self::$in_transaction) {
                mysqli_query(self::$connection, "ROLLBACK");
                self::$in_transaction = FALSE;
            }
            return false;
        }
    }

    /**
     * Returns the number of rows in the result set. 
     * @param type $query_id  - Result of query
     * @return type
     */
    public static function numRows($query_id = FALSE)
    {
        $query_id = $query_id ? $query_id : self::$query_result;
        return ($query_id) ? mysqli_num_rows($query_id) : false;
    }

    /**
     * Returns the number of rows affected by the last INSERT, UPDATE, REPLACE or DELETE query. 
     * @return int or FALSE
     */
    public static function affectedRows()
    {
        return self::$connection ? mysqli_affected_rows(self::$connection) : false;
    }


    /**
     * Return object or FALSE
     * @param type $query_id - Result of query
     * @param type $className - Class name
     * @param type $constructor_params - Constructor params
     * @return object or FALSE
     */
    public static function fetchObject($query_id = FALSE, $className = "\stdClass", $constructor_params = array())
    {
        $query_id = $query_id ? $query_id : self::$query_result;
        if ($query_id) {
            if ($className == "\stdClass") {
                @$oneObject = mysqli_fetch_object($query_id);
            } else {
                @$oneObject = mysqli_fetch_object($query_id, $className, $constructor_params);
            }
            return @$oneObject;
        } else {
            return false;
        }
    }

    /**
     * Return array with objects or FALSE
     * @param type $query_id - Result of query
     * @param type $field - Field as index in array
     * @param type $className - Class name
     * @param type $constructor_params - Constructor params
     * @return Array with objects or FALSE
     */
    public static function fetchObjectSet($query_id = FALSE, $field = '', $className = "\stdClass", $constructor_params = array())
    {
        $query_id = $query_id ?: self::$query_result;
        if ($query_id) {

            $result = array();
            while ($oneObject = self::fetchObject($query_id, $className, $constructor_params)) {
                if ($field == '') {
                    $result[] = $oneObject;
                } else {
                    $result[$oneObject->$field] = $oneObject;
                }
            }
            if (sizeof($result) > 0) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * The value of the AUTO_INCREMENT field that was updated by the previous query. Returns zero if there was no previous query on the connection or if the query did not update an AUTO_INCREMENT value. 
     * @return int
     */
    public static function nextId()
    {
        return (self::$connection) ? mysqli_insert_id(self::$connection) : false;
    }


    /**
     * call DB::fetchRowSet($query_id, '', $field)
     * @param type $query_id - Result of query
     * @param type $field - Add only this field in array
     * @return array
     */
    public static function fetchIds($query_id = FALSE, $field = 'id')
    {
        return self::fetchObjectSet($query_id, $field);
    }

    public static function mysqliRealEscapeString(&$Value)
    {
        return mysqli_real_escape_string(self::$connection, $Value);
    }

    public static function mysqliRealEscapeStringOnArray(&$theArray)
    {
        if (is_array($theArray)) {
            reset($theArray);
            foreach ($theArray as $Akey => $AVal) {
                if (is_array($AVal)) {
                    self::mysqliRealEscapeStringOnArray($theArray[$Akey]);
                } else {
                    $theArray[$Akey] = mysqli_real_escape_string(self::$connection, $AVal);
                }
            }
            reset($theArray);
        }
    }
}
