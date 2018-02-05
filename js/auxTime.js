$(".AgentCheck").on('change', function () { // Disble Agent Option
    if ($(this).val() == 'name') {
        $('#AgentName').prop('disabled', false).focus();
        $('#Agent').prop('disabled', true);
    } else {
        $('#AgentName').prop('disabled', true);
        $('#Agent').prop('disabled', false).focus();
    }
});

$(".timeCheck").on('change', function (e) { // Disble Time O
    if ($(this).val() == 'workHours') {
        if ($(this).attr('checkDid') == 'No') {
            e.preventDefault();
            $(this).parent().find('.errorMsg').html('Select Queue Number first.');
            $(this).prop('checked', false);
            $('#Queue').focus();
        }
    } else {
    }
});


$('#Queue').on('change', function () { // Get Work Hours
    $("#Agent option[data-status=remove]").remove();

    var did = $('#Did').val();
    var project = $('#Project').val();
    var Queue = $('#Queue').val();

    $.getJSON('_op_ajax.php?op=getWorkhours&did=' + did + "&project=" + project + '&Qid=' + Queue, function (data) {
        if (data.timeEnd != '' && data.timeStart) {
            $("#whStart").val(data.timeStart);
            $("#whend").val(data.timeEnd);
            $("#whTime").attr('checkDid', 'yes');
            $('#QnumberaAlert').html('');
        } else {
            $('#QnumberaAlert').html('Not found Work Hours.');
             $("#whTime").attr('checkDid', 'No');
             $('#whTime').prop('checked', false);
        }
    });

});

