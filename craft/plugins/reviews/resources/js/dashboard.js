$(document).ready(function() {

    $("#issuerToDelete").change(function() {
        var url = Craft.getActionUrl('reviews/review/issuerProducts'),
            issuer_id = $(this).val();

        sendAjax(issuer_id, url, "#issuerToDeleteProducts")
    });

    $("#issuerToDisable").change(function() {

        var url = Craft.getActionUrl('reviews/review/issuerProducts'),
            issuer_id = $(this).val();

        sendAjax(issuer_id, url, "#issuerToDisableProducts")

    });

    var sendAjax = function(issuer_id, url, objectId) {

        $(objectId).find('option')
            .remove()
            .end()
            .append('<option value="all">All Products</option>');

        if(issuer_id == '' || issuer_id == 'all') {
            return false;
        }

        $.ajax({
            type: "GET",
            url: url,
            data: {issuer_id : issuer_id},
            success: function(data) {
                var object = $(objectId);
                $.each(data, function(i, item) {
                    object.append("<option value="+item+">"+item+"</option>");
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("ERROR: " + xhr.status + " " + thrownError);
            }
        })
    };

    $("#uploadReviews").submit(function(e) {
        e.preventDefault();

        var url = Craft.getActionUrl('reviews/review/upload');

        var files = $(this).find("[name=file]")[0].files,
            issuer = $(this).find('#issuer').val(),
            formdata = new FormData(),
            file,
            reader;

        if(issuer == '') {
            alert('You must select an Issuer!');
            return false;
        }

        if(files.length == 0) {
            alert('You must select a file to upload');
            return false;
        }

        formdata.append('issuer', issuer);

        for (var i = 0; i < files.length; i++) {
            file = files[i];

            if (window.FileReader) {
                reader = new FileReader();
                reader.readAsDataURL(file);
            }
            formdata.append("files[]", file);
        }

        $("#output").html("Uploading...");

        $.ajax({
            type: "POST",
            url: url,
            data: formdata,
            processData: false,
            contentType: false,
            success: function(json) {
                window.json = json;
                console.log(json);

                var errors = json['errors'],
                    success = json['success'],
                    html = "<p><b>" + errors.length + " errors, " + success.length + " successfully uploaded</b></p>";

                $("#output").html(html);

                $('form').trigger('reset');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("ERROR: " + xhr.status + " " + thrownError);
            }
        });

        return false;
    });

    $("#disableReviews").submit(function(e) {
        e.preventDefault();
        var issuer = $('#issuerToDisable').val(),
            msg = 'Are you sure you wish to disable all '+issuer+' reviews?';

        if(issuer == '') {
            alert('You must select an Issuer!');
            return false;
        }
        else if(issuer == 'all') {
            msg = 'Are you sure you wish to disable ALL reviews?';
        }

        var proceed = confirm(msg);

        if(proceed == true) {
            var url = Craft.getActionUrl('reviews/review/disable')

            $.post(url, { issuer: issuer},
                function(response){
                    if(response['success']) {
                        html = "<p><strong>" + response['found'] +" reviews successfully disabled.</strong></p>";
                    }
                    else {
                        html = "<p><strong>Error occurred trying to disable reviews.</strong></p>";
                    }
                    $("#issuerToDisableOutput").html(html);
                });
        }
    });

    $("#deleteReviews").submit(function(e) {
        e.preventDefault();
        var issuer = $('#issuerToDelete').val(),
            msg = 'Are you sure you wish to delete all '+issuer+' reviews?';
        if(issuer == '') {
            alert('You must select an Issuer!');
            return false;
        }
        else if(issuer == 'all') {
            msg = 'Are you sure you wish to delete ALL reviews?';
        }

        var proceed = confirm(msg);

        if(proceed == true) {
            var url = Craft.getActionUrl('reviews/review/delete')

            $.post(url, { issuer: issuer},
                function(response){
                    if(response['success']) {
                        html = "<p><strong>" + response['count'] +" successfully deleted.</strong></p>";
                    }
                    else {
                        html = "<p><strong>Error occurred trying to delete reviews.</strong></p>";
                    }
                    $("#issuerToDeleteOutput").html(html);
                });
        }
    });
});