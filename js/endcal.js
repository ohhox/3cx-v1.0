$('.extranalLink2').on('click', function (e) {
    e.preventDefault();
    if (checkSelectProject(e)) {
        $("#Sform").attr('action', $(this).attr('href')).attr('target', '_BLANK').submit();
        $("#Sform").removeAttr('action').removeAttr('target');
    }
});

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

$('#Sform.endcall').on('submit', function (e) {
    checkSelectProject(e);
});
function checkSelectProject(e) {
    $("#AllertMage").html("").removeClass('active');
    $("#AllertMage2").html("").removeClass('active');
    if ($("#Project").val() == "all") {
        e.preventDefault();
        $("#AllertMage").html("<i class='fa fa-info'></i> Please select Project.").addClass('active');
        return false;
    } else if ($("#Did").val() == "all") {
        e.preventDefault();
        $("#AllertMage2").html("<i class='fa fa-info'></i> Please select  DID(VDN).").addClass('active');
        return false;
    } else {

        return true;
    }
}