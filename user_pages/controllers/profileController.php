<?
require_once '../models/Dbh.php';
require_once '../models/profileModel.php';

session_start();
$user_id = $_SESSION['user'];

function getCurrentUserData($user_id)
{
    if (!isset($user_id)) {
        header('Location: ../user_pages/login.php');
    }
    $profileModel = new profileModel();
    $profile = $profileModel->getProfile($user_id);
    return $profile;
}
