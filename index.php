<?php
$default_dir    = 'en-us';
$setup_url      = 'install';
$redirect_url   = $default_dir;

if(!file_exists(dirname(__FILE__) . "/{$default_dir}/database/config.php"))
{
    $redirect_url = $setup_url;
}
else
{
    try
    {
        require_once dirname(__FILE__) . "/{$default_dir}/database/config.php";
    }
    catch(Exception $e)
    {
        exit("The config file is not readable. Kindly check it's permissions or re-install");
    }
    $redirect_url = $default_dir;
}

header("location:{$redirect_url}");
?>