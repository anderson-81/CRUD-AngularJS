$(function () {
    $("#salary").maskMoney({
        prefix: "R$ ",
        allowNegative: false,
        thousands: ".",
        decimal: ",",
        affixesStay: false,
        allowZero: true,
    });

    function setDatetimePicker() {
        var date = new Date();
        date.setFullYear(date.getFullYear() - 18),
            $("#birthday").datetimepicker({
                format: "DD/MM/YYYY",
            });
        $("#birthday").data("DateTimePicker").maxDate(date);
        $("#birthday").val(date);
    }

    setDatetimePicker();
});

function clearBirthday($event) {
    document.getElementById("birthday").value = "";
}