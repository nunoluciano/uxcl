<?php

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
echo '<h3>'.$xoopsModule->getVar('name').'</h3>' ;
echo '<hr />
<br />
<div class="tips">

<p>This module allows webmaster and webdesigners to manage static and rich content.</p>
<p>The following features are available by default:</p>

<h6>WYSIWYG Editor</h6>
<p>The module can run FCKEditor and its plugins.<br />
Location on the server is public path /common/fckeditor</p>

<h6>Text Filters</h6>
<p>Smarty(xoopsTpl) : XOOPS Cube variables used for templates</p>
<p>PHP code : It passes as an argument of php function eval(). The php sign is not necessary.</p>
<p>HTML special character escape, PEAR TextWiki, BBcode and Emoticon conversion to graphics.</p>

<h6>Import/synchronization</h6>
<p>Content from other instances of the module Pico can be imported.</p>
<p>Synchronization should be executed when important changes are made to content, to permissions or to keep votes up to date</p>

<h6>Wrap directory</h6>
<p>The module can include independent html files within XOOPS Cube.<br />
Check the wrap function of module from preferences.<br />
Location on the server is by default a secure path /app/wraps/modulename/<br />
When you make a new content, files from this folder are displayed in wrap \"selection\" option .</p>

<h6>Permissions</h6>
<p>Webmasters can give permissions to a group or a specific user to manage a category content.</p>
<br />
<p>Note  : Remember that you have to previously set XOOPS Cube user/groups permisions!</p>
</div>

<br />	
<div class="return_top"><a href="#container">Return to the Top</a></div>
<hr />
<br />

<h4>HTML Forms</h4>

<div class="tips">
<h6>Smarty plugin form</h6>
<p>This module allows webmasters and webdesigners to create html forms using smarty</p>
<p>plugins processing the forms content.</p>
<br />
<p><{capture}> ... <{/capture}></p>

<br />

<h6>{formmail}</h6>
<p>This will send an email to \"adminmail\"</p>

<h6>{formmail4fleamarket}</h6>
<p>This will send an email to the creator of the content.</p>
<p>And store the query into extra table (administration module link Extra/Forms)</p>

<h6>{survey}</h6>
<p>No emails will be sent.</p>
<p>Only store the query into extra table (administration module link Extra/Forms)</p>

<br />

<h6>Valid parameters for plugins processing forms</h6>
<p>These parameters are optional. Default values are defined in language catalog files.</p>

<br />

<h6>mail_body_pre</h6>
   <p>The mail body to be used before query contents that will be sent to the query mail.</p>

<h6>mail_body_post</h6>
    <p>The mail body to be used after query contents that will be sent to the query mail.</p>

<h6>mail_subject</h6>
    <p>Subject to be used with message that will be sent to the query mail</p>

<h6>to</h6>
    <p>Additional \"to\" for the message that will be sent to the query mail. <br />
	Use a comma as the separator between mail addresses</p>

<h6>from</h6>
    <p>\"from\" email used to identify the sender of the query mail.</p>

<h6>from_name</h6>
    <p>name of emial used in "from" </p>

<h6>can_post_again</h6>
    <p>1: a blank form will be displayed again after posting the form.<br />
    0: Just \"Thank you\" message will be displayed after posting the form.</p>

<h6>confirm_message</h6>
    <p>Display a message to confirm the form to be sent.<br />
	HTML tags require a backslash " \ " before a double quote \" <br />
	ie. &lt;a href= \&quot;...\&quot; &gt; &lt; / a&gt;
	</p>

<h6>finished_message</h6>
    <p>Display a final Message after the query was sent.<br />
	You can use this option to redirect to another page.<br />
	HTML tags require a backslash " \ " before a double quote \" <br />
	ie. &lt;a href= \&quot;...\&quot; &gt; &lt; / a&gt;
	</p>

<h6>cc_field_name</h6>
    <p>field\'s "name" for sending "confiming mail"</p>

<h6>cc_mail_subject</h6>
    <p>Subject for "confirming mail"</p>

<h6>cc_mail_body_pre</h6>
    <p>The mail body before query contents for the confirming mail.</p>

<h6>cc_mail_body_post</h6>
    <p>The mail body after query contents for the confirming mail.</p>

</div>

<br />	
<div class="return_top"><a href="#container">Return to the Top</a></div>
<hr />
<br />

<h4 class="admintitle">Languages</h4>
<div class="tips">
<p>You can easily edit and custom your language catalog</p>
<p>To edit and personalize your language variables<br />
<a href="index.php?mode=admin&lib=altsys&page=mylangadmin">Click  here</a>!</p>
</div>

<br />	
<div class="return_top"><a href="#container">Return to the Top</a></div>
<hr />
<br />

<h4 class="admintitle">Templates</h4>
<div class="tips">
<p>You can easily duplicate and custom your module Templates</p>
<br />
<p>To start editing your module templates<br />
<a href="index.php?mode=admin&lib=altsys&page=mytplsadmin">Click  here</a>!</p>
</div>

<br />	
<div class="return_top"><a href="#container">Return to the Top</a></div>
<hr />
<br />

<h4 class="admintitle">Blocks/Permissions</h4>
<div class="tips">
<p>To install module blocks and set permissions of user groups<br />
<a href="index.php?mode=admin&lib=altsys&page=myblocksadmin">Click  here</a>!</p>
</div>
';

xoops_cp_footer();

?>
