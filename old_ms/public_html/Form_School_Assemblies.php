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
$formValidation->addField("email", true, "text", "email", "", "", "Your email address doesn't look right. Please check it.");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("info@magicalstrings.com");
  $emailObj->setTo("school@magicalstrings.com");
  $emailObj->setCC("ray@cgrconsulting.org");
  $emailObj->setBCC("");
  $emailObj->setSubject("Contact from the School Assembly & Workshop website form");
  //WriteContent method
  $emailObj->setContent("Hi,\n{fn} {ln} has filled out the School Assembly & Workshop form on the website. The information they provided is below.\n\nContact ID: {cont_id}\nFirst name: {fn}\nLast name: {ln}\nEmail: {email}\nSchool: {school}\nCity {city}\nState {state}\nZip {zip}\nPhone {phone}\nExt {phone_ext}\nInterested in: {interest}\nComment {comment}<br>\n\n{fn} {ln} has been sent an email telling them you will be in touch soon. Don't forget.\n\nLove from your website form.\n");
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
  $emailObj->setSubject("Your Magical Strings inquiry");
  //WriteContent method
  $emailObj->setContent("Dear {fn} {ln},\nThank you for your interest in Magical Strings school programs. We will contact you shortly.\n\nSincerely,\nPhilip & Pam Boulding\nMagical Strings\n(253) 857-3716");
  $emailObj->setEncoding("ISO-8859-1");
  $emailObj->setFormat("Text");
  $emailObj->setImportance("Normal");
  return $emailObj->Execute();
}
//end Trigger_SendEmail1 trigger

// Make an insert transaction instance
$ins_webcontact = new tNG_insert($conn_MS);
$tNGs->addTransaction($ins_webcontact);
// Register triggers
$ins_webcontact->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_webcontact->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_webcontact->registerTrigger("END", "Trigger_Default_Redirect", 99, "Thank_you_Comment.html");
$ins_webcontact->registerTrigger("AFTER", "Trigger_SendEmail", 98);
$ins_webcontact->registerTrigger("AFTER", "Trigger_SendEmail1", 98);
// Add columns
$ins_webcontact->setTable("webcontact");
$ins_webcontact->addColumn("fn", "STRING_TYPE", "POST", "fn");
$ins_webcontact->addColumn("ln", "STRING_TYPE", "POST", "ln");
$ins_webcontact->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_webcontact->addColumn("school", "STRING_TYPE", "POST", "school");
$ins_webcontact->addColumn("city", "STRING_TYPE", "POST", "city");
$ins_webcontact->addColumn("state", "STRING_TYPE", "POST", "state");
$ins_webcontact->addColumn("zip", "STRING_TYPE", "POST", "zip");
$ins_webcontact->addColumn("phone", "STRING_TYPE", "POST", "phone");
$ins_webcontact->addColumn("phone_ext", "STRING_TYPE", "POST", "phone_ext");
$ins_webcontact->addColumn("call_besttime", "STRING_TYPE", "POST", "call_besttime");
$ins_webcontact->addColumn("interest", "STRING_TYPE", "POST", "interest");
$ins_webcontact->addColumn("comment", "STRING_TYPE", "POST", "comment");
$ins_webcontact->setPrimaryKey("cont_id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rswebcontact = $tNGs->getRecordset("webcontact");
$row_rswebcontact = mysql_fetch_assoc($rswebcontact);
$totalRows_rswebcontact = mysql_num_rows($rswebcontact);
?><html>
<head>
<title>School Contact Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>

<body bgcolor="#CCCC99" text="#000000">
<table width="46%" border="0">
  <tr> 
    <td valign="top" width="76%">      <div align="center"><font size=5 face="Arial, Geneva, Helvetica" color="#333366"><b><font size="4">Magical 
        Strings</font><font size="6"><br>
        <font color="333366" size="4" face="Arial, Helvetica, sans-serif">School Assemblies and Workshops</font></font></b></font></div>
    </td>
  </tr>
</table>
<p><font face="Arial, Helvetica, sans-serif">Please fill in the following information and we'll respond quickly.</font></p>
<p>&nbsp;
  <?php
	echo $tNGs->getErrorMsg();
?>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="fn">First name:</label></td>
      <td><input type="text" name="fn" id="fn" value="<?php echo KT_escapeAttribute($row_rswebcontact['fn']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("fn");?> <?php echo $tNGs->displayFieldError("webcontact", "fn"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="ln">Last name:</label></td>
      <td><input type="text" name="ln" id="ln" value="<?php echo KT_escapeAttribute($row_rswebcontact['ln']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("ln");?> <?php echo $tNGs->displayFieldError("webcontact", "ln"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="email">Email:</label></td>
      <td><input type="text" name="email" id="email" value="<?php echo KT_escapeAttribute($row_rswebcontact['email']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("email");?> <?php echo $tNGs->displayFieldError("webcontact", "email"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="school">School:</label></td>
      <td><input type="text" name="school" id="school" value="<?php echo KT_escapeAttribute($row_rswebcontact['school']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("school");?> <?php echo $tNGs->displayFieldError("webcontact", "school"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="city">City:</label></td>
      <td><input type="text" name="city" id="city" value="<?php echo KT_escapeAttribute($row_rswebcontact['city']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("city");?> <?php echo $tNGs->displayFieldError("webcontact", "city"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="state">State:</label></td>
      <td><input type="text" name="state" id="state" value="<?php echo KT_escapeAttribute($row_rswebcontact['state']); ?>" size="5" />
          <?php echo $tNGs->displayFieldHint("state");?> <?php echo $tNGs->displayFieldError("webcontact", "state"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="zip">Zip:</label></td>
      <td><input type="text" name="zip" id="zip" value="<?php echo KT_escapeAttribute($row_rswebcontact['zip']); ?>" size="10" />
          <?php echo $tNGs->displayFieldHint("zip");?> <?php echo $tNGs->displayFieldError("webcontact", "zip"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="phone">Phone:</label></td>
      <td><input type="text" name="phone" id="phone" value="<?php echo KT_escapeAttribute($row_rswebcontact['phone']); ?>" size="15" />
          <?php echo $tNGs->displayFieldHint("phone");?> <?php echo $tNGs->displayFieldError("webcontact", "phone"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="phone_ext">Ext:</label></td>
      <td><input type="text" name="phone_ext" id="phone_ext" value="<?php echo KT_escapeAttribute($row_rswebcontact['phone_ext']); ?>" size="10" />
          <?php echo $tNGs->displayFieldHint("phone_ext");?> <?php echo $tNGs->displayFieldError("webcontact", "phone_ext"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="call_besttime">Best time to call:</label></td>
      <td><input type="text" name="call_besttime" id="call_besttime" value="<?php echo KT_escapeAttribute($row_rswebcontact['call_besttime']); ?>" size="10" />
          <?php echo $tNGs->displayFieldHint("call_besttime");?> <?php echo $tNGs->displayFieldError("webcontact", "call_besttime"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="interest">Please slelect an area of interest:</label></td>
      <td><select name="interest" id="interest">
                    <option value="nothing selected" <?php if (!(strcmp("nothing selected", KT_escapeAttribute($row_rswebcontact['interest'])))) {echo "SELECTED";} ?>>Select one</option>
                    <option value="Workshop" <?php if (!(strcmp("Workshop", KT_escapeAttribute($row_rswebcontact['interest'])))) {echo "SELECTED";} ?>>Workshop</option>
                    <option value="Assembly" <?php if (!(strcmp("Assembly", KT_escapeAttribute($row_rswebcontact['interest'])))) {echo "SELECTED";} ?>>Assembly</option>
                    <option value="Workshop & Assembly" <?php if (!(strcmp("Workshop & Assembly", KT_escapeAttribute($row_rswebcontact['interest'])))) {echo "SELECTED";} ?>>Workshop & Assembly</option>
                  </select>
          <?php echo $tNGs->displayFieldHint("interest");?> <?php echo $tNGs->displayFieldError("webcontact", "interest"); ?> </td>
    </tr>
    <tr>
      <td class="KT_th"><label for="comment">Comment:</label> 
        or question:</td>
      <td><textarea name="comment" id="comment" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rswebcontact['comment']); ?></textarea>
          <?php echo $tNGs->displayFieldHint("comment");?> <?php echo $tNGs->displayFieldError("webcontact", "comment"); ?> </td>
    </tr>
    <tr class="KT_buttons">
      <td>&nbsp;</td>
      <td><div align="left">
        <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Send" />
      </div></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</p>
</body>
</html>
