$(document).ready(function(){
    $("p").click(function(){
        $(this).hide();
    });


$('#add-form').click(function() {
     i++;
      $('#add-me').append(
         '<tbody id="row'+i+'"><tr>'+
           '<td class="col-md-2">'+
              '<input id="quantity" onkeypress="return event.charCode >= 48 && event.charCode <=57" type="text" name="quantity[]" class="form-control"/>'
          +'</td>'
          +'<td class="col-md-7">'
              +'<input type="text" name="description[]" class="form-control"/>'
          +'</td>'
          +'<td class="col-md-3">'
              +'<input type="text" name="selling_price[]" class="form-control" />'
          +'</td>'
          +'<td class="col-md-2">'
              +'<button id="'+i+'" type="button" class="btn btn-danger delegated-btn">Delete</button>'
          +'</td>'
      +'</tr></tbody>'
      );
});

});
