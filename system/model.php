<?php

class Model {

    private $connection;

    public function __construct()
    {
        global $config;
        
        $this->connection = mysql_pconnect($config['db_host'], $config['db_username'], $config['db_password']) or die('MySQL Error: '. mysql_error());
        mysql_select_db($config['db_name'], $this->connection);
    }

    public function escapeString($string)
    {
        return mysql_real_escape_string($string);
    }

    public function escapeArray($array)
    {
         array_walk_recursive($array, create_function('&$v', '$v = mysql_real_escape_string($v);'));
        return $array;
    }
    
    public function to_bool($val)
    {
         return !!$val;
    }
    
    public function to_date($val)
    {
         return date('Y-m-d', $val);
    }
    
    public function to_time($val)
    {
         return date('H:i:s', $val);
    }
    
    public function to_datetime($val)
    {
         return date('Y-m-d H:i:s', $val);
    }
    
    public function query($qry)
    {
        $result = mysql_query($qry) or die('MySQL Error: '. mysql_error());
        $resultObjects = array();

        while($row = mysql_fetch_object($result)) $resultObjects[] = $row;

        return $resultObjects;
    }

    public function execute($qry)
    {
        $exec = mysql_query($qry) or die('MySQL Error: '. mysql_error());
        return $exec;
    }

    /*
        Returns entries in the database that match the options specified.
        Options may be:
            fields => array - array of fields to return
            field => value - insert a where clause for field = value. If value
                             is an array the where where clause is an 'in'.
    */
    public function find($options = array())
    {
        // Extract the fields.
        $fieldsString = '*';
        if (isset($options['fields']) &&
            is_array($options['fields']) &&
            count($options['fields']) > 0)
        {
            $fields = $options['fields'];
            $fieldsString = implode(',', $fields);
        }
        unset($options['fields']);

        // Extract any conditions.
        $whereString = "";
        foreach ($options as $field => $value)
        {
            if (empty($whereString))
            {
                $whereString = "WHERE ";
            }
            else
            {
                $whereString .= " AND ";
            }

            $whereString .= "$field ";
            if (is_array($value))
            {
                $whereString .= "IN (";
                $whereString .= implode(',', $value);
                $whereString .= ")";
            }
            else
            {
                if (is_string($value))
                {
                    $whereString .= "= '$value'";
                }
                else
                {
                    $whereString .= "= $value";
                }
            }
        }

        $table = strtolower(get_class($this))."s";
        $query = "SELECT $fieldsString FROM $table $whereString";
        return $this->query($query);
    }

    /*
        Returns all entries in the database for this table. Returns the
        specified fields or all fields if $fields is empty.
    */
    public function findAll($fields = array())
    {
        $options = array('fields' => $fields);
        return $this->find($options);
    }

    /*
        Inserts a new entry into the table, using fields and values from $fields.
    */
    public function insert($fields)
    {
        // Construct a comma separated list of fields, and a comma separated list
        // of field values.
        $fieldsString = "";
        $valuesString = "";
        $count = 0;
        foreach ($fields as $key => $value)
        {
            if ($count > 0)
            {
                $fieldsString = $fieldsString.', ';
                $valuesString = $valuesString.', ';
            }

            $fieldsString = $fieldsString.$key;
            if (is_string($value))
            {
                // Strings are wrapped in quotes.
                $valuesString = $valuesString."'$value'";
            }
            else
            {
                $valuesString = $valuesString.$value;
            }

            $count++;
        }

        $table = strtolower(get_class($this))."s";
        $query = "INSERT INTO $table ($fieldsString) VALUES ($valuesString);";
        return $this->execute($query);
    }

    /*
        Removes rows where $field matches the array of $values.
    */
    public function delete($field, $values)
    {
        // Wrap strings in quotes.
        $values = array_map(function($n) { return is_string($n) ? "'$n'" : $n; }, $values);

        // Turn the values into a single comma separated string.
        $valuesString = implode(',', $values);

        $table = strtolower(get_class($this))."s";
        $query = "DELETE FROM $table WHERE $field IN ($valuesString)";
        return $this->execute($query);
    }
}
?>
