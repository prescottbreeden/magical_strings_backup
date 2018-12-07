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
  $emailObj->setTo("{email}");
  $emailObj->setCC("");
  $emailObj->setBCC("");
  $emailObj->setSubject("Your Magical Strings website contact");
  //WriteContent method
  $emailObj->setContent("Hi {fn} {ln},\nWe've received your contact from our website and will be in touch shortly.\n\nSincerely,\nPhilip Boulding\nMagical Strings\n(253) 857-3716");
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
  $emailObj->setTo("info@magicalstrings.com");
  $emailObj->setCC("");
  $emailObj->setBCC("");
  $emailObj->setSubject("Contact from the website form");
  //WriteContent method
  $emailObj->setContent("Hi,\n{fn} {ln} has filled out the contact form on the website. The information they provided is below.\n\nContact ID{cont_id}\nFirst name; {fn}\nLast name: {ln}\nEmail: {email}\nAddress 1: {addr1}\nAddress 2: {addr2}\nCity {city}\nState {state}\nZip {zip}\nPhone {phone}\nExt {phone_ext}\nComment {comment}<br>\n\n{fn} {ln} has been sent an email telling them you will be in touch soon. Don't forget.\n\nLove from your website form.\n");
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
$ins_webcontact->addColumn("addr1", "STRING_TYPE", "POST", "addr1");
$ins_webcontact->addColumn("addr2", "STRING_TYPE", "POST", "addr2");
$ins_webcontact->addColumn("city", "STRING_TYPE", "POST", "city");
$ins_webcontact->addColumn("state", "STRING_TYPE", "POST", "state");
$ins_webcontact->addColumn("zip", "STRING_TYPE", "POST", "zip");
$ins_webcontact->addColumn("phone", "STRING_TYPE", "POST", "phone");
$ins_webcontact->addColumn("phone_ext", "STRING_TYPE", "POST", "phone_ext");
$ins_webcontact->addColumn("comment", "STRING_TYPE", "POST", "comment");
$ins_webcontact->setPrimaryKey("cont_id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rswebcontact = $tNGs->getRecordset("webcontact");
$row_rswebcontact = mysql_fetch_assoc($rswebcontact);
$totalRows_rswebcontact = mysql_num_rows($rswebcontact);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">


<HTML>
<HEAD>
	<TITLE>Magical Strings Contact Form</TITLE>
	<base target="_self">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="Welcome to Magical Strings.  Celtic music and more.  School assemblies, private and group lessons in Celtic harp and hammered dulcimer.  Magical Strings is the dynamic duo of Pam and Philip Boulding playing Celtic roots and original compositions world wide on harps, hammered dulcimers, concertinas and whistles.  Magical Strings also builds Celtic harps and hammered dulcimers and teaches classes in these instruments.  We also perform at school assemblies and conduct workshops at schools.">
<meta name="keywords" content="magical strings, magical, strings, celtic music, celtic, celtic CD's, celtic CDs, celtic CD, Irish CD's, Irish cds, irish CD, music, irish music, irish, folk music, folk, celtic harps, celtic harp, dulcimers, dulcimer, hammered dulcimer, hammered dulcimers, harp maker, dulcimer, maker, hammered dulcimer maker, instrument maker, instrument builder, celtic instrument maker, celtic instrument builder, celtic composer, composer, yuletide, yule tide, boulding, Beneath the Moon, Legend of Inishcahey, Crossing to Skellig, Islands Calling, Bell Off the Ledge, Philip Boulding - HARP, YULETIDE LIVE, Good People All, On The Burren, Above the Tower, Spring Tide, school of magical strings, harp lessons, harp classes, harp camp, dulcimer camp, hammered dulcimer classes, hammered dulcimer lessons, dulcimer lessons">
<link href="includes/global.css" rel="stylesheet" type="text/css" />
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>
<BODY background="Images/Background-Gold.gif" bgcolor="#cc9933" vlink="#666699" link="#990033">


<center>
 <div align="center"><span class="nav"><a href="/index.html"><strong>Home</strong></a><strong> | <a href="/Recordings.html">Recordings</a> | <a href="/Calendar.html">Calendar</a> | <a href="/SchoolIndex.html">School
        Of Magical Strings</a> | <a href="/HarpsDulcimers.html">Harps & Dulcimers</a> | <a href="/News.html">News</a> | <a href="/Reviews.html">Reviews</a> | <a href="/Bio.html">Bio</a> | <a href="/Links.html">Links</a> | <a href="/Form_Contact.php">Contact Us</a></strong></span></div><br>
    <br>
  <table width="70%" cellpadding=2 cellspacing=0 border=0 bgcolor="#996600">
	<tr>
		
      <td height="690"> 
        <table width="100%" cellpadding=8 cellspacing=0 border=0 height="456">
          <tr>
					
            <td valign=top align=left width="70%" bgcolor="#cccc99" height="388"> 
              <p><a href="Images/MSLogo_Sm.gif"><IMG WIDTH=200 HEIGHT=105 BORDER=0 ALT="MAGICAL STRINGS" SRC="Images/MSLogo_Sm.gif" align="left"></a>
              <p>&nbsp; 
              <table width="86%" border="0">
                <tr> 
                  <td valign="middle" width="24%"><font size=5 face="Arial, Geneva, Helvetica" color="#333366">&nbsp;</font> 
                  </td>
                  <td valign="middle" width="76%"><font size=6 face="Arial, Geneva, Helvetica" color="#333366"><b>Contact
                    Us</b></font></td>
                </tr>
              </table>
              <p><br>
                  <font face="Arial, Helvetica, sans-serif"><br>
                  <br>
                  </font><a href="mailto:info@magicalstrings.com">info@magicalstrings.com</a><br>
253-857-3716</p>
              <p>&nbsp;</p>
              <table width="97%" border="0" height="36">
                <tr>
                  <td width="35%"><b><font face="Arial, Helvetica, sans-serif">Mail</font>:</b><br>
                    <font face="Arial, Helvetica, sans-serif">PO Box 1240<br>
                    Olalla, WA 98359</font></td>
                  <td width="27%" valign="bottom"><font face="Arial, Geneva, Helvetica"><b>Tel:
                        253 857 3716<br>
                  </b></font></td>
                  <td width="38%" valign="bottom">&nbsp;</td>
                </tr>
              </table>
              <p><br>
            </td>
            <td valign=top align=center width="30%" bgcolor="#cccc99" height="388"> 
              <font size=5 face="Arial, Geneva, Helvetica" color="#333366"><b><br>
              </b></font>              <p><IMG SRC="Images/Wheel100.gif" WIDTH=101 HEIGHT=101 BORDER=0 ALT="*" align="left"><br>
                <br>
<!-- 						<IMG SRC="Images/PamPhilip.gif" WIDTH=100 HEIGHT=142 BORDER=0 ALT="Pam & Philip Boulding"><br> -->
						
		    </td>
		  </tr>
			
				<tr>
					<td valign=top align=left width="100%" colspan=2 bgcolor="#333366">
						<font size=2 face="Arial, Geneva, Helvetica">
						<br>&nbsp;<br>
						</font>
					</td>
				</tr>
		</table>
	  </td>
	</tr>
</table>

<p>&nbsp;</p>
 <div align="center"><span class="nav"><a href="/index.html"><strong>Home</strong></a><strong> | <a href="/Recordings.html">Recordings</a> | <a href="/Calendar.html">Calendar</a> | <a href="/SchoolIndex.html">School
        Of Magical Strings</a> | <a href="/HarpsDulcimers.html">Harps & Dulcimers</a> | <a href="/News.html">News</a> | <a href="/Reviews.html">Reviews</a> | <a href="/Bio.html">Bio</a> | <a href="/Links.html">Links</a> | <a href="/Form_Contact.php">Contact Us</a></strong></span></div>


</center>


</BODY>
</HTML>
