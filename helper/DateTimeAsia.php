<?php

    namespace Helper;

    use DateTime;
    use DateTimeZone;

    class DateTimeAsia {
        public static function now() {
            $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
            $now->format('Y-m-d H:i:s');

            return $now;
        }
    }

?>