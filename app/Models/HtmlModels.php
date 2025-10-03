<?php

namespace App\Models;

use CodeIgniter\Model;

class HtmlModel extends Model {

    public function Pagination($totPages) {
        for ($i = 0; $i < $totPages; $i++) {
            $p = $i+1;
            echo "<button onclick='changePage($p)'>";
            echo $p . "</button>";
        }
    }
}