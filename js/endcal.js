$('#Did,#Project').on('change', function () { // Get Agent
    $("#Agent option[data-status=remove]").remove();

    var did = $(this).val();
    var project = $('#Project').val();

    $.getJSON('_op_ajax.php?op=getAgent&did=' + did + "&project=" + project, function (data) {
        var items = [];
        $.each(data, function (key, val) {
            $("#Agent").append('<option data-status="remove" value="' + val.agent_code + '"> ' + val.agent_code + '</option>');
        });
    });

});

$('#Project').on('change', function () { // Get Score
    var project = $('#Project').val();
    if (project != "all") {
        $.getJSON('_op_ajax.php?op=getScore&project=' + project, function (data) {
            var items = [];
            $("#score_min").val(data.score_min).attr('min', data.score_min).attr('max', data.score_max);
            $("#score_max").val(data.score_max).attr('min', data.score_min).attr('max', data.score_max);
            $("#ScoreRate").show();
        });
    } else {
        $("#score_min").val("");
        $("#score_max").val("");
        $("#ScoreRate").hide();
    }
});

$("input[name=report]").on('change', function () {
    if ($(this).val() == "sum") {
        $("#agentCalc").addClass('show');
    } else {
        $("#agentCalc").removeClass('show');
    }
});

