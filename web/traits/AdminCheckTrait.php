<?php
namespace Web\Traits;

trait AdminCheckTrait {
    /**
     * Checks if the current user has admin privileges.
     * Redirects to the home page if the user is not an admin.
     */
    public function checkAdmin() {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            return true;
        } else {
            header('Location: /');
            exit();
        }
    }
}
?>
