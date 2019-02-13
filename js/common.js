moment.updateLocale('en-my-settings', {
    months : [
        "一月",
        "二月",
        "三月",
        "四月",
        "五月",
        "六月",
        "七月",
        "八月",
        "九月",
        "十月",
        "十一月",
        "十二月",
    ],
    weekdaysShort : [
        "日",
        "一",
        "二",
        "三",
        "四",
        "五",
        "六",
    ],
    meridiem : function (hour, minute, isLowercase) {
        if (hour < 12) {
            return "上午";
        }else{
            return "下午";
        }
    }
});

var datePickerLocationOption = {
    "format": "YYYY-MM-DD",
    "daysOfWeek": moment.localeData().weekdaysShort(),
    "monthNames": moment.localeData().months(),
    "applyLabel": "確定",
    "cancelLabel": "重設",
    "beforeStartLabel": "由",
    "afterStartLabel": "至"
}

function convertDateRangeText(picker){

    var startDate = picker.startDate.format(picker.locale.format);
    var endDate = picker.endDate.format(picker.locale.format);
    var isSinglePicker = picker.singleDatePicker;

    if(isSinglePicker){
        return startDate;
    }else{
        return "由" + startDate + "至" + endDate;
    }
}

function datePickerInit(targetParent){
    var isDateRange = ( $(targetParent).attr("data-is-range") == 'true' );
    var range = $(targetParent).attr("data-range") || false;
    var isDateTime = ( $(targetParent).attr("data-is-date-time") == 'true' );
    var isTimeOnly = ( $(targetParent).attr("data-is-time-only") == 'true' );
    var isPastOnly = ( $(targetParent).attr("date-is-past") == 'true' );
    var isFutureOnly = ( $(targetParent).attr("date-is-future") == 'true' );
    var showExtraButton = ( $(targetParent).attr("data-extra-button") == 'true' );
    var startDate = $(targetParent).find(".startDateField").val() || false;
    var endDate = $(targetParent).find(".endDateField").val() || false;
    var initTar = $(targetParent).find("input.displayDateRange");
    var minDate,maxDate,format,rangeObject;

    if(isDateTime)
    {
        format = "YYYY-MM-DD HH:mm"
    }else if(isTimeOnly){
        format = "HH:mm"
    }else{
        format = "YYYY-MM-DD"
    }
    if(range && isDateRange){
        rangeObject = dateStringConvert(range);
    }else{
        rangeObject = false;
    }

    if(isPastOnly && isFutureOnly){
        minDate = false;
        maxDate = false;
    }else if(isPastOnly){
        maxDate = moment().endOf('d');
        if(rangeObject){
            minDate = moment().subtract(rangeObject);
        }else{
            minDate = false;
        }
    }else if(isFutureOnly){
        minDate = moment().startOf('d');
        if(rangeObject){
            maxDate = moment().add(rangeObject);
        }else{
            maxDate = false;
        }
    }
    if(isTimeOnly){
        minDate = moment("00:00","HH:mm");
        maxDate = moment("23:59","HH:mm");
    }
    var locationOption = {
        "format": format
    };
    locationOption = datePickerLocationCombine(locationOption);

    var option = {
        "maxSpan": rangeObject,
        "startDate":startDate,
        "endDate": endDate,
        "minDate": minDate,
        "maxDate": maxDate,
        "singleDatePicker": (!isDateRange),
        "timePicker": (isDateTime || isTimeOnly),
        "timePicker24Hour": true,
        "timePickerIncrement": 30,
        "autoUpdateInput": false,
        "showDropdowns": true,
        "showExtraButton": showExtraButton,
        "locale": locationOption
    };

    $(initTar).daterangepicker(option);

    if(startDate || endDate){
        $(initTar).val(convertDateRangeText($(initTar).data("daterangepicker")))
    };

    $(initTar).on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        $(targetParent).find(".startDateField").val("");
        $(targetParent).find(".endDateField").val("");
    });

    $(initTar).on('apply.daterangepicker', function(ev, picker) {
        if(picker.isAfterForever)
        {
            $(targetParent).find(".startDateField").val(picker.startDate.format(format));
            $(targetParent).find(".endDateField").val("");
        }else if(picker.isBeforeForever){
            $(targetParent).find(".startDateField").val("");
            $(targetParent).find(".endDateField").val(picker.endDate.format(format));
        }else{
            $(targetParent).find(".startDateField").val(picker.startDate.format(format));
            $(targetParent).find(".endDateField").val(picker.endDate.format(format));
        }
        $(initTar).val(convertDateRangeText(picker))
    });

    if(!isDateTime && isTimeOnly){
        $(initTar).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
    }
}

function dateStringConvert(string){
    //split by ","

    if(!string)
    {
        return false;
    }

    var resultArr = string.split(",")
    var resultObject = {};

    $.each(resultArr,function(i,v){
        var qty = v.slice(0,-1);
        var key = v.slice(-1);
        var convertKey;

        switch(key) {
            case "y":
                convertKey = "years";
                break;
            case "M":
                convertKey = "months";
                break;
            case "d":
                convertKey = "days";
                break;
            case "h":
                convertKey = "hours";
                break;
            case "m":
                convertKey = "minutes";
                break;
            default:
                convertKey = "months";
                break;
        }
        resultObject[convertKey] = parseInt(qty);
    })
    return resultObject;
}

function datePickerLocationCombine(datePickerCustomLocationOption){
    var option = $.extend( {}, datePickerLocationOption, datePickerCustomLocationOption );
    return option;
}


$(document).ready(function(){
    $("#maintainFormId").parsley({
        excluded: '.parsleyExcluded input,.parsleyExcluded select,.parsleyExcluded textarea',
        errorClass: 'error',
        successClass: 'success',
        errorsContainer: function(e) {
            return e.$element.parent().siblings(".errorHolder").length > 0 ? e.$element.parent().siblings(".errorHolder") : '';
        },
        classHandler:function(e){
            return e.$element.closest(".form-group")
        }
    });
});

//Date picker
$(function(){
    if( $(".datePicker").length > 0){
        $(".datePicker").each(function(i,v){
            $(v).attr("id","datePickerId"+i)
            if( !$(v).hasClass("disableInit") ){
                datePickerInit("#"+$(v).attr("id"));
            }
        })
    }
});