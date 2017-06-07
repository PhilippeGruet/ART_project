// Chargement du script
$(function () {
    console.log("JS loaded");

    /*
            home page
    */
    // Affichage des tests sur l'accueil
    $(".category").on("click", function() {

        if ( !( $(this).hasClass("display") ) ) {
            // Hide all other tests and show badges
            $(".tests-list").hide();
            $("a").removeClass("display");;
            $(".badge").show();

            // Show Category's tests
            $(this).parent().children().fadeIn();
            // Hide Category's badge
            $(this).parent().children().last().hide();

            $(this).addClass("display");

        } else {
            // Hide all tests and show badges
            $(".tests-list").hide();
            $(".badge").show();

            $(this).removeClass("display");
        }
    });


    /*
            addQuestion page
    */
    // console.log( $("option:selected", this).parent()[0].label + " : " + $("select").val() );

    // Display only if something is selected
    if ( $("select").val() ) {
        // console.log("Oui");
        // Default display of add category
        if ( ($("option:selected", this).parent()[0].label + " : " + $("select").val()) == "undefined : add") {
            // console.log("Show add category");
            $("#newCategoryDiv").show();
        }

        // Default display of add norme
        if ( $("select").val().substr(0, 3) == "add") {
            // console.log("Show add norme");
            $("#newNormeDiv").show();
        }
    }

    // Action on select norme
    $("select").on("change", function() {
        // console.log( $("option:selected", this).parent()[0].label + " : " + $(this).val() );
        // Add new category
        if ( !( $("option:selected", this).parent()[0].label ) ) {
            $("#newCategoryDiv").fadeIn();
        } else {
            $("#newCategoryDiv").fadeOut();
        }

        // Add new norme
        if ( $(this).val() && $(this).val().substr(0, 3) == "add") {
            $("#newNormeDiv").fadeIn();
        } else {
            $("#newNormeDiv").fadeOut();
        }
    });


});
