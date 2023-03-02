var form = $("#example-form");
form.validate({
    errorPlacement: function errorPlacement(error, element) {
        element.before(error);
    },
    rules: {
        confirm: {
            equalTo: "#password",
        },
    },
});
form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex) {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex) {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex) {
        //alert("Submitted!");
        $(document).ready(function () {
            var nom = $('#nom').val()
            var genre = $('#genre').val()
            var anneeEdition = $('#anneeEdition').val()
            var quantite = $('#quantite').val()
            var auteur = $('#auteur').val()
            $.ajax({
                url: "addLivre",
                method: "POST",
                data: { nom: nom, genre: genre,anneeEdition:anneeEdition,quantite:quantite,auteur:auteur },
                success: function (data) {
                    console.log(data);
                    // setInterval(() => {
                    //     location.href = "/"
                    // }, 3000);
                    
                    //swal("Good job!", data.message, data.icon)
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(textStatus)
                }

            })

        })
    },
});