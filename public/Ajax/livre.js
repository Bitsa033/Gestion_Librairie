function insertLivre(insertlink,updatelink) {
    $(document).ready(function () {
        //alert('m')
        
        $("#insert").click(function (e) {
            e.preventDefault()
            var auteur = $('#auteur').val()
            var nom = $('#nom').val()
            var id = $('#id').val()
            var genre = $('#genre').val()
            var nb = $('#nb').val()
            var annee = $('#annee').val()
            
            $.ajax({
                url: insertlink,
                method: "POST",
                data: { auteur:auteur,nom:nom,genre:genre,nb:nb,annee:annee},
                success: function (data) {
                    //console.log(data);
                    // $('#quickForm')[0].reset()
                    //$('.table').load(location.href+' .table-bordered')
                    $('.message').html(data.message)
                    // console.log(data.message);
                    // setInterval(() => {
                    //     location.href
                    // }, 3000);
                    if (data.icon=="success") {
                        $('.message').css("color","green")
                    }
                    if (data.icon=="error"){

                        $('.message').css("color","red")
                    }
                    //swal("Good job!", data.message, data.icon)
                },
                error: function (textStatus) {
                    console.log(textStatus)
                }
    
            })
    
        })

        // ........modification........................

        $("#update").click(function (e) {
            e.preventDefault()
            
            $.ajax({
                url: updatelink,
                method: "POST",
                data: { auteur:auteur,nom:nom,genre:genre,nb:nb,annee:annee,id:id},
                success: function (data) {
                    $('.message').html(data.message)
                    if (data.icon=="success") {
                        $('.message').css("color","green")
                    }
                    if (data.icon=="error"){

                        $('.message').css("color","red")
                    }
                    
                },
                error: function (textStatus) {
                    console.log(textStatus)
                }
    
            })
    
        })

    
    })
}