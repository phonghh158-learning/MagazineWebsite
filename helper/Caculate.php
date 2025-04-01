<?php

    namespace Helper;

    class Caculate {
        public static function paginateOffset($total, $currentPage, $resultsPerPage) {
            // Công thức tính phân trang:
            
            // totalPages = ceil(total / resultsPerPage)
            // limit = resultsPerPage
            // offset = (currentPage - 1) * resultsPerPage
            
            $totalPages = ceil($total / $resultsPerPage);
            $currentPage = max(1, min($currentPage, $totalPages)); // Nếu giá trị lớn hơn tổng số trang set = tổng số trang. Nếu giá trị nhỏ hơn 1 set = 1

            $offset = ($currentPage - 1) * $resultsPerPage;
            return (int)$offset;
        }
    }

?>