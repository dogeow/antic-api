<?php

function br2nl($input)
{
    return preg_replace('/<br\s?\/?>/iu', "\n",
        str_replace("\n", '', str_replace("\r", '', htmlspecialchars_decode($input))));
}
