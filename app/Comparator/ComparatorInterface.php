<?php

namespace App\Comparator;

interface ComparatorInterface
{
    /**
     * 取得上一版本的資料
     *
     * @return mixed
     */
    public function getPreviousContext();

    /**
     * 取得目前版本的資料
     *
     * @return mixed
     */
    public function getCurrentContext();
}
