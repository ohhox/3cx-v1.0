$('.extranalLink').on('click', function (e) {
    e.preventDefault();
    $("#Sform").attr('action', $(this).attr('href')).attr('target', '_BLANK').submit();
    $("#Sform").removeAttr('action').removeAttr('target');
});


$('#Project').on('change', function () {
    $("#Did option[data-status=remove]").remove();
    $("#Queue option[data-status=remove]").remove();
    var project_id = $(this).val();
    if (project_id != 'all') {
        $.getJSON('_op_ajax.php?op=getdidq&pid=' + project_id, function (data) {
            var items = [];
            $.each(data, function (key, val) {
                $("#Did").append('<option data-status="remove" value="' + val.DIDNumber + '"> ' + val.DIDNumber + '</option>');
                $("#Queue").append('<option data-status="remove" value="' + val.DIDQueueID + '"> ' + val.DIDQueueID + '</option>');
            });

        });


    }
});