(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    // // Progress Bar
    // $('.pg-bar').waypoint(function () {
    //     $('.progress .progress-bar').each(function () {
    //         $(this).css("width", $(this).attr("aria-valuenow") + '%');
    //     });
    // }, {offset: '80%'});


    // Calender
    // $('#calender').datetimepicker({
    //     inline: true,
    //     format: 'L'
    // });


    // // Testimonials carousel
    // $(".testimonial-carousel").owlCarousel({
    //     autoplay: true,
    //     smartSpeed: 1000,
    //     items: 1,
    //     dots: true,
    //     loop: true,
    //     nav : false
    // });


    // Chart Global Color
    Chart.defaults.color = "gold";
    Chart.defaults.borderColor = "#000000";

    fetch("visitor_count.php")
        .then(response => response.json())
        .then(data => {
            console.log(data);

            const tableBody = document.getElementById("visitor-table");

            // بيانات الزوار السنويين
            const years = data.yearly_visitors.map(item => item.visit_year);
            const yearlyCounts = data.yearly_visitors.map(item => item.visitor_count);

            // بيانات الزوار اليوميين
            const dates = data.daily_visitors.map(item => item.visit_date);
            const dailyCounts = data.daily_visitors.map(item => item.visitor_count);
            
            //daily visitors
            var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
            var myChart1 = new Chart(ctx1, {
                type: "line",
                data: {
                    labels: dates,
                    datasets: [{
                            label: "Daily Visitors",
                            data: dailyCounts,
                            backgroundColor: "rgba(235, 22, 22, .7)",
                            fill: true
                        }
                    ]},
                options: {
                    responsive: true
                }
            });


            // yearly visitors
            var ctx2 = $("#salse-revenue").get(0).getContext("2d");
            var myChart2 = new Chart(ctx2, {
                type: "line",
                data: {
                    labels: years,
                    datasets: [{
                            label: "Yearly Visitors",
                            data: yearlyCounts,
                            backgroundColor: "rgba(235, 22, 22, .7)"
                        }
                    ]},
                options: {
                    responsive: true
                }
            });
        });
        
})(jQuery);



// $(document).ready(function () {
//     // عند الضغط على زر "Add Fields"
//     $("#add-label").on("click", function () {
//         var newFields = `
//             <div class="form-floating">
//                 <textarea class="form-control" placeholder="Leave a Description here"
//                     style="height: 65px;"></textarea>
//                 <label>label</label>
//             </div>
//         `;

//         // إضافة الحقول الجديدة داخل `#input-container`
//         $("#input-container").append(newFields);
//     });
//     $("#add-checkbox").on("click", function () {
//         var newFields = `
//             <div class="form-floating">
//                 <textarea class="form-control" placeholder="Leave a Description here"
//                     style="height: 65px;"></textarea>
//                 <label>label</label>
//             </div>
//         `;

//         // إضافة الحقول الجديدة داخل `#input-container`
//         $("#input-container").append(newFields);
//     });

//     $("#remove-field").on("click", function () {
//         $("#input-container .extra-fields").last().fadeOut(300, function () {
//             $(this).remove();
//         });
//     });
// });







// $(document).ready(function () {
//     // عند الضغط على زر "Add Label"
//     $("#add-label").on("click", function () {
//         var newFields = `
//             <div class="extra-fields bg-light p-2 mt-2 position-relative">
//                 <div class="form-floating">
//                     <textarea class="form-control" placeholder="Enter Text" style="height: 65px;"></textarea>
//                     <label>Label</label>
//                 </div>
//             </div>
//         `;

//         // إضافة الحقل الجديد داخل `#input-container`
//         $("#input-container").append(newFields);
//     });

//     // عند الضغط على زر "Add Checkbox"
//     $("#add-checkbox").on("click", function () {
//         var newFields = `
//             <div class="extra-fields bg-light p-2 mt-2 position-relative">
//                 <div class="form-check">
//                     <input class="form-check-input" type="checkbox" value="">
//                     <label class="form-check-label">New Checkbox</label>
//                 </div>
//             </div>
//         `;

//         // إضافة الحقل الجديد داخل `#input-container`
//         $("#input-container").append(newFields);
//     });

//     // عند الضغط على زر "Remove Field" لمسح آخر عنصر تمت إضافته
//     $("#remove-field").on("click", function () {
//         var lastField = $("#input-container .extra-fields").last();
//         if (lastField.length) {
//             lastField.fadeOut(300, function () {
//                 $(this).remove();
//             });
//         }
//     });
// });







$(document).ready(function () {
    var formData = [];
    var selectedEventId = 0;
    $.get("get_events.php", function(data) {
        var events = JSON.parse(data);
        var dropdown = $("#event-select"); // استخدم الـ select الموجود
        dropdown.empty(); // إفراغ الـ select من الـ options القديمة
        dropdown.append('<option value="0">Select Event</option>');
        $.each(events, function(index, event) {
            dropdown.append(`<option value="${event.id}">${event.title}</option>`);
        });
    
        // عند تغيير اختيار الحدث
        dropdown.change(function() {
            selectedEventId = $(this).val();
            if (selectedEventId > 0) {
                loadFormFields(selectedEventId);
            }
        });
    });

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
    
    // إضافة Label
    $("#add-label").click(function () {
        var fieldId = "label-" + formData.length;
        var labelField = `
            <div class="form-floating mt-2">
                <input type="text" class="form-control field-label" id="${fieldId}" placeholder="Enter label name">
                <label for="${fieldId}">Label Name</label>
            </div>`;
        $("#form-preview").append(labelField);
        formData.push({ type: "label", label: "" });
    });

    // إضافة Checkbox
    $("#add-checkbox").click(function () {
        var fieldId = "checkbox-" + formData.length;
        var checkboxField = `
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox">
                <input type="text" class="form-control d-inline-block w-50 field-label" id="${fieldId}" placeholder="Enter checkbox name">
            </div>`;
        $("#form-preview").append(checkboxField);
        formData.push({ type: "checkbox", label: "" });
    });

    // إضافة Paragraph
    $("#add-paragraph").click(function () {
        var fieldId = "paragraph-" + formData.length;
        var paragraphField = `
            <div class="mt-2 extra-fields">
                <input type="text" class="form-control field-label" id="${fieldId}" placeholder="Enter paragraph text">
            </div>`;
        $("#form-preview").append(paragraphField);
        formData.push({ type: "paragraph", label: "" });
    });
    
    // إضافة radio
    $("#add-radio").click(function () {
        var fieldId = "radio-" + formData.length;
        var paragraphField = `
            <div class="form-check">
                <input class="form-check-input" type="radio" name="radio[]">
                <input type="text" class="form-control d-inline-block w-50 field-label" id="${fieldId}" placeholder="Enter radio name">
            </div>`;
        $("#form-preview").append(paragraphField);
        formData.push({ type: "radio", label: "" });
    });
    
    // إضافة Form Name
    $("#add-name").click(function () {
        var fieldId = "text-" + formData.length;
        var paragraphField = `
            <div class="mt-2 extra-fields">
                <input type="text" class="form-control field-label" id="${fieldId}" placeholder="Enter paragraph text">
            </div>`;
        $("#form-preview").append(paragraphField);
        formData.push({ type: "paragraph", label: "" });
    });

    // حفظ الحقول في قاعدة البيانات
    $("#save-form").click(function () {
        console.log("Selected Event ID:", selectedEventId); // تسجيل قيمة event_id
        console.log("Form Data:", formData); // تسجيل بيانات الفورم
        if (selectedEventId === 0) {
            alert("Please select an event first!");
            return;
        }
    
        $(".field-label").each(function (index) {
            formData[index].label = $(this).val();
        });
    
        $.ajax({
            url: "save_form.php",
            method: "POST",
            data: { 
                event_id: selectedEventId,
                fields: JSON.stringify(formData)
            },
            success: function (response) {
                console.log("Save Response:", response); // تسجيل الاستجابة
                alert(response);
            },
            error: function (xhr, status, error) {
                console.error("Save Error:", error); // تسجيل أي خطأ
                alert("An error occurred while saving the form.");
            }
        });
    });
});

// داخل $(document).ready أو في نهاية الملف
fetch("visitor_count.php")
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error("Error fetching visitor data:", data.error);
            return;
        }

        // Daily Visitors Chart
        const dailyDates = data.daily_visitors.map(item => item.visit_date);
        const dailyCounts = data.daily_visitors.map(item => item.visitor_count);
        var ctx1 = $("#daily-visitors-chart").get(0).getContext("2d");
        var myChart1 = new Chart(ctx1, {
            type: "line",
            data: {
                labels: dailyDates,
                datasets: [{
                    label: "Daily Visitors",
                    data: dailyCounts,
                    backgroundColor: "rgba(235, 22, 22, 0.3)",
                    borderColor: "rgba(235, 22, 22, 1)",
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: "Number of Visitors" }
                    },
                    x: {
                        title: { display: true, text: "Date" }
                    }
                }
            }
        });

        // Total Visits Chart
        const totalDates = data.total_visits.map(item => item.visit_date);
        const totalCounts = data.total_visits.map(item => item.visit_count);
        var ctx2 = $("#total-visits-chart").get(0).getContext("2d");
        var myChart2 = new Chart(ctx2, {
            type: "line",
            data: {
                labels: totalDates,
                datasets: [{
                    label: "Total Visits",
                    data: totalCounts,
                    backgroundColor: "rgba(22, 235, 22, 0.3)",
                    borderColor: "rgba(22, 235, 22, 1)",
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: "Number of Visits" }
                    },
                    x: {
                        title: { display: true, text: "Date" }
                    }
                }
            }
        });
    })
    .catch(error => console.error("Fetch error:", error));