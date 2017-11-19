function initAjaxForm() {
    $("#updateForm").submit(function(e) {

        var url = $(this).attr("action"); // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: $(this).serialize(), // serializes the form's elements.
               dataType: 'json',
               success: function(data)
               {
                   console.log(data); // show response from the php script.
                   if(!data.isSuccess) {
                       $('#validationError').html(data.errorMessage);
                       return;
                   }
                   $('#listForm').submit();
               }
             });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
}

function showDetailContent(primaryKey, url) {
    $.get(url + primaryKey, {isEmbed: 1}, function(data){
        $('.modal-body').html(data);

        $('#myModal').modal('show');
    });
}