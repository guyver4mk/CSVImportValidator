<?php


class csvImport
{
    /**
     * Convert a CSV string into an array.
     * 
     * @param $string
     * @param $separatorChar
     * @param $enclosureChar
     * @param $newlineChar
     * @param $skip_rows
     * @return array
     */
    public static function csvstring_to_array($string, $skip_rows = 0, $separatorChar = ',', $enclosureChar = '"', $newlineChar = "\n") {
        // @author: Klemen Nagode 
        // @source: http://stackoverflow.com/questions/1269562/how-to-create-an-array-from-a-csv-file-using-php-and-the-fgetcsv-function
        $array = array();
        $size = strlen($string);
        $columnIndex = 0;
        $rowIndex = 0;
        $fieldValue="";
        $isEnclosured = false;
        for($i=0; $i<$size;$i++) {

            $char = $string{$i};
            $addChar = "";

            if($isEnclosured) {
                if($char==$enclosureChar) {

                    if($i+1<$size && $string{$i+1}==$enclosureChar){
                        // escaped char
                        $addChar=$char;
                        $i++; // dont check next char
                    }else{
                        $isEnclosured = false;
                    }
                }else {
                    $addChar=$char;
                }
            }else {
                if($char==$enclosureChar) {
                    $isEnclosured = true;
                }else {

                    if($char==$separatorChar) {

                        $array[$rowIndex][$columnIndex] = $fieldValue;
                        $fieldValue="";

                        $columnIndex++;
                    }elseif($char==$newlineChar) {
                        echo $char;
                        $array[$rowIndex][$columnIndex] = $fieldValue;
                        $fieldValue="";
                        $columnIndex=0;
                        $rowIndex++;
                    }else {
                        $addChar=$char;
                    }
                }
            }
            if($addChar!=""){
                $fieldValue.=$addChar;

            }
        }

        if($fieldValue) { // save last field
            $array[$rowIndex][$columnIndex] = $fieldValue;
        }


        /**
         * Skip rows. 
         * Returning empty array if being told to skip all rows in the array.
         */ 
        if ($skip_rows > 0) {
            if (count($array) == $skip_rows)
                $array = array();
            elseif (count($array) > $skip_rows)
                $array = array_slice($array, $skip_rows);           

        }

        return $array;
    }


    /**
     * Validate Number of Rows.
     * 
     * @param $row
     * @return array
     */
    public function checkColNums($row)
    {
        $count = count($row);
        
        if($count <= 10)
        {
            return array("return" => "pass", "cols" => $count, "errors" => NULL);
        }
        else
        {
            return array("return" => "error", "cols" => $count, "errors" => "Error: Too Many Columns\n\n");
        }

    }
}
