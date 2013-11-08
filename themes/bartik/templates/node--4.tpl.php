<?php


?>
<link href="../<?php print_r($directory); ?>/css/dms.css" rel="stylesheet">
<script src="../<?php print_r($directory); ?>/js/dms.js" type="text/javascript"></script>

 <div id="dm-content" class="content clearfix"<?php print $content_attributes; ?>>
   
   <div id="side-left">
      <div id="side-top">
       <div id="side-role">
          <h3>Role</h3>
          
		    <input type="radio" name="role" id="pi" />
		     <label for="pi"><img src="../<?php print_r($directory); ?>/images/role_pi.png"></label> 
		    <input type="radio" name="role" id="r" />
		     <label for="r"><img src="../<?php print_r($directory); ?>/images/role_r.png"></label>
		    <input type="radio" name="role" id="dm" />
		     <label for="dm"><img src="../<?php print_r($directory); ?>/images/role_dm.png"></label>    
		  
        </div> 
        <div id="side-when" class="when">
          <h3>When</h3>
          <input type="radio" name="when" id="1" />
		   <label for="1"> <div>Decisions while designing </div></label> 
		  <input type="radio" name="when" id="2" />
		   <label for="2"> <div>Management of research processes</div></label>
		  <input type="radio" name="when" id="3" />
		   <label for="3"> <div>Delivery of research products</div></label>

        </div>   
      </div>
      <div id="side-bot">
         
      </div>
   </div>
   <div id="side-right" class="what">
     <h3>What</h3> 
     <input type="radio" name="what" id="1" />
	  <label for="1"> <div>1. Research Protocols </div></label> 
	 <input type="radio" name="what" id="2" />
	  <label for="2"> <div>2. Data Management Policies & Plans</div></label> 
	 <input type="radio" name="what" id="3" />
	  <label for="3"> <div>3. Budgeting & Planning </div></label> 
	 <input type="radio" name="what" id="4" />
	  <label for="4"> <div>4. Data Ownership </div></label> 
	 <input type="radio" name="what" id="5" />
	  <label for="5"> <div>5. Data & Document Storage </div></label> 
	 <input type="radio" name="what" id="6" />
	  <label for="6"> <div>6. Archiving & Sharing </div></label> 
	 <input type="radio" name="what" id="7" />
	  <label for="7"> <div>7. CCAFS Data Portals </div></label> 
	 <input type="radio" name="what" id="8" />
	  <label for="9"> <div>8. Data Quality & Organisation </div></label>        
     
     
   </div>
 </div>

 <div class="content clearfix"<?php print $content_attributes; ?>>
    <?php
      print render($content);
    ?>
 </div>

