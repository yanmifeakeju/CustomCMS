<?php
/**
 * Return the user authentication status
 *
 * @return boolean True if a user is logged in, otherwise false;
 */
function isLoggedIn()
{
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
}
