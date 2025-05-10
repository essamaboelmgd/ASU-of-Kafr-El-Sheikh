<?php
include('conn.php');
session_start();

// التحقق من تسجيل المستخدم في الحدث
if (!isset($_SESSION['event_user']) || !isset($_GET['event_id'])) {
    header("Location: index.php");
    exit();
}

$event_id = intval($_GET['event_id']);
$user_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ?: 'unknown';

// التحقق من أن المستخدم سجل في الحدث
$sql_check = "SELECT id FROM event_users WHERE event_id = ? AND ip_address = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("is", $event_id, $user_ip);
$stmt_check->execute();
$stmt_check->store_result();
if ($stmt_check->num_rows === 0) {
    header("Location: index.php");
    exit();
}
$stmt_check->close();

// جلب الحقول المخزنة للحدث المحدد
$sql = "SELECT * FROM form_fields WHERE event_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .form-container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            width: 100%;
        }
        .form-container h2 {
            font-weight: 600;
            color: #1e3a8a;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        .form-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #6b7280;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 12px 15px 12px 40px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 8px rgba(30, 58, 138, 0.2);
            outline: none;
        }
        .form-check {
            margin-bottom: 10px;
        }
        .form-check-input {
            border-radius: 4px;
            cursor: pointer;
        }
        .form-check-label {
            color: #374151;
            cursor: pointer;
        }
        .form-check-input:checked {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }
        .btn-submit {
            background: #1e3a8a;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 500;
            width: 100%;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-submit:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }
        .extra-fields {
            margin-bottom: 15px;
            color: #374151;
            font-weight: 500;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }
        .form-group.is-invalid .form-control {
            border-color: #dc3545;
        }
        .form-group.is-invalid .error-message {
            display: block;
        }
        .form-check.is-invalid .error-message {
            display: block;
        }
        @media (max-width: 576px) {
            .form-container {
                padding: 20px;
            }
            .form-container h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Event Form</h2>
        <?php if ($result->num_rows > 0): ?>
            <form id="event-form" action="submit_form.php?event_id=<?php echo $event_id; ?>" method="POST">
                <?php
                $radio_group_counter = 0;
                $checkbox_group_counter = 0;
                $current_group_type = null;

                while ($row = $result->fetch_assoc()) {
                    $field_label = htmlspecialchars($row['field_label']);
                    $field_name = "field_" . $row['id'];

                    if ($row['field_type'] == 'label') {
                        $current_group_type = 'label';
                        echo '<div class="form-group">
                                <i class="fas fa-text-height"></i>
                                <input type="text" name="' . $field_name . '" class="form-control" placeholder="' . $field_label . '" required>
                                <div class="error-message">This field is required.</div>
                              </div>';
                    } elseif ($row['field_type'] == 'checkbox') {
                        if ($current_group_type !== 'checkbox') {
                            $checkbox_group_counter++;
                            $current_group_type = 'checkbox';
                        }
                        $checkbox_group_name = "checkbox_group_" . $checkbox_group_counter;
                        echo '<div class="form-check">
                                <input type="checkbox" name="' . $checkbox_group_name . '[]" value="' . htmlspecialchars($row['field_label']) . '" class="form-check-input" id="checkbox_' . $row['id'] . '">
                                <label class="form-check-label" for="checkbox_' . $row['id'] . '">' . $field_label . '</label>
                              </div>';
                        if ($current_group_type == 'checkbox') {
                            echo '<div class="error-message" data-checkbox-group="' . $checkbox_group_name . '">Please select at least one option.</div>';
                        }
                    } elseif ($row['field_type'] == 'radio') {
                        if ($current_group_type !== 'radio') {
                            $radio_group_counter++;
                            $current_group_type = 'radio';
                        }
                        $radio_group_name = "radio_group_" . $radio_group_counter;
                        echo '<div class="form-check">
                                <input class="form-check-input" type="radio" name="' . $radio_group_name . '" id="radio_' . $row['id'] . '" value="' . htmlspecialchars($row['field_label']) . '">
                                <label class="form-check-label" for="radio_' . $row['id'] . '">' . $field_label . '</label>
                              </div>';
                        if ($current_group_type == 'radio') {
                            echo '<div class="error-message" data-radio-group="' . $radio_group_name . '">Please select an option.</div>';
                        }
                    } elseif ($row['field_type'] == 'text' || $row['field_type'] == 'paragraph') {
                        $current_group_type = $row['field_type'];
                        echo '<div class="extra-fields">
                                <i class="fas fa-info-circle"></i> ' . $field_label . '
                              </div>';
                    }
                }
                ?>
                <button type="submit" class="btn-submit">Submit Form</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                No fields available for this event.
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#event-form').on('submit', function(e) {
                let isValid = true;

                // إزالة كل رسايل الخطأ السابقة
                $('.form-group').removeClass('is-invalid');
                $('.form-check').removeClass('is-invalid');
                $('.error-message').hide();

                // التحقق من حقول النص
                $(this).find('input[type="text"]').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).closest('.form-group').addClass('is-invalid');
                        isValid = false;
                    }
                });

                // التحقق من مجموعات الـ radio
                let radioGroups = [];
                $(this).find('input[type="radio"]').each(function() {
                    let groupName = $(this).attr('name');
                    if (!radioGroups.includes(groupName)) {
                        radioGroups.push(groupName);
                    }
                });
                radioGroups.forEach(function(groupName) {
                    if ($('input[name="' + groupName + '"]:checked').length === 0) {
                        $('input[name="' + groupName + '"]').closest('.form-check').addClass('is-invalid');
                        $('[data-radio-group="' + groupName + '"]').show();
                        isValid = false;
                    }
                });

                // التحقق من مجموعات الـ checkbox
                let checkboxGroups = [];
                $(this).find('input[type="checkbox"]').each(function() {
                    let groupName = $(this).attr('name');
                    if (!checkboxGroups.includes(groupName)) {
                        checkboxGroups.push(groupName);
                    }
                });
                checkboxGroups.forEach(function(groupName) {
                    if ($('input[name="' + groupName + '"]:checked').length === 0) {
                        $('input[name="' + groupName + '"]').closest('.form-check').addClass('is-invalid');
                        $('[data-checkbox-group="' + groupName + '"]').show();
                        isValid = false;
                    }
                });

                // منع إرسال الفورم لو فيه أخطاء
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill all required fields.');
                }
            });
        });
    </script>
    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>