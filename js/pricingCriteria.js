function maincriterianew(cat)
{
  //alert(cat);
	$.ajax({
  type: "POST",
  url: base_url+"/index.php?r=customerLead/chkCategoryCriteria",
  data: {cat:cat},
  dataType: 'json',
  //cache: false,
  success: function(data){
    
    if(data.label==''){
        $("#user_label_hidden").val(''); 	
        $("#CustomerLead_main_criteria_units").val('');
        //$("#CustomerLead_category_text").attr('value','');
        $("#cat_text").hide();
       	$("#cat_text_div").hide();  	 
       	//$("#lbluser").addClass('col-md-3').removeClass('col-md-2');
       	//$("#div_user_no").addClass('col-md-9').removeClass('col-md-3');
     }else{
    		$("#user_label").html(data.label);
        $("#user_label_hidden").val(data.label);
        //$("#div_user_no").addClass('col-md-3').removeClass('col-md-9');
        //$("#cat_text_div").addClass('col-md-3').removeClass('col-md-9');
        var s = $("<select class=\"form-control\" id=\"CustomerLead_main_criteria_units\" name=\"CustomerLead[main_criteria_units]\" />");
    		 for(var val in data.units) {
    		    $("<option />", {value: data.units[val], text: data.units[val]}).appendTo(s);
    	 	 }
    	   //s.appendTo("#cat_text_div");
         $("#cat_text_div").html(s);
         $("#cat_text_div").show();
         $("#cat_text").show();
     }
     
  }
});
}