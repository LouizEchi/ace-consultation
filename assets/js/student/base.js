function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    $('#clock').html(h + ":" + m + ":" + s);

    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

function getDayShortString() {
    var d = new Date();
    var weekday = new Array(7);
    weekday[0]=  "Sun";
    weekday[1] = "Mon";
    weekday[2] = "Tue";
    weekday[3] = "Wed";
    weekday[4] = "Thu";
    weekday[5] = "Fri";
    weekday[6] = "Sat";

    return weekday[d.getDay()];
}

function getMonthYearShortString() {
    var d = new Date();
    var month = new Array();
    month[0] = "Jan";
    month[1] = "Feb";
    month[2] = "Mar";
    month[3] = "Apr";
    month[4] = "May";
    month[5] = "Jun";
    month[6] = "Jul";
    month[7] = "Aug";
    month[8] = "Sept";
    month[9] = "Oct";
    month[10] = "Nov";
    month[11] = "Dec";
    return month[d.getMonth()] + ' ' + d.getFullYear();
}

$(function(){
    startTime();
    $('#current_day').text(getDayShortString());
    $('#current_date').text(getMonthYearShortString());
    $('[data-post]').each(function(e){
        var btn_submit = $(this);
        var form = $('#' + btn_submit.attr('data-post'));
        if(typeof(form) != 'undefined') {
            btn_submit.click(function(e){
                e.preventDefault();
                $('.error').addClass('hide');
                $.ajax({
                        url:  form.data('post-url'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function(o_response, s_message, o_xhr) {
                            if(typeof(o_response.success) != 'undefined')
                            {
                                $('table').each(function(e){
                                    load_table($(this));
                                });
                            }
                            else
                            {
                                $('.error').removeClass('hide');
                                $('.error').html(o_response.error);
                            }
                            check_time_out();
                        },
                        error: function(o_response)
                        {
                        }
                });
            })
        }

    });
    check_time_out();
    
    $('.time-logs .time-in, .time-logs .time-out').click(function(e){
        e.preventDefault();
        check_time_out();
    });

    $('.time-out').click(function(e){
        e.preventDefault();
         $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            data: {post: 'sent'},
            success: function(o_response, s_message, o_xhr) {
                if(typeof(o_response.success) != 'undefined')
                {
                    $('table').each(function(e){
                        load_table($(this));
                    });    
                }
                else
                {
                    $('.error').removeClass('hide');
                    $('.error').html(o_response.error);
                }
                check_time_out();
            },
            error: function(o_response)
            {
            }
        });         
    })
});

function check_time_out()
{
    $.ajax({
        url: $('.time-logs').data('check-url'),
        type: 'GET',
        success: function(o_response, s_message, o_xhr) {
            if(typeof(o_response.success) != 'undefined')
            {
                console.log(o_response);
                for(var i in o_response.data)
                {
                    if(o_response.data[i]['time_out'] == null)
                    {
                        $('.time-in').addClass('hide');
                        $('.time-out').removeClass('hide');
                        break;
                    }
                    else
                    {
                        $('.time-in').removeClass('hide');
                        $('.time-out').addClass('hide');
                    }
                }
            }
            else
            {
                $('.error').removeClass('hide');
                $('.error').html(o_response.error);
            }
        },
        error: function(o_response)
        {
        }
    });    
}