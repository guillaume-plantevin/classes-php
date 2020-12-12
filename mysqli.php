<?php

class my_mysqli extends mysqli
{
    public function prepared_query($sql, $params, $types = "")
    {
        $types = $types ?: str_repeat("s", count($params));
        $stmt = $this->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt;
    }
    function prepared_select($sql, $params = [], $types = "")
    {
        return $this->prepared_query($sql, $params, $types)->get_result();
    }
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    require __DIR__.'/db_credentials.php';
    $db = new my_mysqli($host, $user, $pass, $db, $port);
    $db->set_charset($charset);
} catch (\mysqli_sql_exception $e) {
     throw new \mysqli_sql_exception($e->getMessage(), $e->getCode());
} finally {
    unset($host, $db, $user, $pass, $charset);
}