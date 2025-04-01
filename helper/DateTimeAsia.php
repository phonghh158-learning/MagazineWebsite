<?php

    namespace Helper;

    use DateTime;
    use DateTimeZone;

    class DateTimeAsia {
        public static function now() {
            $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));

            return $now;
        }

        public static function toUTC7($time) {
            if (!isset($time)) {
                return '';
            }
            
            return $time->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'))->format('Y-m-d\TH:i');
        }
    }

?>