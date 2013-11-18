jQuery(document).ready(function ($) {
	$('#dm-content input:radio').addClass('input_hidden');
	$('#dm-content label').click(function() {
	    $(this).addClass('selected').siblings().removeClass('selected');
	});

	var role,when,what;
	var themepath = '../themes/bartik/';
	// Step 1
 	$("input:radio").change(function(){ 
 		if (verify()==3){
 			$("#step1").css("display", "none");
			$("#step2").css("display", "block");

			var Data = getData(); console.log(Data);
			if(role == 1) role='Principal Investigator';
			if(role == 2) role='Researcher';
			if(role == 3) role='Data Manager';

			if(when == 1) when='Decisions while designing';
			if(when == 2) when='Management of research processes';
			if(when == 3) when='Delivery of research products';

			if(what == 0) what='Data Management Strategy';
			if(what == 1) what='Research Protocols';
			if(what == 2) what='Data Management Policies & Plans';
			if(what == 3) what='Budgeting & Planning ';
			if(what == 4) what='Data Ownership';
			if(what == 5) what='Data & Document Storage';
			if(what == 6) what='Archiving & Sharing';
			if(what == 7) what='CCAFS Data Portals';
			if(what == 8) what='Data Quality & Organisation'; 

			var results = 'Result: <b>Role</b> '+role+', <b>When</b> '+when+', <b>What</b> '+what; 
				
			var content = '<ul>';
			Data.forEach(function(entry) { 
				var icon = themepath+'images/guide.png';
				if (entry.type == 2) icon = themepath+'images/video.png';
				content += "<li>";
				content += "<img src='"+icon+"'>"+entry.name;
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
			       'url': themepath+'json.php',
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