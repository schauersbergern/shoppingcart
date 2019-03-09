<?php
class Objectizer {

    function getValueArray($db_result) {
        $array[$db_result->num_rows];
        if ($db_result->num_rows > 0) {
            
            $i = 0;
            while($row = $db_result->fetch_assoc()) {
                
                $myObj = $this->arrayToObject($row);
                $array[$i] = $myObj;
        
                $i++;
            }
        } 
        return $array;
    }

    function arrayToObject($array) {
        $obj = new stdClass();
        foreach ($array as $key => $value) {
            $obj->{$key} = $value;
        }
        return $obj;
    }
}
?>