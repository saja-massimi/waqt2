<?php
class CouponModel extends Dbh
{
    // Get all coupons from the database
    public function getCoupon()
    {
        $sql = "SELECT * FROM coupon";
        $stmt = $this->connect()->query($sql);
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function checkCoupon($coupon)
    {
        $sql = "SELECT * FROM coupons WHERE coupon_name = ? AND 
                NOW() BETWEEN start_date AND end_date AND 
                usage_limit > 0";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$coupon]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data !== false;
    }

    public function getCouponValue($coupon)
    {
        $sql = "SELECT coupon_value FROM coupons WHERE coupon_name = ? AND 
                NOW() BETWEEN start_date AND end_date AND 
                usage_limit > 0";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$coupon]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['coupon_value'];
    }

    public function updateCouponUsage($coupon)
    {
        $sql = "UPDATE coupons SET usage_limit = usage_limit - 1 WHERE coupon_name = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$coupon]);
    }
}
