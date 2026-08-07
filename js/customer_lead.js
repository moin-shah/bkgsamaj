function add2dailer(id){
	$.ajax
	({
		url: 'index.php?r=customerLead/add2dailer',
		data: {"lid":id},
		type: 'POST',
	})
}
function responsehangup(s,st,lid){
    $.ajax({
          url: 'index.php?r=customerLead/sendHangupResponse',       
          type: 'post',
          data: {status: s,sta: st, lead_id: lid},
          success: function (data) {
            alert(data);
            window.close();
         }      
    });
}
function responsehangupcallhippo(s,st,lid){
    console.log("SDff");
    $.ajax({
          url: 'index.php?r=customerLead/sendHangupResponsecallhippo',       
          type: 'post',
          data: {status: s,sta: st, lead_id: lid},
          success: function (data) {
            alert(data);
            window.close();
         }      
    });
}
$(document).ready(function() {
    var $selectAll = $('#checkAll'); 
     $selectAll.on('click', function () {

 

        if($(".checked").length > 0)  
        {
            var chk_all_checked = $(".checker").length;
            //alert(chk_hardik);
            if(chk_all_checked > 0){ 
            $('.checked').each(function(){
                //$(this).addClass('');
                $( ".chk_feature" ).closest( "span" ).attr( "class", "" );
            });
            $('.checked').each(function(){
   $(this).addClass('');
});
            $('input.chk_feature:checkbox').each(function () {
     
        $(".chk_feature").prop('checked', false);
        //$('input:checkbox').prop('checked',true);
         
     });

            }
            if($("#checkAll").prop('checked') == true)
            {
              $( ".chk_feature" ).closest( "span" ).attr( "class", "checked" );

              $('input.chk_feature:checkbox').each(function () {
     
                  $(".chk_feature").prop('checked', true);
        //$('input:checkbox').prop('checked',true);
         
                  });
            } 
        }
        else{
            
            $( ".chk_feature" ).closest( "span" ).attr( "class", "checked" );
               //this.checked = true;

               $('.checked').each(function(){
                  $(this).addClass('checked');
                });



               $('input.chk_feature:checkbox').each(function () {
     
                  $(".chk_feature").prop('checked', true);
        
         
          });
                
        }

        
      
       });
});




    $(document).ready(function() {

        $("button").click(function(){

            var favorite = [];

            $.each($("input[name='CustomerLead[feature][]']:checked"), function(){            

                favorite.push($("label[for='"+this.id+"']").text().trim());

            });
            //alert(favorite);
            $('#CustomerLead_features').val(favorite);
            

            //alert("My favourite sports are: " + favorite.join(", "));

        });

    });

