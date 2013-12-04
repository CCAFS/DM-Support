<?php


?>

<link href="./<?php print_r($directory); ?>/css/dms.css" rel="stylesheet">
<script src="./<?php print_r($directory); ?>/js/dms.js" type="text/javascript"></script>
<link rel="stylesheet" href="./<?php print_r($directory); ?>/libs/colorbox-master/example2/colorbox.css" />
<script src="./<?php print_r($directory); ?>/libs/colorbox-master/jquery.colorbox.js"></script>




 <div id="dm-content" class="content clearfix"<?php print $content_attributes; ?>>
   
   <div id="side-left">
      <div id="side-top">
       <div id="side-role">
          <h3>Role</h3>
          
		    <input type="radio" name="role" id="r1" value="1" />
		     <label for="r1"><img src="./<?php print_r($directory); ?>/images/role_pi.png"><br>Principal Investigator </label> 
		     
		    <input type="radio" name="role" id="r2" value="2" />
		     <label for="r2"><img src="./<?php print_r($directory); ?>/images/role_r.png"><br>Researcher</label>
		     
		    <input type="radio" name="role" id="r2" value="3" />
		     <label for="r2"><img src="./<?php print_r($directory); ?>/images/role_dm.png"><br>Data Manager </label>    
		  	 
        </div> 
        <div id="side-when" class="when">
          <h3>When</h3>
          <input type="radio" name="when" id="dwd" value="1" />
		   <label for="dwd"> <div>Decisions while designing </div></label> 
		  <input type="radio" name="when" id="mrp" value="2"/>
		   <label for="mrp"> <div>Management of research processes</div></label>
		  <input type="radio" name="when" id="drp" value="3"/>
		   <label for="drp"> <div>Delivery of research products</div></label>

        </div>   
      </div>
      <div id="side-bot"> 
      	<div id="step1" >
      		<h2>Select the 3 options</h2>
      		<div id="step1-icons" >
      		<img id="icon-role" src="./<?php print_r($directory); ?>/images/role-checked.png">
      		<img id="icon-when" src="./<?php print_r($directory); ?>/images/when-checked.png">
      		<img id="icon-what" src="./<?php print_r($directory); ?>/images/what-checked.png">
 			</div>
 		</div>
      	<div id="step2" >
      		<h2>Guidelines Recommended</h2>
      		<div id="result"></div> 
      		<div id="guidelines"></div>
          <div id="ajax-loader" style="display:none"><img src="./<?php print_r($directory); ?>/images/loader.gif"></div>
          <span class="error" style="display: none;">Please check a file.</span>
          <div style="height:27px;">
            <a class="icon-flow" href="./<?php print_r($directory); ?>/images/full_diagram.png">
              <img id="icon-flow" src="./<?php print_r($directory); ?>/images/flow.png">
            </a>
            <a class="icon-table" href="./<?php print_r($directory); ?>/images/table-c.png">
              <img id="icon-table" src="./<?php print_r($directory); ?>/images/table.png">
            </a>
        		<a class="download 1">Download documents</a>
      		</div>
         
  
          
		</div> 
		<div id="step3" >
      		<h2>Terms and conditions</h2>
      		<div id="step3-form" >
	      		<p>Please fill the following form in order to be able to download the files. All form fields are required.</p>
	      		Email: <input type="text" id="mail" name="mail" value=""/> <br>
	      		<span class="error" style="display: none;">Please enter a valid email address.</span>
	      		<br><a class="download 2">Download documents</a>
 			</div>
 		</div>
 		<div id="step4" >
      		<h2>Terms and conditions</h2>
      		<div id="step4-form" >
      			<div id="side-form1">
      				<div class="left"><label for='first_name'>First name</label> <input type="text" id="first_name" name="first_name" value=""/> </div>
              <div class="right"><label for='last_name'>Last name:</label> <input type="text" id="last_name" name="last_name" value=""/> </div>
      				<div class="left" style="clear: both;"><label for='institute-name'>Institute name:</label> <input type="text" id="institute-name" name="institute-name" value=""/> </div>

      				
      			</div>
      			<div id="side-form2">
      				
      				
      				<div class="left">
      				<h4>Region(s) of your research interes: </h4><br>

      				<input name='research-regions' class='css-checkbox-regions' id='l1' value="africa" type='checkbox'>
      					<label for='l1' class='css-label-regions'>Africa</label><br>
      				<input name='research-regions' class='css-checkbox-regions' id='l2' value="asia" type='checkbox'>
      					<label for='l2' class='css-label-regions'>Asia</label><br>
      				<input name='research-regions' class='css-checkbox-regions' id='l3' value="oceania" type='checkbox'>
      					<label for='l3' class='css-label-regions'>Australia and Oceania</label><br>
      				<input name='research-regions' class='css-checkbox-regions' id='l4' value="central_america_caribbean" type='checkbox'>
      					<label for='l4' class='css-label-regions'>Central America and the Caribbean</label><br>
      				<input name='research-regions' class='css-checkbox-regions' id='l5' value="middle_east_north_africa" type='checkbox'>
      					<label for='l5' class='css-label-regions'>Middle East and North Africa</label><br>
      				<input name='research-regions' class='css-checkbox-regions' id='l6' value="north_america" type='checkbox'>
      					<label for='l6' class='css-label-regions'>North America</label><br>
      				<input name='research-regions' class='css-checkbox-regions' id='l7' value="south_america"  type='checkbox'>
      					<label for='l7' class='css-label-regions'>South America</label><br>
      				<input name='research-regions' class='css-checkbox-regions' id='l8' value="europe"  type='checkbox'>
      					<label for='l8' class='css-label-regions'>Europe</label><br>	
              </div>
              <div class="right">
              <h4>Region(s) where your institute is located: </h4><br>

              <input name='institute-regions' class='css-checkbox-regions' id='i1' value="africa" type='checkbox'>
                <label for='i1' class='css-label-regions'>Africa</label><br>
              <input name='institute-regions' class='css-checkbox-regions' id='i2' value="asia" type='checkbox'>
                <label for='i2' class='css-label-regions'>Asia</label><br>
              <input name='institute-regions' class='css-checkbox-regions' id='i3' value="oceania" type='checkbox'>
                <label for='i3' class='css-label-regions'>Australia and Oceania</label><br>
              <input name='institute-regions' class='css-checkbox-regions' id='i4' value="central_america_caribbean" type='checkbox'>
                <label for='i4' class='css-label-regions'>Central America and the Caribbean</label><br>
              <input name='institute-regions' class='css-checkbox-regions' id='i5' value="middle_east_north_africa" type='checkbox'>
                <label for='i5' class='css-label-regions'>Middle East and North Africa</label><br>
              <input name='institute-regions' class='css-checkbox-regions' id='i6' value="north_america" type='checkbox'>
                <label for='i6' class='css-label-regions'>North America</label><br>
              <input name='institute-regions' class='css-checkbox-regions' id='i7' value="south_america" type='checkbox'>
                <label for='i7' class='css-label-regions'>South America</label><br>
              <input name='institute-regions' class='css-checkbox-regions' id='i8' value="europe" type='checkbox'>
                <label for='i8' class='css-label-regions'>Europe</label><br>    
              </div>  
      			</div>
      			<div id="side-form3">
      				Intended use of data: <br>
      				<textarea id="use" name="use" cols="40" rows="5"></textarea>
      				<input type="hidden" id="user-id" name="userId" value="">
      			</div> 
            <span class="error" style="display: none;"></span>
      			<br><a class="download 3">Download documents</a>
 			</div>
 		</div>
 		<div id="step5" >
      		<h2>Download</h2>
      		<div id="result"></div>
      		<div id="guidelines"></div> 
      		<br><a href="" class="download 4">See more documents</a>
		</div> 
      </div>
   </div>
   <div id="side-right" class="what">
     <h3>What</h3> 
     <input type="radio" name="what" id="c0" value="0"/>
	  <label for="c0"> <div>0. Data Management Strategy </div></label> 
     <input type="radio" name="what" id="c1" value="1"/>
	  <label for="c1"> <div>1. Research Protocols </div></label> 
	 <input type="radio" name="what" id="c2" value="2"/>
	  <label for="c2"> <div>2. Data Management Policies & Plans</div></label> 
	 <input type="radio" name="what" id="c3" value="3"/>
	  <label for="c3"> <div>3. Budgeting & Planning </div></label> 
	 <input type="radio" name="what" id="c4" value="4"/>
	  <label for="c4"> <div>4. Data Ownership </div></label> 
	 <input type="radio" name="what" id="c5" value="5"/>
	  <label for="c5"> <div>5. Data & Document Storage </div></label> 
	 <input type="radio" name="what" id="c6" value="6"/>
	  <label for="c6"> <div>6. Archiving & Sharing </div></label> 
	 <input type="radio" name="what" id="c7" value="7"/>
	  <label for="c7"> <div>7. CCAFS Data Portals </div></label> 
	 <input type="radio" name="what" id="c8" value="8"/>
	  <label for="c8"> <div>8. Data Quality & Organisation </div></label>        
     
     
   </div>
 </div>

 <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      print render($content);
    ?>
 </div>

