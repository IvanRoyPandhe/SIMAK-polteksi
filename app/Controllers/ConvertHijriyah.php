<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ConvertHijriyah extends BaseController
{
    public function makeInt($angka)
    {
        if ($angka < -0.0000001) {
            return ceil($angka - 0.0000001);
        } else {
            return floor($angka + 0.0000001);
        }
    }

    public function AllConvertHijriyah($tanggal)
    {
        $array_bulan = [
            "Muharram",
            "Safar",
            "Rabiul Awwal",
            "Rabiul Akhir",
            "Jumadil Awwal",
            "Jumadil Akhir",
            "Rajab",
            "Sya'ban",
            "Ramadhan",
            "Syawwal",
            "Zulqaidah",
            "Zulhijjah"
        ];
        $date = $this->makeInt(substr($tanggal, 8, 2));
        $month = $this->makeInt(substr($tanggal, 5, 2));
        $year = $this->makeInt(substr($tanggal, 0, 4));
        if (($year > 1582) || (($year == "1582") && ($month > 10)) || (($year == "1582") && ($month == "10") && ($date > 14))) {
            $jd = $this->makeInt((1461 * ($year + 4800 + $this->makeInt(($month - 14) / 12))) / 4) +
                $this->makeInt((367 * ($month - 2 - 12 * ($this->makeInt(($month - 14) / 12)))) / 12) -
                $this->makeInt((3 * ($this->makeInt(($year + 4900 + $this->makeInt(($month - 14) / 12)) / 100))) / 4) +
                $date - 32075;
        } else {
            $jd = 367 * $year - $this->makeInt((7 * ($year + 5001 + $this->makeInt(($month - 9) / 7)) / 4)) +
                $this->makeInt((275 * $month) / 9) + $date + 1729777;
        }
        $wd = $jd % 7;
        $l = $jd - 1948440 + 10632;
        $n = $this->makeInt(($l - 1) / 10631);
        $l = $l - 10631 * $n + 354;
        $z = ($this->makeInt((10985 - $l) / 5316)) * ($this->makeInt((50 * $l) / 17719)) + ($this->makeInt($l / 5670)) * ($this->makeInt((43 * $l) / 15238));
        $l = $l - ($this->makeInt((30 - $z) / 15)) * ($this->makeInt((17719 * $z) / 50)) - ($this->makeInt($z / 16)) * ($this->makeInt((15238 * $z) / 43)) + 29;
        $m = $this->makeInt((24 * $l) / 709);
        $d = $l - $this->makeInt((709 * $m) / 24);
        $y = 30 * $n + $z - 30;
        $g = $m - 1;
        return "$d {$array_bulan[$g]} $y H";
    }

    public function TahunConvertHijriah($tanggal)
    {
        $date = $this->makeInt(substr($tanggal, 8, 2));
        $month = $this->makeInt(substr($tanggal, 5, 2));
        $year = $this->makeInt(substr($tanggal, 0, 4));
        if (($year > 1582) || (($year == "1582") && ($month > 10)) || (($year == "1582") && ($month == "10") && ($date > 14))) {
            $jd = $this->makeInt((1461 * ($year + 4800 + $this->makeInt(($month - 14) / 12))) / 4) +
                $this->makeInt((367 * ($month - 2 - 12 * ($this->makeInt(($month - 14) / 12)))) / 12) -
                $this->makeInt((3 * ($this->makeInt(($year + 4900 + $this->makeInt(($month - 14) / 12)) / 100))) / 4) +
                $date - 32075;
        } else {
            $jd = 367 * $year - $this->makeInt((7 * ($year + 5001 + $this->makeInt(($month - 9) / 7)) / 4)) +
                $this->makeInt((275 * $month) / 9) + $date + 1729777;
        }
        $l = $jd - 1948440 + 10632;
        $n = $this->makeInt(($l - 1) / 10631);
        $l = $l - 10631 * $n + 354;
        $z = ($this->makeInt((10985 - $l) / 5316)) * ($this->makeInt((50 * $l) / 17719)) + ($this->makeInt($l / 5670)) * ($this->makeInt((43 * $l) / 15238));
        $l = $l - ($this->makeInt((30 - $z) / 15)) * ($this->makeInt((17719 * $z) / 50)) - ($this->makeInt($z / 16)) * ($this->makeInt((15238 * $z) / 43)) + 29;
        $y = 30 * $n + $z - 30;
        return $y;
    }
}
