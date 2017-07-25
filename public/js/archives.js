/*
 * introduition des codes js dans le programme
 */

var attribut_i = 0;
/*
$(document).ready(function () {
    $("#msgCount").load("");
    var refreshId = setInterval(function () {
        $("#msgCount").load("");
    }, 120000);
    $.ajaxSetup({
        cache: false
    });
});
*/
function KeyPress()
    {
        total = document.getElementById("message").value.length+1;
         document.getElementById("compteur").innerHTML ="1sms ("+ total+" Car)";
        document.getElementById("nbre").value = "1";
        if(total > 160){ 
            document.getElementById("compteur").innerHTML = "2sms("+ total+" Car)";
            document.getElementById("nbre").value = "2";
        }if(total> 320){
            document.getElementById("compteur").innerHTML = "3sms("+ total+" Car)";
            document.getElementById("nbre").value = "3";
        }
        if(total> 480){
            document.getElementById("compteur").innerHTML = "4sms("+ total+" Car)";
            document.getElementById("nbre").value = "4";
        } if(total> 640){
            document.getElementById("compteur").innerHTML = "5sms("+ total+" Car)";
            document.getElementById("nbre").value = "5";
        }if(total> 800){
            document.getElementById("compteur").innerHTML = "6sms("+ total+" Car)";
            document.getElementById("nbre").value = "6";
        } if(total> 960){
            document.getElementById("compteur").innerHTML = "7sms("+ total+" Car)";
            document.getElementById("nbre").value = "7";
        }
    }




$(document).ready(function () {
    $('#addDoc').click(function (e) {
        e.preventDefault();
        attribut_i++;
        //alert(attribut_i);
        var obj_tableau = document.getElementById("tableau_doc");
        var arrayLignes = obj_tableau.rows;
        var nbr_de_lignes = arrayLignes.length;
        var nouvelleLigne = obj_tableau.insertRow(nbr_de_lignes - 1);
        var colonne1 = nouvelleLigne.insertCell(0);
        //colonne1.innerHTML = "document " + i;
        var colonne2 = nouvelleLigne.insertCell(1);
        colonne2.innerHTML += '<span class="col-md-6">' + '<input type="text" name="descfile[]" class="form-control" placeholder="description fichier" required="">' + '</span>' +
                '<span class="col-md-3">' + '<input type="file" name="fichier[]"></span><br>';

        if (attribut_i == "4") {
            $('#bloc-button').empty();
        }

    });


    /*
     * fonction d'ajout du modele de message
     */

    $('.inserer').click(function (e) {
        e.preventDefault();

        var smsmodel = this.name;
        $('#message').val("" + smsmodel + "");
    });
    /*
     * fonction d'ajout du modele de message
     */

    $('.inserer-contact').click(function (e) {
        e.preventDefault();

        var contact = this.name;
        var destinataire=  $('#destinataire').val();
        if (destinataire == " "){
        $('#destinataire').val(destinataire +"" + contact + "");
        }else{
        $('#destinataire').val(destinataire +";" + contact + "");
         }
    });

    /*
     * fonction d'ajout d'un groupe
     */

    $('#newGroupe').on('submit', function (e) {
        e.preventDefault();

        var nomgroup = $('#nomgroupe').val();
        if (nomgroup === "") {
            $('.notification').empty();
            $('.notification').html("<div class='alert alert-danger'> Le champ classe ne peut être vide </div>");
        } else {
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                dataType: "json",
            }).success(function (data) {
                var isSuccess = data.success !== undefined ? data.success : false;
                var msg = data.msg !== undefined ? data.msg : "";
                var idgroupe = data.id !== undefined ? data.id : null;
                if (isSuccess) {
                    $(".notification").empty();
                    $(".notification").html("<div class='alert alert-success col-md-12'>" + msg + "</div>");
                    $('.select-goup').append('<option value=' + idgroupe + '>' + nomgroup + '</option>').add();
                    $('.tabl-groupe').append("<tr class='table-responsive table-striped'>" +
                            " <td class='col-md-8'>" + nomgroup + "</td>" +
                            "<td class='col-md-2'>" +
                            "<a href='#' class='btn btn-sm btn-default'><i class='fa fa-pencil'></i>&nbsp;modifier</a>" +
                            "</td>" +
                            "<td class='col-md-2'>" +
                            "<a href='#' class='btn btn-sm btn-danger'><i class='fa fa-remove'></i>&nbsp; supprimer</a>" +
                            " </td>" +
                            "</tr> " +
                            "<tr><td colspan='3'>&nbsp;</td></tr>").add();
                    $("#nomgroupe").val(" ");


                } else if (msg.length > 0) {
                    $(".notification").html("<div class='alert alert-danger col-md-12'>" + msg + "</div>");
                }
            }).error(function (xhr) {
                alert(xhr.responseText);
                console.log(xhr.responseText);
            });
        }
    });


    /*
     * function de suppression groupe
     */
    $(".delete-groupe").click(function (ev) {
        ev.preventDefault();
        ltarget = ev;
        console.log(ev);
        $.ajax({
            url: $(this).attr("href"),
            dataType: 'json'
        }).success(function (data) {
            var isSuccess = data.success !== undefined ? data.success : false;
            var msg = data.msg !== undefined ? data.msg : "";

            if (isSuccess) {
                $("#notification").html("<div class='alert alert-success'>" + msg + "</div>");
                $(this).closest("tr").remove();
            } else if (msg.length > 0) {
                $("#notification").html("<div class='alert alert-danger'>" + msg + "</div>");
            }
        }).error(function (xhr) {
            alert(xhr.responseText);
            console.log(xhr.responseText);
        });
    });


/*
 * code de formatage de la corbeille
 */

$('.formatDrash').click(function(ev){
    ev.preventDefault();
        
    $.ajax({
                url: $(this).attr('href'),
                //type: $(this).attr('method'),
                data: $(this).serialize(),
                dataType: "json",
            }).success(function (data) {
                var isSuccess = data.success !== undefined ? data.success : false;
                var msg = data.msg !== undefined ? data.msg : "";
               
                if (isSuccess) {
                    $(".conten-corb").empty();
                    $(".conten-corb").append("<tr><td colspan='7' align='center' height='50%'>votre corbeille est vide</td></tr>").add();
                   
                } else if (msg.length > 0) {
                    $(".notification").html("<div class='alert alert-danger col-md-12'>" + msg + "</div>");
                }
            }).error(function (xhr) {
                alert(xhr.responseText);
                console.log(xhr.responseText);
            });
});


});
