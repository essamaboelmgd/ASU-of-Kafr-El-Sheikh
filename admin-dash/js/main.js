$(document).ready(function () {
    var formData = [];
    var selectedEventId = 0;
    console.log(selectedEventId);
    // جلب الأحداث من قاعدة البيانات وعرضها في dropdown
    $.get("get_events.php", function(data) {
        var events = JSON.parse(data);
        var dropdown = $('<select class="form-select mb-3" id="event-select"></select>');
        console.log(selectedEventId);
        dropdown.append('<option value="0">Select Event</option>');
        $.each(events, function(index, event) {
            dropdown.append(`<option value="${event.id}">${event.title}</option>`);
        });
        
        $("#form-preview").prepend(dropdown);
        console.log(selectedEventId);    
        // عند تغيير اختيار الحدث
        $("#event-select").change(function() {
            selectedEventId = $(this).val();
            if (selectedEventId > 0) {
                loadFormFields(selectedEventId);
            }
        });
    });
    console.log(selectedEventId);
    // دالة لتحميل حقول الفورم للحدث المحدد
    function loadFormFields(eventId) {
        $.get("get_form_fields.php", {event_id: eventId}, function(data) {
            $("#form-preview .extra-fields").remove(); // إزالة الحقول الحالية
            var fields = JSON.parse(data);
            console.log(selectedEventId);
            $.each(fields, function(index, field) {
                addFieldToPreview(field);
            });
        });
    }

    // تعديل دالة الحفظ لإرسال event_id
    $("#save-form").click(function () {
        console.log(selectedEventId);
        if (selectedEventId === 0) {
            alert("Please select an event first!");
            return;
        }

        $(".field-label").each(function (index) {
            formData[index].label = $(this).val();
        });
        console.log(selectedEventId);
        $.ajax({
            url: "save_form.php",
            method: "POST",
            data: { 
                event_id: selectedEventId,
                fields: JSON.stringify(formData)
            },
            success: function (response) {
                alert(response);
            }
        });
    });
});