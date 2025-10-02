document.addEventListener("DOMContentLoaded", function () {
    initBusinessHourToggles();
});
//delete whatsapp store
listenClick(".whatsapp-store-delete-btn", function (event) {
    let recordId = $(event.currentTarget).attr("data-id");
    deleteItem(
        route("whatsapp.stores.destroy", recordId),
        Lang.get("js.whatsapp_store")
    );
});

//save or update wp template
listenClick(".wp-template-save", function () {
    let template_id = $("#themeInput").val();

    if (isEmpty(template_id) || template_id == 0) {
        displayErrorMessage(Lang.get("js.choose_one_template"));
        return false;
    }
    let whatsappStore = $("#whatsappStoreId").val();

    $.ajax({
        url: route("wp.template.update", whatsappStore),
        type: "POST",
        data: { template_id: template_id },
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

//save or update wp template seo
listenClick(".wp-template-seo-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();

    let formData = new FormData();
    formData.append('site_title', $('input[name="site_title"]').val());
    formData.append('home_title', $('input[name="home_title"]').val());
    formData.append('meta_keyword', $('input[name="meta_keyword"]').val());
    formData.append('meta_description', $('input[name="meta_description"]').val());
    formData.append('google_analytics', $('textarea[name="google_analytics"]').val());

    $.ajax({
        url: route("wp.template.seo.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

// save or update wp template advanced
listenClick(".wp-template-advance-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();

    let formData = new FormData();
    formData.append('custom_css', $('textarea[name="custom_css"]').val());
    formData.append('custom_js', $('textarea[name="custom_js"]').val());

    $.ajax({
        url: route("wp.template.advance.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});

// save or update wp template custom fonts
listenClick(".wp-template-custom-font-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();

    let formData = new FormData();
    formData.append('font_family', $('select[name="font_family"]').val());
    formData.append('font_size', $('input[name="font_size"]').val());

    $.ajax({
        url: route("wp.template.custom.fonts.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});


//whatsapp store status change
listen("click", ".whatsappStoreStatus", function () {
    let whatsappStoreId = $(this).data("id");
    let updateUrl = route("whatsapp.stores.status", whatsappStoreId);
    $.ajax({
        type: "get",
        url: updateUrl,
        success: function (response) {
            displaySuccessMessage(response.message);
            Livewire.dispatch("refresh");
        },
        error: function (error) {
            displayErrorMessage(error.responseJSON.message);
        },
    });
});

listen("click", ".whatsapp-store-clone", function () {
    let whatsappStoreId = $(this).attr("data-id");
    $("body").addClass("modal-open");
    $.ajax({
        url: route("sadmin.whatsapp.store.clone", whatsappStoreId),
        success: function (result) {
            let userDropdown = $("#user_id");
            userDropdown.empty();
            userDropdown.append('<option value="">' + Lang.get("js.select_user") + '</option>');
            $.each(result.data.users, function (id, name) {
                userDropdown.append('<option value="' + id + '">' + name + '</option>');
            });
            userDropdown.select2({
                minimumResultsForSearch: 0,
                dropdownParent: $('#whatsappStoreCloneModal')
            });
            $("#duplicateWhatsappStoreBtn").attr("data-id", whatsappStoreId);

            var modalElement = document.getElementById("whatsappStoreCloneModal");
            var myModal = new bootstrap.Modal(modalElement, {
                backdrop: "static",
                keyboard: false
            });

            myModal.show();
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
            $("body").removeClass("modal-open");
        },
    });
});

$(document).on("hidden.bs.modal", "#whatsappStoreCloneModal", function () {
    $("body").removeClass("modal-open");
});


listen("submit", "#cloneWhatsappStoreForm", function (e) {
    e.preventDefault();
    $("#duplicateWhatsappStoreBtn").prop("disabled", true);
    let duplicateId = $("#duplicateWhatsappStoreBtn").attr("data-id");
    let userId = $("#user_id").val();
    $.ajax({
        url: route("sadmin.duplicate.whatsapp.store", { id: duplicateId, userId: userId }),
        type: "POST",
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#whatsappStoreCloneModal").modal("hide");
                $("#duplicateWhatsappStoreBtn").prop("disabled", false);
                Livewire.dispatch("refresh");
            }
        },
        error: function (result) {
            $("#duplicateWhatsappStoreBtn").prop("disabled", false);
            if (!userId) {
                displayErrorMessage(Lang.get("js.please_select_user"));
                return;
            }
            displayErrorMessage(result.responseJSON.message);
        },
    });
});

function initBusinessHourToggles() {
    document.querySelectorAll('.day-toggle').forEach(function (checkbox) {
        const dayKey = checkbox.value;

        toggleDayTime(dayKey);

        checkbox.addEventListener('change', function () {
            toggleDayTime(dayKey);
        });
    });
}

function toggleDayTime(dayKey) {
    const checkbox = document.getElementById('dayToggle' + dayKey);
    const timeFields = document.getElementById('timeFields' + dayKey);
    const closedState = document.getElementById('closedState' + dayKey);

    if (checkbox.checked) {
        // Show time fields, hide closed state
        timeFields.style.display = 'flex';
        closedState.style.display = 'none';
    } else {
        // Hide time fields, show closed state
        timeFields.style.display = 'none';
        closedState.style.display = 'flex';
    }
}

listenClick(".wp-business-hours-save", function (e) {
    e.preventDefault();

    let whatsappStore = $("#whatsappStoreId").val();
    let formData = new FormData();

    let selectedDays = [];
    $('.day-toggle:checked').each(function() {
        selectedDays.push($(this).val());
    });

    selectedDays.forEach(function(day) {
        formData.append('days[]', day);
    });

    $('select[name^="startTime"]').each(function() {
        let name = $(this).attr('name');
        let value = $(this).val();
        if (value) {
            formData.append(name, value);
        }
    });

    $('select[name^="endTime"]').each(function() {
        let name = $(this).attr('name');
        let value = $(this).val();
        if (value) {
            formData.append(name, value);
        }
    });

    $.ajax({
        url: route("wp.business.hours.update", whatsappStore),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            displaySuccessMessage(response.message);
        },
        error: function (response) {
            displayErrorMessage(response.responseJSON.message);
        },
    });
});
