<?php require_once('Connections/MS.php'); ?>

<?php

// Load the common classes
require_once('includes/common/KT_common.php');

// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");

// Make unified connection variable
$conn_MS = new KT_connection($MS, $database_MS);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("fn", true, "text", "", "", "", "Please enter your first name.");
$formValidation->addField("ln", true, "text", "", "", "", "Please enter your last name.");
$formValidation->addField("email", true, "text", "email", "", "", "Your email doesn't look right. Please check it.");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{email}");
  $emailObj->setTo("info@magicalstrings.com");
  $emailObj->setCC("ray@cgrconsulting.org");
  $emailObj->setBCC("");
  $emailObj->setSubject("School registration from website");
  //WriteContent method
  $emailObj->setContent("Hi,\n{fn} {ln} has filled out the school registration form on the website. The information they provided is below.\n\n{cont_id}\nEmail: {email}\nAddress 1: {addr1}\nAddress 2: {addr2}\nCity {city}\nState {state}\nZip {zip}\nPhone {phone}\nExt {phone_ext}\nComment {comment}<br>\nClass location {location}<br>\nExperience level {level}<br>\nWants to rent? {rent}<br>\nInterested in harp {harp_type}<br>\nInterested in case {case_type}<br>\n\n{fn} {ln} has been sent an email telling them you will be in touch soon.\n\nLove from your website form.\n");
  $emailObj->setEncoding("ISO-8859-1");
  $emailObj->setFormat("Text");
  $emailObj->setImportance("Normal");
  return $emailObj->Execute();
}
//end Trigger_SendEmail trigger

//start Trigger_SendEmail1 trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail1(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("info@magicalstrings.com");
  $emailObj->setTo("{email}");
  $emailObj->setCC("ray@cgrconsulting.org");
  $emailObj->setBCC("");
  $emailObj->setSubject("Your Magical Strings class registration");
  //WriteContent method
  $emailObj->setContent("Hello {fn} {ln},\nWe have received your website registration for our Celtic harp classes. We will be in touch with you shortly.\n\nSincerely,\nPhilip Boulding\nMagical Strings\n(253) 857-3716");
  $emailObj->setEncoding("ISO-8859-1");
  $emailObj->setFormat("Text");
  $emailObj->setImportance("Normal");
  return $emailObj->Execute();
}
//end Trigger_SendEmail1 trigger

// Make an insert transaction instance
$ins_school = new tNG_insert($conn_MS);
$tNGs->addTransaction($ins_school);
// Register triggers
$ins_school->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_school->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_school->registerTrigger("END", "Trigger_Default_Redirect", 99, "Thank_you_Comment.html");
$ins_school->registerTrigger("AFTER", "Trigger_SendEmail", 98);
$ins_school->registerTrigger("AFTER", "Trigger_SendEmail1", 98);
// Add columns
$ins_school->setTable("school");
$ins_school->addColumn("fn", "STRING_TYPE", "POST", "fn");
$ins_school->addColumn("ln", "STRING_TYPE", "POST", "ln");
$ins_school->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_school->addColumn("addr1", "STRING_TYPE", "POST", "addr1");
$ins_school->addColumn("addr2", "STRING_TYPE", "POST", "addr2");
$ins_school->addColumn("city", "STRING_TYPE", "POST", "city");
$ins_school->addColumn("state", "STRING_TYPE", "POST", "state");
$ins_school->addColumn("zip", "STRING_TYPE", "POST", "zip");
$ins_school->addColumn("phone", "STRING_TYPE", "POST", "phone");
$ins_school->addColumn("phone_ext", "STRING_TYPE", "POST", "phone_ext");
$ins_school->addColumn("comment", "STRING_TYPE", "POST", "comment");
$ins_school->addColumn("location", "STRING_TYPE", "POST", "location");
$ins_school->addColumn("level", "STRING_TYPE", "POST", "level");
$ins_school->addColumn("rent", "CHECKBOX_YN_TYPE", "POST", "rent", "N");
$ins_school->addColumn("harp_type", "STRING_TYPE", "POST", "harp_type");
$ins_school->addColumn("case_type", "STRING_TYPE", "POST", "case_type");
$ins_school->setPrimaryKey("cont_id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsschool = $tNGs->getRecordset("school");
$row_rsschool = mysql_fetch_assoc($rsschool);
$totalRows_rsschool = mysql_num_rows($rsschool);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Magical Strings - Class Registration</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<style type="text/css">
.style11 {font-family: Arial}
</style>
</head>

<body background="Images/Background-Gold.gif">
<div align="center"><span class="nav"><a href="/index.html"><strong>Home</strong></a><strong> | <a href="/Recordings.html">Recordings</a> | <a href="/Calendar.html">Calendar</a> | <a href="/SchoolIndex.html">School
        Of Magical Strings</a> | <a href="/HarpsDulcimers.html">Harps & Dulcimers</a> | <a href="/News.html">News</a> | <a href="/Reviews.html">Reviews</a> | <a href="/Bio.html">Bio</a> | <a href="/Links.html">Links</a> | <a href="/Form_Contact.php">Contact
        Us</a></strong></span><br />
 <br />
</div>
    <table width="69%" align="center">
      <tr>
        <td width="65%" valign="top"><img src="Images/MSHeader-Background.gif" width="600" height="91"><br>
          <table width="100%">
            <tr>
              <td><div align="center"><font size=5 face="Arial, Geneva, Helvetica" color="#333366"><b><font size="6">Class
              Registration</font></b></font></div></td>
            </tr>
          </table>
          <br>
          <table width="85%">
            <tr>
              <td><font face="Arial, Helvetica, sans-serif">To pay by <b>check</b> please
                  fill in the following information and mail us your <br>
$10 registration fee (and $80 harp rental if needed) to secure your place in
class and your harp. The class fee after registration is $150,.<br>
(The registration fee is non-refundable)<br>
To pay your registration fee (and harp rental) using <img src="Images/padlock.gif" width="19" height="22"><b> PayPal, VISA
or Mastercard</b><br>
<b>skip this form and <a href="Form_School_Reg_Online.html">Click
Here</a></b></font></td>
            </tr>
        </table>          
          <p><span class="KT_field_error">*</span> = required information<br>
</p>
            <?php
	echo $tNGs->getErrorMsg();
?>
          <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
            <table cellpadding="2" cellspacing="0" class="KT_tngtable">
              <tr>
                <td class="KT_th"><label for="fn">First name:</label></td>
                <td><input type="text" name="fn" id="fn" value="<?php echo KT_escapeAttribute($row_rsschool['fn']); ?>" size="40" />
                    <?php echo $tNGs->displayFieldHint("fn");?> <?php echo $tNGs->displayFieldError("school", "fn"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="ln">Last name:</label></td>
                <td><input type="text" name="ln" id="ln" value="<?php echo KT_escapeAttribute($row_rsschool['ln']); ?>" size="40" />
                    <?php echo $tNGs->displayFieldHint("ln");?> <?php echo $tNGs->displayFieldError("school", "ln"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="email">Email:</label></td>
                <td><input type="text" name="email" id="email" value="<?php echo KT_escapeAttribute($row_rsschool['email']); ?>" size="40" />
                    <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("school", "email"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="addr1">Address 1:</label></td>
                <td><input type="text" name="addr1" id="addr1" value="<?php echo KT_escapeAttribute($row_rsschool['addr1']); ?>" size="32" />
                    <?php echo $tNGs->displayFieldHint("addr1");?> <?php echo $tNGs->displayFieldError("school", "addr1"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="addr2">Address 2:</label></td>
                <td><input type="text" name="addr2" id="addr2" value="<?php echo KT_escapeAttribute($row_rsschool['addr2']); ?>" size="10" />
                    <?php echo $tNGs->displayFieldHint("addr2");?> <?php echo $tNGs->displayFieldError("school", "addr2"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="city">City:</label></td>
                <td><input type="text" name="city" id="city" value="<?php echo KT_escapeAttribute($row_rsschool['city']); ?>" size="40" />
                    <?php echo $tNGs->displayFieldHint("city");?> <?php echo $tNGs->displayFieldError("school", "city"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="state">State:</label></td>
                <td><input type="text" name="state" id="state" value="<?php echo KT_escapeAttribute($row_rsschool['state']); ?>" size="5" />
                    <?php echo $tNGs->displayFieldHint("state");?> <?php echo $tNGs->displayFieldError("school", "state"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="zip">Zip:</label></td>
                <td><input type="text" name="zip" id="zip" value="<?php echo KT_escapeAttribute($row_rsschool['zip']); ?>" size="32" />
                    <?php echo $tNGs->displayFieldHint("zip");?> <?php echo $tNGs->displayFieldError("school", "zip"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="phone">Phone:</label></td>
                <td><input type="text" name="phone" id="phone" value="<?php echo KT_escapeAttribute($row_rsschool['phone']); ?>" size="15" />
                    <?php echo $tNGs->displayFieldHint("phone");?> <?php echo $tNGs->displayFieldError("school", "phone"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="phone_ext">Ext:</label></td>
                <td><input type="text" name="phone_ext" id="phone_ext" value="<?php echo KT_escapeAttribute($row_rsschool['phone_ext']); ?>" size="10" />
                    <?php echo $tNGs->displayFieldHint("phone_ext");?> <?php echo $tNGs->displayFieldError("school", "phone_ext"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="comment">Comment or question:</label></td>
                <td><textarea name="comment" cols="70" rows="10" id="comment"><?php echo KT_escapeAttribute($row_rsschool['comment']); ?></textarea>
                    <?php echo $tNGs->displayFieldHint("comment");?> <?php echo $tNGs->displayFieldError("school", "comment"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="location">Class location:</label></td>
                <td><select name="location" id="location">
                    <option value="Olalla" <?php if (!(strcmp("Olalla", KT_escapeAttribute($row_rsschool['location'])))) {echo "SELECTED";} ?>>Olalla</option>
                    <option value="Seattle" <?php if (!(strcmp("Seattle", KT_escapeAttribute($row_rsschool['location'])))) {echo "SELECTED";} ?>>Seattle</option>
                    <!--<option value="Bellevue" <?php //if (!(strcmp("Bellevue", KT_escapeAttribute($row_rsschool['location'])))) {echo "SELECTED";} ?>>Bellevue</option>-->
                    <!--<option value="Bremerton" <?php if (!(strcmp("Olalla", KT_escapeAttribute($row_rsschool['location'])))) {echo "SELECTED";} ?>>Bremerton</option>-->
                  </select>
                    <?php echo $tNGs->displayFieldError("school", "location"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="level">My playing level:</label></td>
                <td><select name="level" id="level">
                    <option value="nothing selected" <?php if (!(strcmp("nothing selected", KT_escapeAttribute($row_rsschool['level'])))) {echo "SELECTED";} ?>>Select one</option>
                  <option value="Beginner" <?php if (!(strcmp("Beginner", KT_escapeAttribute($row_rsschool['level'])))) {echo "SELECTED";} ?>>Beginner</option>
                    <option value="Intermediate" <?php if (!(strcmp("Intermediate", KT_escapeAttribute($row_rsschool['level'])))) {echo "SELECTED";} ?>>Intermediate</option>
                  </select>
                    <?php echo $tNGs->displayFieldError("school", "level"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="rent"> <span class="style1"> I want to rent a harp</span> </label></td>
                <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsschool['rent']),"Y"))) {echo "checked";} ?> type="checkbox" name="rent" id="rent" value="Y" />                <?php echo $tNGs->displayFieldError("school", "rent"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="harp_type">Harp type I'm<br>
                interested in:</label></td>
                <td><select name="harp_type" id="harp_type">
                    <option value="nothing selected" <?php if (!(strcmp("nothing selected", KT_escapeAttribute($row_rsschool['harp_type'])))) {echo "SELECTED";} ?>>Select one</option>
                  <option value="Tristy $460" <?php if (!(strcmp("Tristy $460", KT_escapeAttribute($row_rsschool['harp_type'])))) {echo "SELECTED";} ?>>Tristy $460</option>
                    <option value="Concert Oladion $2,400" <?php if (!(strcmp("Concert Oladion $2,400", KT_escapeAttribute($row_rsschool['harp_type'])))) {echo "SELECTED";} ?>>Concert Oladion $2,400</option>
                    <option value="Oladion $560" <?php if (!(strcmp("Oladion $560", KT_escapeAttribute($row_rsschool['harp_type'])))) {echo "SELECTED";} ?>>Oladion $560</option>
                    <option value="Concert Kailey $1,600" <?php if (!(strcmp("Concert Kailey $1,600", KT_escapeAttribute($row_rsschool['harp_type'])))) {echo "SELECTED";} ?>>Concert Kailey $1,600</option>
                  </select>
                    <?php echo $tNGs->displayFieldError("school", "harp_type"); ?> </td>
              </tr>
              <tr>
                <td class="KT_th"><label for="case_type">Case type I'm<br>
                interested in
                :</label></td>
                <td><select name="case_type" id="case_type">
                    <option value="nothing selected" <?php if (!(strcmp("nothing selected", KT_escapeAttribute($row_rsschool['case_type'])))) {echo "SELECTED";} ?>>Select one</option>
                  <option value="Lap harp case $160" <?php if (!(strcmp("Lap harp case $160", KT_escapeAttribute($row_rsschool['case_type'])))) {echo "SELECTED";} ?>>Lap harp case $160</option>
                    <option value="Concert Harp Case $260" <?php if (!(strcmp("Concert Harp Case $260", KT_escapeAttribute($row_rsschool['case_type'])))) {echo "SELECTED";} ?>>Concert Harp Case $260</option>
                  </select>
                    <?php echo $tNGs->displayFieldError("school", "case_type"); ?> </td>
              </tr>
              <tr class="KT_buttons">
                <td>&nbsp;</td>
                <td><div align="left">
                  <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Send" />
                </div></td>
              </tr>
            </table>
          </form>
          <table width="77%" border="0">
            <tr>
              <td width="30%"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Wingdings;
mso-bidi-font-family:Arial">q</span> <b><span style="font-size:10.0pt;
font-family:Arial">Registration Fee</span></b></font></td>
              <td width="14%"><div align="right"><font size="2" face="Arial, Geneva, Helvetica"><b><span style="font-size:10.0pt;
font-family:Arial">$10<font color="#FFFFFF"></font></span></b></font></div></td>
              <td width="56%">&nbsp;</td>
            </tr>
            <tr>
              <td width="30%"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Wingdings;
mso-bidi-font-family:Arial">q</span><b><span style="font-family:Arial"> School 
                Fee</span></b></font></td>
              <td width="14%"><div align="right"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Arial">$ 
                1</span></font><span class="style11"><font size="2">5</font></span><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Arial">0</span></font></div></td>
              <td width="56%">&nbsp;</td>
            </tr>
            <tr>
              <td width="30%"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Wingdings;mso-bidi-font-family:Arial">q</span><b><span style="font-family:Arial"> Instrument Rental</span></b></font></td>
              <td width="14%"><div align="right"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:
Arial">$ 80</span></font></div></td>
              <td width="56%">&nbsp;</td>
            </tr>
            <tr>
              <td width="30%"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Wingdings;mso-bidi-font-family:Arial">q</span><b><span style="font-family:Arial"> </span></b><span style="font-family:Arial">Tristy Harp</span></font></td>
              <td width="14%"><div align="right"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Arial">$ 
                4</span></font><font size="2"><span style="font-family:Arial">6</span></font><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Arial">0</span></font></div></td>
              <td width="56%">&nbsp;</td>
            </tr>
            <tr>
              <td width="30%"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Wingdings;mso-bidi-font-family:Arial">q</span><b><span style="font-family:Arial"> </span></b><span style="font-family:Arial">Oladion Harp</span></font></td>
              <td width="14%"><div align="right"><font size="2" face="Arial, Helvetica, sans-serif"><span style="font-family:Arial">$ 
                5</span></font><font size="2"><span style="font-family:Arial">6</span></font><font size="2" face="Arial, Helvetica, sans-serif"><span style="font-family:Arial">0</span></font></div></td>
              <td width="56%">&nbsp;</td>
            </tr>
            <tr>
              <td width="30%"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Wingdings;mso-bidi-font-family:Arial">q</span><b><span style="font-family:Arial"> </span></b><span style="font-family:Arial">Lap Harp Case</span></font></td>
              <td width="14%"><div align="right"><font size="2" face="Arial, Geneva, Helvetica"><span style="font-family:Arial">$</span></font><font size="2"><span style="font-family:Arial">190</span></font></div></td>
              <td width="56%">&nbsp;</td>
            </tr>
          </table>
          <p>&nbsp;</p>
<table width="100%">
          <tr>
            <td><b><font face="Arial, Helvetica, sans-serif">Other Ways to contact
                  us - <br>
                  Mail</font>:</b><br>
              <font face="Arial, Helvetica, sans-serif">PO Box 1240<br>
Olalla, WA 98359</font></td>
            <td><font face="Arial, Geneva, Helvetica"><b>Tel:</b></font><font size="2" face="Arial, Geneva, Helvetica"><br>
            </font><font face="Arial, Geneva, Helvetica">253 857-3716</font></td>
            <td></td>
          </tr>
        </table>        
        </td>
        <td width="35%" valign="top"><div align="center"><font size=5 face="Arial, Geneva, Helvetica" color="#333366"><b>School
                of Magical Strings<br>
        </b></font>
          </div>
          <table width="100%">
            <tr>
              <td><div align="center"><img src="Images/Wheel100.gif" width="101" height="101"></div></td>
            </tr>
          </table>
          <table width="100%">
                <tr>
                  <td valign="middle"><p align="center"><font face="Arial, Helvetica, sans-serif">Mail registration
                        deposit to:</font>
                    <p align="center"><font face="Arial, Helvetica, sans-serif">Magical Strings<br>
                      </font><font face="Arial, Helvetica, sans-serif">PO Box
                      1240<br>
  Olalla, WA 98359</font><font size=2 face="Arial, Geneva, Helvetica"> <br>
  <br>
  <b><font size="4">OR</font></b><br>
  </font><font size=2 face="Arial, Geneva, Helvetica"><font size="3"><br>
                      <b><a href="Form_School_Reg_Online.html">Click
                  Here</a></b> to pay online</font></font>                    </td>
                </tr>
          </table>
        <p></td>
      </tr>
</table>
<div align="center">  <span class="nav"><strong><a href="/index.html">Home</a> | <a href="/Recordings.html">Recordings</a> | <a href="/Calendar.html">Calendar</a> | <a href="/SchoolIndex.html">School
        Of Magical Strings</a> | <a href="/HarpsDulcimers.html">Harps & Dulcimers</a> | <a href="/News.html">News</a> | <a href="/Reviews.html">Reviews</a> | <a href="/Bio.html">Bio</a> | <a href="/Links.html">Links</a> | <a href="/Form_Contact.php">Contact
Us</a></strong></span></div>
</body>
</html>
