<?php
/*
 *Insert data in database
 * @param string $table
 * @param array $data
 * @return array as assoc
 * */
function db_create($table, array $data): array
{
    global $connect;

    // Escape data
    $columns = array_keys($data);
    $escaped_values = array_map(function ($value) use ($connect) {
        return "'" . mysqli_real_escape_string($connect, $value) . "'";
    }, array_values($data));

    // Build WHERE condition for unique columns
    $uniqueColumns = ['name', 'email']; // الأعمدة التي تحتوي على قيد UNIQUE
    $conditions = [];
    foreach ($uniqueColumns as $col) {
        if (isset($data[$col])) {
            $conditions[] = sprintf("%s = '%s'", $col, mysqli_real_escape_string($connect, $data[$col]));
        }
    }

    if (!empty($conditions)) {
        $checkQuery = sprintf(
            "SELECT * FROM %s WHERE %s",
            $table,
            implode(" OR ", $conditions)
        );

        $checkResult = mysqli_query($connect, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            return [
                'status' => 'error',
                'message' => 'Duplicate entry: One of the unique fields already exists.'
            ];
        }
    }

    // Construct and execute the INSERT query
    $sql = sprintf(
        "INSERT INTO %s (%s) VALUES (%s)",
        $table,
        implode(", ", $columns),
        implode(", ", $escaped_values)
    );

    if (mysqli_query($connect, $sql)) {
        return [
            'status' => 'success',
            'id' => mysqli_insert_id($connect)
        ];
    } else {
        return [
            'status' => 'error',
            'message' => 'Database error: ' . mysqli_error($connect)
        ];
    }
}


/*
updaing data in database
 * @param string $table
 * @param array $data
 * @param int $id
 * @return array as assoc
*/
if (!function_exists('db_update')) {
    function db_update(string $table, array $data, int $id)
    {
        global $connect; // تأكد من أن الاتصال معرف

        // Build the SET part of the query
        $colum_value = '';
        foreach ($data as $key => $value) {
            $escaped_value = mysqli_real_escape_string($connect, $value);
            $colum_value .= "`$key` = '$escaped_value', ";
        }
        $colum_value = rtrim($colum_value, ", ");

        // Construct the SQL query
        $sql = "UPDATE `$table` SET $colum_value WHERE `id` = $id";

        // Execute the update query
        if (!mysqli_query($connect, $sql)) {
            return [
                'status' => 'error',
                'message' => 'Update failed: ' . mysqli_error($connect),
            ];
        }

        // Fetch the updated record
        $result = mysqli_query($connect, "SELECT * FROM `$table` WHERE `id` = $id");
        if ($result) {
            $data = mysqli_fetch_assoc($result);
            return [
                'status' => 'success',
                'data' => $data,
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to fetch updated record: ' . mysqli_error($connect),
            ];
        }
    }
}


/*
delete data from database
 * @param string $table
 * @param int $id
*/
if (!function_exists('db_delete')) {
    function db_delete(string $table, int $id): array
    {
        global $connect; // تأكد من وجود الاتصال بقاعدة البيانات

        // Construct the DELETE query
        $sql = "DELETE FROM `$table` WHERE `id` = $id";

        // Execute the query
        if (mysqli_query($connect, $sql)) {
            if (mysqli_affected_rows($connect) > 0) {
                return [
                    'status' => 'success',
                    'message' => "Record with ID $id deleted successfully."
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => "No record found with ID $id to delete."
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Deletion failed: ' . mysqli_error($connect)
            ];
        }
    }
}

/*
fetch single row data from database
 * @param string $table
 * @param int $id
*/
if (!function_exists('db_fetch')) {
    function db_fetch(string $table, int $id): array
    {
        global $connect; // تأكد من وجود الاتصال

        // بناء استعلام SQL مع تأمين البيانات
        $id = mysqli_real_escape_string($connect, $id);
        $sql = "SELECT * FROM `$table` WHERE `id` = $id";

        // تنفيذ الاستعلام
        $query = mysqli_query($connect, $sql);

        // التحقق من نجاح الاستعلام
        if (!$query) {
            return [
                'status' => 'error',
                'message' => 'Fetch failed: ' . mysqli_error($connect),
            ];
        }

        // الحصول على النتائج
        $result = mysqli_fetch_assoc($query);

        // التحقق من وجود بيانات
        if ($result) {
            return [
                'status' => 'success',
                'data' => $result,
            ];
        } else {
            return [
                'status' => 'error',
                'message' => "No record found with ID $id.",
            ];
        }
    }
}
/*
search for a single row data from database
 * @param string $table
 * @param int $id
*/
if (!function_exists('db_first')) {
    function db_first(string $table, string $query_str): array
    {
        global $connect; // تأكد من وجود الاتصال

        // تأكد من إضافة المسافة الصحيحة بين الجدول والجملة الشرطية
        $sql = "SELECT * FROM `$table` $query_str";

        // تنفيذ الاستعلام
        $query = mysqli_query($connect, $sql);

        // التحقق من نجاح الاستعلام
        if (!$query) {
            return [
                'status' => 'error',
                'message' => 'Fetch failed: ' . mysqli_error($connect),
            ];
        }

        // الحصول على النتائج
        $result = mysqli_fetch_assoc($query);

        // التحقق من وجود البيانات
        if ($result) {
            return [
                'status' => 'success',
                'data' => $result,
            ];
        } else {
            return [
                'status' => 'error',
                'message' => "No record found with the provided condition.",
            ];
        }
    }
}


$search = db_first('user', "WHERE email = 'adra4@gmail.com'");

if ($search['status'] === 'success') {
    var_dump($search['data']);
} else {
    echo "Error: " . $search['message'];
}
