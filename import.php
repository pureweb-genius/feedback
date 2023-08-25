<?php


  $config = require 'application/config/db.php';
  $connection = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'', $config['user'], $config['password']);



# read file into array
        $file = file('db.sql');

        # import file line by line
        # and filter (remove) those lines, beginning with an sql comment token
        $file = array_filter($file,
            function($line){
                return strpos(ltrim($line), "--") !== 0;
        });

        # and filter (remove) those lines, beginning with an sql notes token
        $file = array_filter($file,
            function($line){
                return strpos(ltrim($line), "/*") !== 0;});
        $sql = "";
        $del_num = false;
        foreach($file as $line){
            $query = trim($line);
            try
            {
                $delimiter = is_int(strpos($query, "DELIMITER"));
                if($delimiter || $del_num){
                    if($delimiter && !$del_num ){
                        $sql = "";
                        $sql = $query."; ";
                        echo "OK";
                        echo "<br/>";
                        echo "---";
                        echo "<br/>";
                        $del_num = true;
                    }else if($delimiter && $del_num){
                        $sql .= $query." ";
                        $del_num = false;
                        echo $sql;
                        echo "<br/>";
                        echo "do---do";
                        echo "<br/>";
                        $connection->exec($sql);
                        $sql = "";
                    }else{
                        $sql .= $query."; ";
                    }
                }else{
                    $delimiter = is_int(strpos($query, ";"));
                    if($delimiter){
                        $connection->exec("$sql $query");
                        echo "$sql $query";
                        echo "<br/>";
                        echo "---";
                        echo "<br/>";
                        $sql = "";
                    }else{
                        $sql .= " $query";
                    }
                }
            }
            catch (\Exception $e)
            {
                echo $e->getMessage() . "<br /> <p>The sql is: $query</p>";
            }



}

?>