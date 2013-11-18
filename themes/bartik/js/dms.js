jQuery(document).ready(function ($) {
	$('#dm-content input:radio').addClass('input_hidden');
	$('#dm-content label').click(function() {
	    $(this).addClass('selected').siblings().removeClass('selected');
	});

	var role,when,what;

	// Step 1
 	$("input:radio").change(function(){ 
 		if (verify()==3){
 			$("#step1").css("display", "none");
			$("#step2").css("display", "block");

			var Data = getData(); console.log(Data);
			var results = 'Result: <b>Role</b> '+role+', <b>When</b> '+when+', <b>What</b> '+what; 
				
			var content = '<ul>';
			Data.forEach(function(entry) { 
				content += "<li>";
				content += entry.name;
				content += "<span class='level "+entry.importance_level+"'>"+entry.importance_level+"</span>";
				content += "</li>";	 
            });
            content += '</ul>';
            $( "#step2 #result" ).html(results);
            $( "#step2 #guidelines" ).html(content);
 		}
	});
 	function getData(){
 		role = $('input[name=role]:checked', '#side-role').val();
 		when = $('input[name=when]:checked', '#side-when').val();
		what = $('input[name=what]:checked', '#side-right').val();
		Data = (function() {
			    var json = null;
			    $.ajax({
			       'async': false,
			       'global': false,
			       'url': '../themes/bartik/json.php',
			       'type': "GET",
  				   'data': { r : role,
  				   			 s : when,
  				   			 c : what },
			       'dataType': "json",
			       'success': function(data) {
			          json = data;
			       }
			    });
			    return json;
		 })();
		return Data; 	
 	}
	function verify(){
		var count = 0;
		if($("input:radio[name=role]").is(":checked")){
			$("img#icon-role").addClass("selected");
			count++; 
		}
	 	if($("input:radio[name=when]").is(":checked")){
	 		$("img#icon-when").addClass("selected");
			count++; 
		}
	 	if($("input:radio[name=what]").is(":checked")){
	 		$("img#icon-what").addClass("selected");
			count++; 
		}
	 	return count
	}

});