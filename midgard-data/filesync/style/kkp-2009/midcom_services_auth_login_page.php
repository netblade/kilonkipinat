<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fi" lang="fi">
<head>
    <(head-local)>
</head>
<?php
$page_class = $_MIDCOM->metadata->get_page_class();
?>
<body class="login" <?php echo $_MIDCOM->print_jsonload(); ?>>
<div id="login_form">
    <form name="midcom_services_auth_frontend_form" method='post' id="midcom_services_auth_frontend_form">
        <h1>Kirjaudu sisään</h1>
        <input type="hidden" name="midcom_services_auth_login_success_url" value="/extranet/" />
        <div id="login_form_username">
            <label for="username">Käyttäjänimi</label>
            <input name="username" id="username" type="text" class="input" />
        </div>
        <div id="login_form_password">
            <label for="password">Salasana</label>
            <input name="password" id="password" type="password" class="input" />
        </div>
    <?php
    if (   isset($data['restored_form_data'])
        && count($data['restored_form_data']) > 0)
    {
        foreach ($data['restored_form_data'] as $key => $value)
        {
            echo "                <input type=\"hidden\" name=\"restored_form_data[{$key}]\" value=\"{$value}\" />\n";
        }
    
        echo "                <p>\n";
        echo "                    <label for=\"restore_form_data\" class=\"checkbox\">\n";
        echo "                        <input name=\"restore_form_data\" id=\"restore_form_data\" type=\"checkbox\" value=\"1\" checked=\"checked\" class=\"checkbox\" />\n";
        echo "                        {$_MIDCOM->i18n->get_string('restore submitted form data', 'midcom')}?\n";
        echo "                    </label>\n";
        echo "                </p>\n";
    }
    ?>
        <div class="clear">
          <input type="submit" name="midcom_services_auth_frontend_form_submit" id="midcom_services_auth_frontend_form_submit" value="<?php
            echo $_MIDCOM->i18n->get_string('login', 'midcom'); ?>" />
        </div>
    </form>
    <div id="login_form_additional">
        Mikäli unohdit salasanasi, tai haluat tunnukset, klikkaa <a href="/recovery/">tästä</a>
    </div>
</div>
<?php
    $_MIDCOM->uimessages->show();
?>
</body>
</html>