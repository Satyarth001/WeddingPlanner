
$(document).ready(function () {
    // Toggle mobile menu
    $(".menu-toggle").click(function () {
        $(".nav-bar").toggleClass("active");
    });

    // Toggle dropdown menu
    $(".dropdown > a").click(function (e) {
        e.preventDefault();
        $(this).parent().toggleClass("active");
    });

    // Close dropdown when clicking outside
    $(document).click(function (event) {
        if (!$(event.target).closest(".dropdown, .menu-toggle").length) {
            $(".dropdown").removeClass("active");
        }
    });
});

