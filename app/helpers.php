<?php

function isAdmin()
{
    if (auth()->user()->level == 'Admin') {
        return true;
    }
}

function isUser()
{
    if (auth()->user()->level == 'User') {
        return true;
    }
}
