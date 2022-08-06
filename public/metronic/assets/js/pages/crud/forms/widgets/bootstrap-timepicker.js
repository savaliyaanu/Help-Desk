// Class definition

var KTBootstrapTimepicker = function () {

    // Private functions
    var demos = function () {
        // minimum setup
        $('#kt_timepicker_1, #kt_timepicker_1_modal').timepicker({
            defaultTime: '00:00:00 AM',
        });

        // minimum setup
        $('#kt_timepicker_2, #kt_timepicker_2_modal').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false,
            snapToStep: true
        });

        // default time
        $('#kt_timepicker_3, #kt_timepicker_3_modal').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: true
        });

        // default time
        $('#kt_timepicker_4, #kt_timepicker_4_modal').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: true
        });

        // validation state demos
        // minimum setup
        $('#kt_timepicker_1_validate, #kt_timepicker_2_validate, #kt_timepicker_3_validate').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false,
            snapToStep: true
        });
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function() {
    KTBootstrapTimepicker.init();
});
