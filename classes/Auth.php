<?php

class Auth
{
    /**
     * Return the user authentication status
     *
     * @return boolean True if a user is logged in, otherwise false;
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }

    public static function requireLogin()
    {
        if (!static::isLoggedIn()) {
            return false;
        }
        return true;
    }

    public static function login()
    {
        $_SESSION['is_logged_in'] = true;

        session_regenerate_id();
    }

    public static function logout()
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

    }
}
