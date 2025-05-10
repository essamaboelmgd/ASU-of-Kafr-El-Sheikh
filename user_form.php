<?php
include('conn.php');

// جلب الحقول المخزنة في قاعدة البيانات
$sql = "SELECT * FROM form_fields";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Form</title>
    
    <link href="./admin-dash/css/bootstrap.min.css" rel="stylesheet">
    <link href="./admin-dash/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-6 col-xl-special">
                <form action="submit_form.php" method="POST">
                    <div class="bg-secondary rounded h-100 p-4">
                        <?php
                        $current_radio_group = null;
                        $current_checkbox_group = null;

                        while ($row = $result->fetch_assoc()) {
                            $field_label = htmlspecialchars($row['field_label']);
                            $field_name = "field_" . $row['id']; // إعطاء اسم فريد لكل حقل

                            if ($row['field_type'] == 'label') {
                                $current_radio_group = null;
                                $current_checkbox_group = null;
                                echo '<div class="form-floating mb-3">
                                        <input type="text" name="' . $field_name . '" class="form-control" id="floatingInput">
                                        <label for="floatingInput">' . $field_label . '</label>
                                    </div>';
                            } elseif ($row['field_type'] == 'checkbox') {
                                if ($current_checkbox_group === null) {
                                    $current_checkbox_group = "checkbox_" . $row['id'];
                                }
                                echo '<div class="form-check mt-2">
                                        <input type="checkbox" name="' . $current_checkbox_group . '" value="' . $field_label . '" class="form-check-input">
                                        <label for="floatingcheckbox">' . $field_label . '</label>
                                    </div>';
                            } elseif ($row['field_type'] == 'radio') {
                                // إذا لم يكن هناك مجموعة حالية، قم بإنشاء مجموعة جديدة
                                if ($current_radio_group === null) {
                                    $current_radio_group = "radio_" . $row['id'];
                                }
                                $current_checkbox_group = null;
                                echo '<div class="form-check">
                                        <input class="form-check-input" type="radio" name="' . $current_radio_group . '" 
                                            id="gridRadios_' . $row['id'] . '" value="' . $field_label . '">
                                        <label class="form-check-label" for="gridRadios_' . $row['id'] . '">
                                            ' . $field_label . '
                                        </label>
                                    </div>';
                            } elseif ($row['field_type'] == 'text' || $row['field_type'] == 'paragraph') {
                                // عند العثور على فقرة أو نص، يتم إنهاء مجموعة الراديو الحالية
                                $current_radio_group = null;
                                $current_checkbox_group = null;
                                echo '<div class="mt-2 extra-fields">
                                        <label for="floatingInput">' . $field_label . '</label>
                                    </div>';
                            }
                        }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
