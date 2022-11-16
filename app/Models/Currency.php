<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Currency extends Model
{
    use HasFactory;
    public $sqlSummaryDate_g = "SELECT cu.id, cu.symbol,
    IFNULL((SELECT SUM(amount) AS total_begin_amount FROM tr_cashes WHERE `status` = 1 AND `month` < ? AND currency_id = cu.id GROUP BY currency_id),0)AS begin_amount,
    IFNULL((SELECT SUM(amount) AS total_income FROM tr_cashes WHERE `type` IN(1,4) AND `status` = 1 AND `month` = ? AND currency_id = cu.id),0) AS income,
    IFNULL((SELECT SUM(amount) AS total_expend FROM tr_cashes WHERE `type` IN(2,3) AND `status` = 1 AND `month` = ? AND currency_id = cu.id),0) AS expend,
    IFNULL((SELECT SUM(amount) AS total_last_balance FROM tr_cashes WHERE `status` = 1 AND `month` <= ? AND currency_id = cu.id),0) AS balance
    FROM currencies AS cu WHERE cu.status = 'ENABLED' ORDER BY cu.position ASC";

    public $sqlSummaryDate = "SELECT cu.id, cu.symbol,
    IFNULL((SELECT SUM(amount) AS total_begin_amount FROM tr_cashes WHERE `status` = 1 AND `month` < ? AND created_by = ? AND currency_id = cu.id GROUP BY currency_id),0)AS begin_amount,
    IFNULL((SELECT SUM(amount) AS total_income FROM tr_cashes WHERE `type` IN(1,4) AND `status` = 1 AND `month` = ? AND created_by = ? AND currency_id = cu.id),0) AS income,
    IFNULL((SELECT SUM(amount) AS total_expend FROM tr_cashes WHERE `type` IN(2,3) AND `status` = 1 AND `month` = ? AND created_by = ? AND currency_id = cu.id),0) AS expend,
    IFNULL((SELECT SUM(amount) AS total_last_balance FROM tr_cashes WHERE `status` = 1 AND `month` <= ? AND created_by = ? AND currency_id = cu.id),0) AS balance
    FROM currencies AS cu WHERE cu.status = 'ENABLED' ORDER BY cu.position ASC";

    public $sqlSummaryAll_g = "SELECT cu.id, cu.symbol,
    IFNULL((SELECT SUM(amount) AS total_begin_amount FROM tr_cashes WHERE `status` = 1 AND currency_id = cu.id GROUP BY currency_id),0)AS begin_amount,
    IFNULL((SELECT SUM(amount) AS total_income FROM tr_cashes WHERE `type` IN(1,4) AND `status` = 1 AND currency_id = cu.id),0) AS income,
    IFNULL((SELECT SUM(amount) AS total_expend FROM tr_cashes WHERE `type` IN(2,3) AND `status` = 1 AND currency_id = cu.id),0) AS expend,
    IFNULL((SELECT SUM(amount) AS total_last_balance FROM tr_cashes WHERE `status` = 1 AND currency_id = cu.id),0) AS balance
    FROM currencies AS cu WHERE cu.status = 'ENABLED' ORDER BY cu.position ASC";

    public $sqlSummaryAll = "SELECT cu.id, cu.symbol,
    IFNULL((SELECT SUM(amount) AS total_begin_amount FROM tr_cashes WHERE `status` = 1 AND created_by = ? AND currency_id = cu.id GROUP BY currency_id),0)AS begin_amount,
    IFNULL((SELECT SUM(amount) AS total_income FROM tr_cashes WHERE `type` IN(1,4) AND `status` = 1 AND created_by = ? AND currency_id = cu.id),0) AS income,
    IFNULL((SELECT SUM(amount) AS total_expend FROM tr_cashes WHERE `type` IN(2,3) AND `status` = 1 AND created_by = ? AND currency_id = cu.id),0) AS expend,
    IFNULL((SELECT SUM(amount) AS total_last_balance FROM tr_cashes WHERE `status` = 1 AND `month` <= ? AND created_by = ? AND currency_id = cu.id),0) AS balance
    FROM currencies AS cu WHERE cu.status = 'ENABLED' ORDER BY cu.position ASC";

    protected $fillable = [
        'country_and_currency',
        'code',
        'symbol',
        'status',
        'position'
    ];

    public function getTotal($date = null)
    {
        $sql = '';
        $condictions = [];
        $user = auth()->user()->id;
        if ((Session::get('isGlobleCash') ?? false)) {
            if ($date) {
                $sql = $this->sqlSummaryDate_g;
                $condictions = [$date, $date, $date, $date];
            }else{
                $sql = $this->sqlSummaryAll_g;
                $condictions = [];
            }
        }else{
            if ($date) {
                $sql = $this->sqlSummaryDate;
                $condictions = [$date, $user, $date, $user, $date, $user, $date, $user];
            }else{
                $sql = $this->sqlSummaryAll;
                $condictions = [$user, $user, $user, $user];
            }
        }

        return DB::select($sql, $condictions);// begin_amount, incom, expend, balance
    }
}
