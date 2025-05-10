<?php
include('conn.php');
header('Content-Type: application/json');

try {
    // Daily visitors
    $sql_daily = "SELECT visit_date, visitor_count FROM daily_visitors ORDER BY visit_date DESC LIMIT 7";
    $result_daily = $conn->query($sql_daily);
    $daily_visitors = [];
    while ($row = $result_daily->fetch_assoc()) {
        $daily_visitors[] = $row;
    }

    // Total visits
    $sql_total = "SELECT visit_date, visit_count FROM total_visits ORDER BY visit_date DESC LIMIT 30";
    $result_total = $conn->query($sql_total);
    $total_visits = [];
    while ($row = $result_total->fetch_assoc()) {
        $total_visits[] = $row;
    }

    echo json_encode([
        'daily_visitors' => $daily_visitors,
        'total_visits' => $total_visits
    ]);
} catch (Exception $e) {
    error_log("Error in visitor_count.php: " . $e->getMessage());
    echo json_encode(['error' => 'Failed to fetch data']);
}

$conn->close();
?>