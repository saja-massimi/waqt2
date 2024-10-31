<?
class CouponModel extends Dbh {
    public function __construct() {
        parent::__construct();
    }
    public function getCoupon() {
        $sql = "SELECT * FROM coupon";
        $stmt = $this->connect()->query($sql);
        while ($row = $stmt->fetch()) {
            $data[] = $row;
        }
        return $data;
    }

    //check if coupon is valid
    public function checkCoupon($coupon) {
        $sql = "SELECT * FROM coupon WHERE coupon_code = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$coupon]);
        $data = $stmt->fetch();
        return $data;
    }
}