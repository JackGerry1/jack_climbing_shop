/* 
Reference: Jquery User Interface (2023). Slider. [Online] Jqueryui. Available at: https://jqueryui.com/slider/#range [Accessed 29th March 2023].
Code Purpose: To display and set default values for the slider and update the slider values and positions when the user interacts with them. 
Code Modifications: Adding the Slide and change functions to update the values above the labels when whilst the user is interacting with them.
Line Range Of Referenced Code: 9 to 45.
*/

// Define default values for the slider.
$(function () {
    var min = 1,
        max = 1000,
        minVal = 1,
        maxVal = 1000,
        step = 1;

    $("#price-range-slider").slider({
        range: true,
        min: min,
        max: max,
        step: step,
        values: [minVal, maxVal],
        // Updates the values and position as the user is moving the thumbs.
        slide: function (event, ui) {
            // Update the label text based of position of the minimum and maximum thumbs.
            $(".min-value").html("£" + ui.values[0]);
            $(".max-value").html("£" + ui.values[1]);
            var min_value = ui.values[0];
            var max_value = ui.values[1];
            // Calculate the position of the handles and adjust the label positions accordingly
            var leftOffset =
                $(
                    "#price-range-slider .ui-slider-handle:first-of-type"
                ).position().left + 0;
            $(".min-value").css("left", leftOffset + "px");

            var rightOffset =
                $(
                    "#price-range-slider .ui-slider-handle:last-of-type"
                ).position().left + 0;
            $(".max-value").css("left", rightOffset + "px");

            // Update the hidden inputs with the current values
            $("#price_range_min").val(min_value);
            $("#price_range_max").val(max_value);
        },
        // Updates the position and values of the labels once the user has finished moving the thumbs.
        change: function (event, ui) {
            // Update the label text
            $(".min-value").html("£" + ui.values[0]);
            $(".max-value").html("£" + ui.values[1]);

            // Calculate the position of the handles and adjust the label positions accordingly
            var leftOffset =
                $(
                    "#price-range-slider .ui-slider-handle:first-of-type"
                ).position().left + 0;
            $(".min-value").css("left", leftOffset + "px");

            var rightOffset =
                $(
                    "#price-range-slider .ui-slider-handle:last-of-type"
                ).position().left + 0;
            $(".max-value").css("left", rightOffset + "px");
        },
    });

    // Set the initial label text, position and thumb text.
    $(".min-value").html("£" + $("#price-range-slider").slider("values", 0));
    $(".max-value").html("£" + $("#price-range-slider").slider("values", 1));
    var leftOffset =
        $("#price-range-slider .ui-slider-handle:first-of-type").position()
            .left + 0;
    $(".min-value").css("left", leftOffset + "px");

    var rightOffset =
        $("#price-range-slider .ui-slider-handle:last-of-type").position()
            .left + 0;
    $(".max-value").css("left", rightOffset + "px");

    // Add labels for the minimum and maximum values
    $("#price-range-slider").prepend(
        "<div class='min-label'>Min: £" + min + "</div>"
    );
    $("#price-range-slider").append(
        "<div class='max-label'>Max: £" + max + "</div>"
    );
});
