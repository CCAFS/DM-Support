/**
*  This file is part of Data Management Support Pack (DMSP).
*
*  DMSP is free software: you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation, either version 3 of the License, or
*  at your option) any later version.
*
*  DMSP is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with DMSP.  If not, see <http://www.gnu.org/licenses/>.
*
* Copyright 2014 (C) Climate Change, Agriculture and Food Security (CCAFS)
* 
* Created on : 20-12-2013
* @author      Sebastian Amariles Garcia (CIAT/CCAFS)
* @version     1.0
*/


// If this document is in a subdomain of ccafs.cgiar.org change 
// the value
if(document.domain.indexOf("ccafs.cgiar.org") != -1){
    document.domain = 'ccafs.cgiar.org';
}

var themePath = './themes/bartik/',
    downloadPath = 'http://www.reading.ac.uk/ssc/resource-packs/dms/',
    currentStep = 1, 
    ls = localStorage,
    dataLoaded,
    guideSelected,
    filterType, 
    timeoutID,
    role,when,what,
    roleText,whenText,whatText;

jQuery(document).ready(function ($) { 

    updateDataHeight();
    
    $('#dm-content input:radio').addClass('input_hidden');
    $('#dm-content label').click(function() { 
        $(this).addClass('selected').siblings().removeClass('selected');
    });  
    $('#icon-flow,#icon-table').powerTip({
        followMouse: true
    }); 
   
    // ================================================================// 
    //                            Key Events                           //
    // ================================================================// 

    //Event when input search was typed
    $( "#search" ).keyup(function() { 
      if(($("#search").val()).length > 1) {
            if(timeoutID) clearTimeout(timeoutID);  
            // Start a timer that will search when finished
            timeoutID = setTimeout(searchKeyword, 800);
        } else{
            allEnable(); 
            if(currentStep==1)$("#step1").fadeIn(700);
            if(currentStep==2)$("#step2").fadeIn(700);
            $("#search-content").hide();
            $("#search-results").html("");
            updateDataHeight();
        } 
    });

    // ================================================================// 
    //                           Clic Events                           //
    // ================================================================//  

    // Step 1 (Select the 3 options )
    $("input:radio").click(radioChangeEvent); 
    // Step 3 (Terms and conditions) email contact
    $( "a.download.1" ).click(function() {  
        filterType = $(this).attr("id");
        if($("input:checkbox[name=check]").is(":checked") || $("input:checkbox[name=check-search]").is(":checked")) { 
            $("#step3").show().siblings().hide();
            $("#search").attr("disabled", "disabled");
            $("input[name=mail]").val(localStorage.getItem('email'));
            allDisable(); 
            updateDataHeight();
        } else { 
            $("#step2 .error").css("display", "block");
        }
        
    });
    
    $( "a.download.5" ).click(function() {   
        guideSelected = new Array(); 
        guideSelected[0] = {
                            id: 999, 
                            name: "Data Management Support [Full package]", 
                            type: 3, 
                            source: "http://www.reading.ac.uk/ssc/resources/ccafs_data_management_support_pack.pdf", 
                            importance_level: "Optional"
                        } 
        $("#step3").show().siblings().hide();
        $("#search").attr("disabled", "disabled");
        allDisable(); 
        updateDataHeight();
    });
    
    // Step 4 (Terms and conditions) form contact
    $( "a.download.2" ).click(function() {  
        var email =$("input[name=mail]").val();
        ls.setItem('email', email);
        if( validateEmail(email)  ) { 
            loadUser(email); 
            $("#step4").show().siblings().hide(); 
            updateDataHeight();
        } else { 
            $("#step3-form .error").css("display", "block");
        }
        
    });

    // Step 5 (Links for download)
    $( "a.download.3" ).click(function() { 
    var verifiedText = verifyFields(); 
        if (verifiedText.length) {
            $("#step4-form .error").html('Please fill out the information in the following fields :<br>'+verifiedText); 
            $("#step4-form .error").css("display", "block");
        }else {
            setDownload();
            $("#step4").css("display", "none"); $("#step5").css("display", "block"); 
            printGuidelinesToDownload();
            loaderStop();
             
        }       
    });

    // skip-form (Links for download)
    $("#skip-form").on("click", function(event) { 
        event.preventDefault(); 
        //console.log("skip-form"); 
        $("#step5").show().siblings().hide(); 
        printGuidelinesToDownload();
        loaderStop();
         
    });   

    // ==================================================================// 
    //                           General Functions                       //
    // ==================================================================// 

    function loaderStop() {
        $(".dmspLoader").removeClass("loading").fadeOut();
        updateDataHeight();
    }
    function loaderStart() {
      $(".dmspLoader").addClass("loading").fadeIn();
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
                    $("#institute-name").val(data.institute); 

                    // Institute Locations
                    if(data.i_africa == 1) $("#i1").attr('checked', true);
                    if(data.i_asia == 1) $("#i2").attr('checked', true);
                    if(data.i_oceania == 1) $("#i3").attr('checked', true);
                    if(data.i_central_america_caribbean == 1) $("#i4").attr('checked', true);
                    if(data.i_europe == 1) $("#i8").attr('checked', true);
                    if(data.i_middle_east_north_africa == 1) $("#i5").attr('checked', true);
                    if(data.i_north_america == 1) $("#i6").attr('checked', true);
                    if(data.i_south_america == 1) $("#i7").attr('checked', true);
                    // Research Locations
                    if(data.r_africa == 1) $("#l1").attr('checked', true);
                    if(data.r_asia == 1) $("#l2").attr('checked', true);
                    if(data.r_oceania == 1) $("#l3").attr('checked', true);
                    if(data.r_central_america_caribbean == 1) $("#l4").attr('checked', true);
                    if(data.r_europe == 1) $("#l8").attr('checked', true);
                    if(data.r_middle_east_north_africa == 1) $("#l5").attr('checked', true);
                    if(data.r_north_america == 1) $("#l6").attr('checked', true);
                    if(data.r_south_america == 1) $("#l7").attr('checked', true);                         
                } 

            },
            'complete': function(data) { 
                loaderStop();
            }
        });
    }

    function setDownload(){
        arrayInstituteRegions = [];
        $("input[name^='institute-regions']:checked").each(function(index) {
            arrayInstituteRegions[index] = $(this).val();
        });
        arrayResearchRegions = [];
        $("input[name^='research-regions']:checked").each(function(index) {
            arrayResearchRegions[index] = $(this).val();
        });
        arrayguideSelected = [];
        guideSelected.forEach(function(entry,index,array) { 
            arrayguideSelected[index] = entry.id
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
                researchRegions: arrayResearchRegions,
                use: $("#use").val(),
                ftype: filterType,
                guideSelected: arrayguideSelected
            },
            beforeSend: function(){
                ga('send', 'event', 'Users', 'download', $("#mail").val());
                ga('send', 'event', 'Institute', 'download', $("#institute-name").val());
            },
            success: function(downloadId) { 
            },
            'complete': function(data) { 
                loaderStop();
            },
        });
    }
    // ----- END Ajax Functions ----- //

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
    function verifyFields(){ 
        var verified = '';
        // Validate first name.
        if($("#first_name").is(":visible") && $("#first_name").val() == "") {
            verified += '* First name <br>';
            $("#first_name").css("background-color", "#FF9999");
        } else {
            $("#first_name").css("background-color", "");
        }
        // Validate last name.
        if($("#last_name").is(":visible") && $("#last_name").val() == "") {
            verified += '* Last name <br>';
            $("#last_name").css("background-color", "#FF9999");
        } else {
            $("#last_name").css("background-color", "");
        }
        // Validate institute name.
        if($("#institute-name").val() == "") {
            verified += '* Institute name <br>';
            $("#institute-name").css("background-color", "#FF9999");
        } else {
            $("#institute-name").css("background-color", "");
        }
        // Validate institute locations.
        if($("input[name^='institute-regions']:checked").length == 0) {
            verified += '* Region(s) where your institute is located <br>';
            $(".institute-regions .group-label").css("color", "red");
        } else {
            $(".institute-regions .group-label").css("color", "");
        }
        // Validate research locations.
        if($("input[name^='research-regions']:checked").length == 0) {
            verified += '* Region(s) of your research interes <br>';
            $(".research-regions .group-label").css("color", "red");
        } else {
            $(".research-regions .group-label").css("color", "");
        }
        // Validate intended use.
        if($("#use").val() == "") {
            verified += '* Intended use of data <br>';
            $("#use").css("background-color", "#FF9999");
        } else {
            $("#use").css("background-color", "");
        }
        return verified;

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
            $(this).attr('disabled', true);
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.addClass('selected');
        });
        $("input[name=when]").each(function(i) { 
            $(this).attr('disabled', true);
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.addClass('selected');

        });
        $("input[name=what]").each(function(i) { 
            $(this).attr('disabled', true);
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.addClass('selected');
        });
     }
     function allEnable() {

        $('#dm-content label').bind('click'); 
        $('#dm-content input:radio').addClass('input_hidden');
        $('#dm-content label').click(function() { 
            $(this).addClass('selected').siblings().removeClass('selected');
        }); 

        $("input[name=role]").each(function(i) { 
            $(this).attr('disabled', false);
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.removeClass( "selected" );
        });
        $("input[name=when]").each(function(i) {
            $(this).attr('disabled', false); 
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.removeClass( "selected" );

        });
        $("input[name=what]").each(function(i) {
            $(this).attr('disabled', false); 
            var label = $("label[for='"+$(this).attr('id')+"']");
            label.removeClass( "selected" );
        });
        updateSelects();
     }  

    function radioChangeEvent(){
        if (verify()==3){ 
            $("#step2").fadeIn().siblings().hide(); 

            // Step 2 (Guidelines Recommended)
            currentStep = 2;   
            role = $('input[name=role]:checked', '#side-role').val();
            when = $('input[name=when]:checked', '#side-when').val();
            what = $('input[name=what]:checked', '#side-right').val();
            
            // Load guidelines and show depending of Role, When and What selected
            $.ajax({ 
               'url': themePath+'json.php',
               'type': "POST",
               'data': { context : "guidelines-lvl",
                         r : role,
                         s : when,
                         c : what },
               'dataType': "json",
               beforeSend: function(){  
                loaderStart(); 
               },
               'success': function(data) {
                    dataLoaded= data;
                    updateSelects();  
                    results = 'Result: <b>Role</b> '+roleText+', <b>When</b> '+whenText+', <b>What</b> '+whatText;  
                    $( "#step2 #result" ).html(results);
                    //Google Analytics custom events
                    ga('send', 'event', 'Role', 'interested', roleText);
                    ga('send', 'event', 'When', 'interested', whenText);
                    ga('send', 'event', 'What', 'interested', whatText);

                    content = printGuidelinesToPreview(data,1); 
                    $( "#step2 #guidelines" ).html(content).hide().fadeIn(); 

                    //Set Colorbox to preview document 
                    setColorbox($(".preview"));
               },
               'complete': function(data) {  
                    updateGuideSelected("check");
                    updateDataHeight();
                    loaderStop();
               }
            });  
        } 
    } 
    function searchKeyword(){  
        allDisable();  
        var keyword = $("#search").val();

        // Load guidelines and show depending on keyword typed
        $.ajax({ 
            'url': themePath+'json.php',
            'type': "POST",
            'data': { context: "guidelines-search",
                     q : keyword },
            'dataType': "json",
            beforeSend: function(){  
                loaderStart(); 
            },
            'success': function(data) {
                dataLoaded= data;
                content = printGuidelinesToPreview(data,2);  
                $("#search-results").html(content);

                //Set Colorbox to preview document 
                setColorbox($(".preview"));

                $("#search-content").css("display", "block");
                if(currentStep==1)$("#step1").hide();
                if(currentStep==2)$("#step2").hide();
                updateGuideSelected("check-search");
           },
           complete: function(){
                loaderStop();
                //Google Analytics custom events
                ga('send', 'event', 'Search', 'search', keyword);
           }
        });    
        
    }
    function printGuidelinesToPreview(data,type){
        var c = 0;
        content = ""; 
        content += '<ul>'; 
        data.forEach(function(entry) {  
            var typeText,icon; 
            if (entry.type == 2){
                typeText = '(Video)';
                icon = themePath+'images/video.png';
                downloadLink = "https://www.youtube.com/embed/"+youtube_parser($.trim(entry.source))+"?rel=0&wmode=transparent";
            } else{
                downloadLink = "http://docs.google.com/viewer?url="+downloadPath+encodeURIComponent($.trim(entry.source))+"&embedded=true";
                icon = themePath+'images/guide.png';
                typeText = '';
            }
            //Filtered
            if (type == 1){
                content += "<li>";
                content += "    <img src='"+icon+"'>";
                content += "    <input name='check' class='css-checkbox' id='"+c+"' type='checkbox'>";
                content += "    <label for='"+c+"' class='css-label'>"+entry.name+" "+typeText+"</label>";
                content += "    <a class='preview' href='"+downloadLink+"'><strong>Preview</strong></a>";
                content += "    <span class='level "+entry.importance_level+"'>"+entry.importance_level+"</span>";
                content += "</li>";   
            }
            //Searched
            if (type == 2){
                content += "<li>";
                content += "    <img src='"+icon+"'>";
                content += "    <input name='check-search' class='css-checkbox' id='"+c+"' type='checkbox'>";
                content += "    <label for='"+c+"' class='css-label'>"+entry.name+" "+typeText+"</label>";
                content += "    <a class='preview' href='"+downloadLink+"'><strong>Preview</strong></a>";
                content += "</li>";  
            }
            
            c++;
        });
       if(data.length <1)content += "Results not found";
       content += '</ul>';  
       return content;
    }

    function printGuidelinesToDownload(){
        var content = '<ul>';
        guideSelected.forEach(function(entry) { 
            ga('send', 'event', 'Guidelines', 'downloaded', entry.name);
            var icon = themePath+'images/guide.png',
                downloadText = ' Download',
                className = '',
                downloadLink = themePath+'download.php?file='+downloadPath+encodeURIComponent($.trim(entry.source));
            // Video    
            if (entry.type == 2) {
                icon = themePath+'images/video.png';
                downloadText = ' Watch';
                className = ' preview-video';
                downloadLink = "https://www.youtube.com/embed/"+youtube_parser($.trim(entry.source))+"?rel=0&wmode=transparent"; 
            }
            // Data Management Support [Full package]
            if (entry.type == 3) { 
                downloadLink = themePath+'download.php?file='+encodeURIComponent($.trim(entry.source));
            }
            content += "<li>";
            content += "    <img src='"+icon+"'>"; 
            content += "    <a class='downloadLink "+className+"' href='"+downloadLink+"' >"+entry.name;
            content += "    <span class='download' style='float:right'><img src='"+themePath+"images/dl.png'>"+downloadText+"</span></a>";
            content += "</li>";
        });
        content += '</ul>';
        $( "#step5 #guidelines" ).html(content);  

        //Set Colorbox to preview document 
        setColorbox($('.preview-video'));
    }   

    /* This event is when the Checkbox was Selected or Unselected
       and fill a array guideSelected with new list selected      */
    function updateGuideSelected(name){  
        $("input[name^='"+name+"']").change(function() {
                guideSelected = new Array();
                $("input[name^='"+name+"']:checked").each(function(i) { 
                    guideSelected[i] = dataLoaded[$(this).attr('id')];
                });   
                //console.log(guideSelected);
            });
    }

    function updateSelects(){
            if(role == 1) {roleText='Principal Investigator';            $("label[for=r1]").addClass("selected");}
            if(role == 2) {roleText='Researcher';                        $("label[for=r2]").addClass("selected");}
            if(role == 3) {roleText='Data Manager';                      $("label[for=r3]").addClass("selected");}

            if(when == 1) {whenText='Decisions while designing';         $("label[for=dwd]").addClass("selected");}
            if(when == 2) {whenText='Management of research processes';  $("label[for=mrp]").addClass("selected");}
            if(when == 3) {whenText='Delivery of research products';     $("label[for=drp]").addClass("selected");}

            if(what == 0) {whatText='Data Management Strategy';          $("label[for=c0]").addClass("selected");}
            if(what == 1) {whatText='Research Protocols';                $("label[for=c1]").addClass("selected");}
            if(what == 2) {whatText='Data Management Policies & Plans';  $("label[for=c2]").addClass("selected");}
            if(what == 3) {whatText='Budgeting & Planning ';             $("label[for=c3]").addClass("selected");}
            if(what == 4) {whatText='Data Ownership';                    $("label[for=c4]").addClass("selected");}
            if(what == 5) {whatText='Data & Document Storage';           $("label[for=c5]").addClass("selected");}
            if(what == 6) {whatText='Metadata, Archiving & Sharing';     $("label[for=c6]").addClass("selected");}
            if(what == 7) {whatText='CCAFS Data Portals';                $("label[for=c7]").addClass("selected");}
            if(what == 8) {whatText='Data Quality & Organisation';       $("label[for=c8]").addClass("selected");}
    }

    function getWindowHeight(){
        return $("#block-system-main .content").height();
    }

    function updateDataHeight(){
        // Update the attribute data-height in the body tag
        $("body").attr("data-height", getWindowHeight());
    }

    function setColorbox(element){
        $(element).colorbox({iframe:true, width:"80%", height:"80%"}); 
        $(element).bind('click', function(){
            var name = $(this).parent().find("label").html();
            //Google Analytics custom events
            ga('send', 'event', 'Guidelines', 'preview', name);
        }); 
    }

});

function youtube_parser(input){
    return input.match(/(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/user\/\S+|\/ytscreeningroom\?v=|\/sandalsResorts#\w\/\w\/.*\/))([^\/&]{10,12})/)[1]; 
}
