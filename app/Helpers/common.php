<?php
function br2nl($input)
{
    return preg_replace('/<br\s?\/?>/ius', "\n",
        str_replace("\n", "", str_replace("\r", "", htmlspecialchars_decode($input))));
}
