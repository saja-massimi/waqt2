<?php
class profileModel extends Dbh
{

    public function getProfile($user_id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

    public function updateProfile($user_id, $user_name, $user_email, $user_password)
    {
        $sql = "UPDATE users SET user_name = ?, user_email = ?, user_password = ? WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$user_name, $user_email, $user_password, $user_id]);
    }
}
