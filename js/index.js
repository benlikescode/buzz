
//Changing Navbar when user scrolls

const changeBackground = () => {
    if (window.scrollY >= 60) {
        $("nav").css("boxShadow", "0 1rem 2rem rgba(0, 0, 0, 0.3)");
        $("nav").css("transition", ".1s ease-in 0s");
    }
    else {
        $("nav").css("boxShadow", "0 1rem 2rem rgba(0, 0, 0, 0.1)");
        $("nav").css("transition", ".1s ease-out 0s");
    }
}

window.addEventListener('scroll', changeBackground);

// On Attend Button Click

$(document).on("click", ".attend-event-btn", function() {
    var attendclick = true;
    var eventtoken = $(this).parent().parent().attr("data-event-token");
    var thisButton = $(this);
    $.ajax({

        type: "POST",
        url: "controllers/eventController.php",
        data: {
            attendclick: attendclick,
            eventtoken: eventtoken
        },

        success: function(response) {
            console.log(response["content"]);
            if (response["result"] == "loggedin") {
                $(thisButton).html(response["content"]);
            }
            else if (response["result"] == "notloggedin") {
                if ($(".modal-container").length == 0) {
                    $("body").append(response["content"]);
                }
                else {
                    $(".modal-container").remove();
                    $("body").append(response["content"]);
                }
                $("body").css("overflow-y", "hidden");
            }
             
        }

    });
});

// Creating a function to close the modal and calls it when the catch div or close button are clicked

function closeModal() {
    $(".modal-container").remove();
    $("body").css("overflow-y", "auto");
}

$(document).on("click", ".modal-click-catcher", function() {
    closeModal();
});

$(document).on("click", ".close-modal-btn", function() {
    closeModal();
});

// Loading in the events from DB

var loadEvents = true;

$.ajax({

    type: "POST",
    url: "controllers/eventController.php",
    data: {

        loadEvents: loadEvents

    },

    success: function(response) {
        $(".load-events-grid").html(response);
    }
});