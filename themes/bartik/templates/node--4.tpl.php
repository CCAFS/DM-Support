<?php


?>
<link href="../<?php print_r($directory); ?>/css/dms.css" rel="stylesheet">
<script src="../<?php print_r($directory); ?>/js/dms.js" type="text/javascript"></script>

 <div id="dm-content" class="content clearfix"<?php print $content_attributes; ?>>
   
   <div id="side-left">
      <div id="side-top">
       <div id="side-role">
          <h3>Role</h3>
          
		    <input type="radio" name="role" id="pi" value="1" />
		     <label for="pi"><img src="../<?php print_r($directory); ?>/images/role_pi.png"><br>Principal Investigator </label> 
		     
		    <input type="radio" name="role" id="r" value="2" />
		     <label for="r"><img src="../<?php print_r($directory); ?>/images/role_r.png"><br>Researcher</label>
		     
		    <input type="radio" name="role" id="dm" value="3" />
		     <label for="dm"><img src="../<?php print_r($directory); ?>/images/role_dm.png"><br>Data Manager </label>    
		  	 
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
      		<img id="icon-role" src="../<?php print_r($directory); ?>/images/role-checked.png">
      		<img id="icon-when" src="../<?php print_r($directory); ?>/images/when-checked.png">
      		<img id="icon-what" src="../<?php print_r($directory); ?>/images/what-checked.png">
 			</div>
 		</div>
      	<div id="step2" >
      		<h2>Guidelines Recommended</h2>
      		<div id="result"></div>
      		<div id="guidelines"></div>
		</div> 
      </div>
   </div>
   <div id="side-right" class="what">
     <h3>What</h3> 
     <input type="radio" name="what" id="1" value="1"/>
	  <label for="1"> <div>1. Research Protocols </div></label> 
	 <input type="radio" name="what" id="2" value="2"/>
	  <label for="2"> <div>2. Data Management Policies & Plans</div></label> 
	 <input type="radio" name="what" id="3" value="3"/>
	  <label for="3"> <div>3. Budgeting & Planning </div></label> 
	 <input type="radio" name="what" id="4" value="4"/>
	  <label for="4"> <div>4. Data Ownership </div></label> 
	 <input type="radio" name="what" id="5" value="5"/>
	  <label for="5"> <div>5. Data & Document Storage </div></label> 
	 <input type="radio" name="what" id="6" value="6"/>
	  <label for="6"> <div>6. Archiving & Sharing </div></label> 
	 <input type="radio" name="what" id="7" value="7"/>
	  <label for="7"> <div>7. CCAFS Data Portals </div></label> 
	 <input type="radio" name="what" id="8" value="8"/>
	  <label for="8"> <div>8. Data Quality & Organisation </div></label>        
     
     
   </div>
 </div>

 <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      print render($content);
    ?>
 </div>

