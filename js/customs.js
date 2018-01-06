$('.extranalLink').on('click', function (e) {
    e.preventDefault();
    $("#Sform").attr('action', $(this).attr('href')).attr('target', '_BLANK').submit();
    $("#Sform").removeAttr('action').removeAttr('target');
});

$('#scroe_min,#scroe_max').on('change', function () {
    if ($("#scroe_min").val() != "" && $("#scroe_max").val() != "") {
        if ($("#scroe_min").val() > $("#scroe_max").val()) {
            $(this).after("<div class='text-danger errorscore'> Can not use this Score.</div>");
        } else {
            $(".errorscore").remove();
        }
    }
});
$("#ProjectForm").on('submit', function (e) {
    if ($("#scroe_min").val() != "" && $("#scroe_max").val() != "") {
        if ($("#scroe_min").val() > $("#scroe_max").val()) {
            e.preventDefault();
            $("#errorMessageMGF").html("This score can not be used.").css('padding-bottom', '10px');
        } else {
            $(".errorscore").remove();
        }
    }
});
$('#Project').on('change', function () {
    $("#Did option[data-status=remove]").remove();
    $("#Queue option[data-status=remove]").remove();
    var project_id = $(this).val();
    if (project_id != 'all') {
        $.getJSON('_op_ajax.php?op=getdidA&pid=' + project_id, function (data) {
            var items = [];
            $.each(data, function (key, val) {
                $("#Did").append('<option data-status="remove" value="' + val.DIDNumber + '"> ' + val.DIDNumber + '</option>');
            });
        });
    }
});
$('#Did').on('change', function () {
    $("#Queue option[data-status=remove]").remove();
    var project_id = $(this).val();
    if (project_id != 'all') {
        $.getJSON('_op_ajax.php?op=getQueueA&did=' + project_id, function (data) {
            var items = [];
            $.each(data, function (key, val) {
                $("#Queue").append('<option data-status="remove" value="' + val.QueueNumber + '"> ' + val.QueueNumber + '</option>');
            });
        });
    }
});
$('.removeAlert').on('click', function (e) {
    if (confirm('Are you sure? To Remove')) {

    } else {
        e.preventDefault();
    }
});
$("#openAgentName").on('click', function () {
    $('#appdex').slideToggle();
});
var TapFake = $('body').attr('data-id');
$('.TapFake').find('.' + TapFake).addClass('active');
$('#manageDIDQForm').on('submit', function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var data = $(this).serialize();
    $.ajax({
        url: url,
        data: data,
        type: 'post'
    }).done(function (data) {
        if (data == 1) {
            $("#errorMessageMGF").html("This information already exists.").css('padding-bottom', '10px');
        } else {
            window.location = "manage_queses.php";
        }
    });
});