jQuery(document).ready(function ($) { 
	$('#dm-content input:radio').addClass('input_hidden');
	$('#dm-content label').click(function() { 
		$(this).addClass('selected').siblings().removeClass('selected');
	});

 
	var guideSelected;
	var role,when,what;
	var themePath = '../themes/bartik/';
	var downloadPath = 'http://www.reading.ac.uk/ssc/resources/';
	// Step 1 (Select the 3 options )
 	$("input:radio").change(function(){ 
 		if (verify()==3){
 			$("#step1").css("display", "none");
			$("#step2").css("display", "block");

			// Step 2 (Guidelines Recommended)
			var Data = getData(); //console.log(Data);
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
			var c = 0;	
			var content = '<ul>';
			Data.forEach(function(entry) { 
				var icon = themePath+'images/guide.png';
				if (entry.type == 2) icon = themePath+'images/video.png';
				content += "<li>";
				content += "	<img src='"+icon+"'>";
				content += "	<input name='check' class='css-checkbox' id='"+c+"' type='checkbox'>";
				content += "	<label for='"+c+"' class='css-label'>"+entry.name+"</label>";
				content += "	<span class='level "+entry.importance_level+"'>"+entry.importance_level+"</span>";
				content += "</li>";	 
				c++;
            });
            content += '</ul>';
            $( "#step2 #result" ).html(results);
            $( "#step2 #guidelines" ).html(content); 

           	$("input[name^='check']").change(function() {
           		guideSelected = new Array();
	            $("input[name^='check']:checked").each(function(i) { 
	                guideSelected[i] = Data[$(this).attr('id')];
	            });
	            
		        
		    });
 		}
 		
	});
	// Step 3 (Terms and conditions)

	$( "a.download.1" ).click(function() {  
		if($("input:checkbox[name=check]").is(":checked")) {
			$("#step2").css("display", "none"); $("#step3").css("display", "block");
			allDisable(); 
		} else { 
            $("#step2 .error").css("display", "block");
        }
		
	});

	// Step 4 (Terms and conditions)
	$( "a.download.2" ).click(function() {  
		var email =$("input[name=mail]").val();
		if( validateEmail(email)  ) { 
			loadUser(email);
            $("#step3").css("display", "none"); $("#step4").css("display", "block"); 
            
        } else { 
            $("#step3-form .error").css("display", "block");
        }
		
	});

	// Step 5 (Download)
	$( "a.download.3" ).click(function() {  
		setDownload();
		$("#step4").css("display", "none"); $("#step5").css("display", "block"); 
		var content = '<ul>';
		guideSelected.forEach(function(entry) { 
			var icon = themePath+'images/guide.png';
			if (entry.type == 2) icon = themePath+'images/video.png';
			content += "<li>";
			content += "	<img src='"+icon+"'>"; 
			content += "	<a class='downloadLink' target='_blank' href='"+downloadPath+entry.source+"' >"+entry.name;
			content += "	<img style='float:right' src='"+themePath+"images/dl.png'></a>";
			content += "</li>";	 
				 
        });
        content += '</ul>';
        
        $( "#step5 #guidelines" ).html(content); 
	});

	// --------------------//
	//  General Functions  //
	// --------------------//

 	function getData(){
 		role = $('input[name=role]:checked', '#side-role').val();
 		when = $('input[name=when]:checked', '#side-when').val();
		what = $('input[name=what]:checked', '#side-right').val();
		Data = (function() {
			    var json = null;
			    $.ajax({
			       'async': false,
			       'global': false,
			       'url': themePath+'json.php',
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
	function validateEmail(emailField) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(emailField == "" || !emailReg.test(emailField)) {
            return false; 
        } else {
            return true; 
        }
    }
	function allDisable() {
		 
		$('#dm-content label').unbind('click'); 
        $("input[name=role]").each(function(i) {
            $(this).attr('disabled', 'disabled');
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.addClass('selected');
        });
        $("input[name=when]").each(function(i) {
            $(this).attr('disabled', 'disabled');
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.addClass('selected');

        });
        $("input[name=what]").each(function(i) {
            $(this).attr('disabled', 'disabled');
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.addClass('selected');
        });
     }
     function loadUser(email) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: themePath+"user-info.php",
            data: {
                context: "user-info",
                email: email
            },
            beforeSend: function(){
                $("#user-id").val("-1");
            },
            success: function(data) {
                data=data[0];
                if(data.email == null) { 
                } else {  
                	$("#user-id").val(data.id);
                    $("#first_name").attr("disabled", "disabled");
                    $("#first_name").val(data.first_name); 
                    $("#last_name").attr("disabled", "disabled");
                    $("#last_name").val(data.last_name); 
                }
               

            }
        });
    }

    function setDownload(){
    		arrayInstituteRegions = new Array();
            $("input[name^='institute-regions']:checked").each(function(index) {
                arrayInstituteRegions[index] = $(this).val();
            });
            arrayResearchRegions = new Array();
            $("input[name^='research-regions']:checked").each(function(index) {
                arrayResearchRegions[index] = $(this).val();
            });

            $.ajax({
                type: "POST",
                dataType: "text",
                url: themePath+"user-info.php",
                data: {
                    context: "submit-user",
                    userId: $("#user-id").val(),
                    email: $("#mail").val(),
                    firstName: $("#first_name").val(),
                    lastName: $("#last_name").val(),
                    instituteName: $("#institute-name").val(),
                    instituteRegions: arrayInstituteRegions,
                    researchRegions: arrayResearchRegions
                    
                },
                beforeSend: function(){
                    $("#submit-user-info").attr("disabled", "disabled");
                    $(".submit-button #ajax-loader").show();
                    $(".submit-button #message").text("Saving...");
                },
                success: function(downloadId) {
                    
                }
            });
    }

});