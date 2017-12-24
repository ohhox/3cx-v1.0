$('.extranalLink').on('click', function (e) {
    e.preventDefault();
    $("#Sform").attr('action', $(this).attr('href')).attr('target', '_BLANK').submit();
    $("#Sform").removeAttr('action').removeAttr('target');
});