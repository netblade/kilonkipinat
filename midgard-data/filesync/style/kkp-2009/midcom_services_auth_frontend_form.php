<form name="midcom_services_auth_frontend_form" method='post' id="midcom_services_auth_frontend_form">
                <p>
                    <label for="username">
                        <?php echo $_MIDCOM->i18n->get_string('username', 'midcom'); ?><br />
                        <input name="username" id="username" type="text" class="input" />
                    </label>
                </p>
                <p>
                    <label for="password">
                        <?php echo $_MIDCOM->i18n->get_string('password', 'midcom'); ?><br />
                        <input name="password" id="password" type="password" class="input" />
                    </label>
                </p>
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