<?php
    function mysqli_query_or_throw_error($con, $sql_query) {
        $query=mysqli_query($con, $sql_query);
        if (!$query) {
            throw new Exception(mysqli_error($con)."[ $sql_query]");
        }
        return $query;
    }
?>