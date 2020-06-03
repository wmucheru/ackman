$(document).ready(function () {

    $('.no-enter input, .no-enter textarea').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    /* Password toggle */
    $('#password-toggle').change(function (e) {
        var target = document.getElementById('signup-pwd');
        target.type = target.type === "password"
            ? "text"
            : "password"
    })
})