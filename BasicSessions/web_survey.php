<?php
session_start();
// echo "<p>PHP Session ID is " . session_id() . "</p>\n"; 
$survey_questions = array(
     1 => "Was the navigation straightforward and " .
               " did all the links work?",
     2 => " Was the selection of background color, " .
               " font color, and font size appropriate?",
     3 => " Were the images appropriate and did they " .
               " complement the Web content?",
     4 => " Were the descriptions of the PHP program " .
               " complete and easy to understand?",
     5 => " Was the PHP code structured properly and " .
               " well commented?");
$question_count = count($survey_questions);
if (isset($_SESSION['CurrentQuestion'])) {
     if (($_SESSION['CurrentQuestion'] > 0) &&
          (isset($_POST['response']))) {
          $_SESSION['Responses'][$_SESSION['CurrentQuestion']]
               = $_POST['response'];
     }
     ++$_SESSION['CurrentQuestion'];
}
else
     $_SESSION['CurrentQuestion'] = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Web Survey</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>Web Survey</h1>
<?php
if ($_SESSION['CurrentQuestion'] == 0) {
?>
<p>Thank you for reviewing the Chinese Zodiac Web site. 
Your candid responses to the following five questions will 
help improve the effectiveness of our PHP demonstration site.</p>
<?php
}
else if ($_SESSION['CurrentQuestion'] > $question_count) {
?>
<p>Thank you for completing the survey. Your responses are shown below:</p>
<?php
     $MsgBody="The following survey responses were entered on the Web site ".
              " survey form for the Chinese Zodiac:\n\n";
     echo "<dl>\n";
     foreach ($_SESSION['Responses'] as $index => $response) {
          echo "<dt>$index) " . htmlentities($survey_questions[$index]) . "</dt>\n";
          echo "<dd>" . htmlentities($response) . "</dd>\n";
          $MsgBody .= "Question $index) " . $survey_questions[$index] . "\n";
          $MsgBody .= "* Response: htmlentities($response)\n\n";
     }
     echo "</dl>\n";
     mail("student@student.email.address", 
               "Chinese Zodiac Web Survey Response", 
               $MsgBody);
}
else {
     echo "<p>Question " . $_SESSION['CurrentQuestion'] .
          ": " . $survey_questions[$_SESSION['CurrentQuestion']]
          . "</p>\n";
}
if ($_SESSION['CurrentQuestion'] <= $question_count) {
     echo "<form method='post' action='web_survey.php'>\n";
     echo "<input type='hidden' name='PHPSESSID' value='" .
          session_id() . "' />\n";
     if ($_SESSION['CurrentQuestion'] > 0) {
          echo "<p><input type='radio' name='response' " .
               " value='Exceeds Expectations' /> " .
               " Exceeds Expectations<br />\n";
          echo "<input type='radio' name='response' " .
               " value='Meets Expectations'" .
               " checked='checked' /> " .
               " Meets Expectations<br />\n";
          echo "<input type='radio' name='response' " .
               " value='Below Expectations'> " .
               " Below Expectations</p>\n";
     }
     echo "<input type='submit' name='submit' value='";
     if ($_SESSION['CurrentQuestion'] == 0)
          echo "Start the survey";
     else if ($_SESSION['CurrentQuestion'] == $question_count)
          echo "Finished";          
     else
          echo "Next Question";
     echo "' />\n";
     echo "<p>PHP Session ID is " . session_id() . "</p>\n"; 
     echo "</form>\n";
}
?>
</body>
</html>

