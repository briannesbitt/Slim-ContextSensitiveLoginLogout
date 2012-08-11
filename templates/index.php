<? require 'header.php' ?>

<p>Welcome to my home page for a context sensitive login/logout sample application.</p>

<?if (!empty($user)):?>
<p>Hi <?=$user?>
<?endif;?>

<? require 'footer.php' ?>