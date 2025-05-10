<?php
header('Content-Type: application/json');

include('conn.php');

// جلب بيانات الزوار السنويين
$sql_yearly = "SELECT visit_year, visitor_count FROM yearly_visitors ORDER BY visit_year ASC";
$result_yearly = $conn->query($sql_yearly);
$yearly_data = [];

if ($result_yearly) {
    while ($row = $result_yearly->fetch_assoc()) {
        $yearly_data[] = [
            "visit_year" => $row["visit_year"],
            "visitor_count" => (int)$row["visitor_count"]
        ];
    }
}

// جلب بيانات الزوار اليوميين لآخر 7 أيام
$sql_daily = "SELECT visit_date, visitor_count FROM daily_visitors 
              WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
              ORDER BY visit_date ASC";
$result_daily = $conn->query($sql_daily);
$daily_data = [];

if ($result_daily) {
    while ($row = $result_daily->fetch_assoc()) {
        $daily_data[] = [
            "visit_date" => $row["visit_date"],
            "visitor_count" => (int)$row["visitor_count"]
        ];
    }
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();

// إرجاع البيانات بصيغة JSON
echo json_encode([
    "yearly_visitors" => $yearly_data,
    "daily_visitors" => $daily_data
]);
?>
