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
        $("#CustermerNumberF").removeClass('show').find('input').val('');
    } else {
        $("#agentCalc").removeClass('show');
        $("#CustermerNumberF").addClass('show').focus();
    }
});

$('#Sform.endcall').on('submit', function (e) {
    checkSelectProject(e);
});
function checkSelectProject(e) {
    $("#AllertMage").html("").removeClass('active');
    $("#AllertMage2").html("").removeClass('active');


    var ScoreMin = $("#score_min").val();
    var ScoreMax = $("#score_max").val();
    var timeStart = $("#timeStart").val();
    var timeEnd = $("#timeEnd").val();

    if ($("#Project").val() == "all") {
        e.preventDefault();
        $("#AllertMage").html("<i class='fa fa-info'></i> Please select Project.").addClass('active');
        $("#Project").focus();
        return false;
    }
//    else if ($("#Did").val() == "all") {
//        e.preventDefault();
//        $("#AllertMage2").html("<i class='fa fa-info'></i> Please select  DID(VDN).").addClass('active');
//        $("#Did").focus();
//        return false;
//    }
    else if (timeStart > timeEnd) {
        e.preventDefault();
        $('.timeerror').remove();
        $("#timeEnd").focus().after("<div class=timeerror>can't use this format time.</div>");
        return false;
    } else if (ScoreMin > ScoreMax) {
        e.preventDefault();
        $('.ScoreRateERROR').remove();
        $("#score_max").focus().after("<div class=ScoreRateERROR>can't use this Rate.</div>");
        return false;
    } else {
        return true;
    }
}

$('.TimeSelectBox').on('change', function () {
    var timeStart = $("#timeStart").val();
    var timeEnd = $("#timeEnd").val();
    $('.timeerror').remove();
    if(timeEnd == '24:00'){        
         $("#timeEnd").val('23:59');
    }
    if (timeStart > timeEnd) {
        $("#timeEnd").focus().after("<div class=timeerror>can't use this format time.</div>");
    }
});

$('.scoreRate').on('change', function () {
    var timeStart = $("#score_min").val();
    var timeEnd = $("#score_max").val();
    $('.ScoreRateERROR').remove();
    if (timeStart > timeEnd) {
        $("#score_max").focus().after("<div class=ScoreRateERROR>can't use this Rate.</div>");
    }
});


