<html>
<head>
   <style type="text/css">body {font-size:16px;} .error {background-color:red} .small {font-size:12px}</style>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
   <script type="text/javascript">
   $(document).ready(function() {
      $('#login').click(function() {
         $('#login').attr("href", $('#login').attr("href") + "?r=" + encodeURIComponent($(location).attr('pathname')));
      });
   });
   </script>
</head>
<body>

<a href="/">Home</a> | <a href="/about">About</a> | <a href="/level/contact">Deep Contact</a>

<?if (empty($user)):?>
   | <a href="/login" id="login">Login</a>
<?else:?>
   | <a href="/private/about">Private About</a>
   | <a href="/private/goodstuff">Private Good Stuff</a>
   | <a href="/logout">Logout</a>
<?endif;?>

<hr/>