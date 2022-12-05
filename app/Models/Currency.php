<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\ArrayKey;

class Currency extends Model
{
    use HasFactory;
    public $fromDate;
    public $createdBy;
    public $fdMonth;
    public $toDate;
    public $itemId;
    public $otherName;
    public $depatment;
    public $type;
    public $arrCondition;


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

    public $sqlSummary = "";

    protected $fillable = [
        'country_and_currency',
        'code',
        'symbol',
        'status',
        'position'
    ];

    public function getTotal_backup($date = null)
    {
        $sql = '';
        $condictions = [];
        $user = auth()->user()->id;
        if ((Session::get('isGlobleCash') ?? false)) {
            if ($date) {
                $sql = $this->sqlSummaryDate_g;
                $condictions = [$date, $date, $date, $date];
            } else {
                $sql = $this->sqlSummaryAll_g;
                $condictions = [];
            }
        } else {
            if ($date) {
                $sql = $this->sqlSummaryDate;
                $condictions = [$date, $user, $date, $user, $date, $user, $date, $user];
            } else {
                $sql = $this->sqlSummaryAll;
                $condictions = [$user, $user, $user, $user];
            }
        }

        return DB::select($sql, $condictions); // begin_amount, incom, expend, balance
    }

    public function getTotal($arrCondictions, $arrAditional = null)
    {
        $condictions = $arrCondictions;
        if($arrAditional){
            foreach($arrAditional as $key => $val) {
                $condictions[$key]=$val;
              }
        }

        $fromDate = array_key_exists('fromDate', $condictions) ? $condictions['fromDate'] : null;
        $createdBy = array_key_exists('createdBy', $condictions) ? $condictions['createdBy'] : null;
        $fdMonth = array_key_exists('month', $condictions) ? $condictions['month'] : null;
        $toDate = array_key_exists('toDate', $condictions) ? $condictions['toDate'] : null;
        $itemId = array_key_exists('itemId', $condictions) ? $condictions['itemId'] : null;
        $otherName = array_key_exists('otherName', $condictions) ? $condictions['otherName'] : null;
        $depatment = array_key_exists('depatmentId', $condictions) ? $condictions['depatmentId'] : null;
        $type = array_key_exists('type', $condictions) ? $condictions['type'] : null;
        $currencyId = array_key_exists('currencyId',$condictions) ? $condictions['currencyId'] : null;

        $arrCondition = [
            $fromDate, $fdMonth, $createdBy, $createdBy, $fromDate, $fromDate, $fdMonth, $fdMonth,
            $fromDate, $fromDate, $toDate, $toDate, $fdMonth, $fdMonth, $itemId, $itemId, $otherName, $otherName, $depatment, $depatment, $type, $type, $type, $createdBy, $createdBy,
            $fromDate, $fromDate, $toDate, $toDate, $fdMonth, $fdMonth, $itemId, $itemId, $otherName, $otherName, $depatment, $depatment, $type, $type, $type, $createdBy, $createdBy,
            $fromDate, $fromDate, $toDate, $toDate, $fdMonth, $fdMonth, $itemId, $itemId, $otherName, $otherName, $depatment, $depatment, $type, $type, $type, $createdBy, $createdBy,
            $currencyId, $currencyId
        ];

        $sql = "
        SELECT cu.id,cu.symbol,
            IFNULL(
                    (
                    SELECT IF(? IS NULL AND ? IS NULL, 0, SUM(amount)) AS total_begin_amount
                    FROM tr_cashes
                    WHERE `status` = 1
                    AND currency_id = cu.id
                    AND IF(?, created_by = ?, TRUE)
                    AND (IF(?, tr_date < ?, FALSE) OR IF(?, `month` < ?, FALSE))
                    )
                    ,0
                )AS begin_amount,
            IFNULL(
                    (
                    SELECT SUM(amount) AS total_cash_in
                    FROM tr_cashes
                    WHERE `type` IN (1, 4)
                    AND `status` = 1
                    AND currency_id = cu.id
                    AND IF(?, tr_date >= ?, TRUE)
                    AND IF(?, tr_date <= ?, TRUE)
                    AND IF(?, `month` = ?, TRUE)
                    AND IF(?, item_id = ?, TRUE)
                    AND IF(?, other_name LIKE CONCAT('%', ?, '%'), TRUE)
                    AND IF(?, (to_from_id = ? AND `type` = 2), TRUE)
                    AND (IF(?, `type` = ?, TRUE) OR IF(? = 3,`type` = 4, FALSE ))
                    AND IF(?, created_by = ?, TRUE)
                    )
                    ,0
                ) AS cash_in,
            IFNULL(
                    (
                    SELECT SUM(amount) AS total_expend
                    FROM tr_cashes
                    WHERE `type` IN (2, 3)
                    AND `status` = 1
                    AND currency_id = cu.id
                    AND IF(?, tr_date >= ?, TRUE)
                    AND IF(?, tr_date <= ?, TRUE)
                    AND IF(?, `month` = ?, TRUE)
                    AND IF(?, item_id = ?, TRUE)
                    AND IF(?, other_name LIKE CONCAT('%', ?, '%'), TRUE)
                    AND IF(?, (to_from_id = ? AND `type` = 2), TRUE)
                    AND (IF(?, `type` = ?, TRUE) OR IF(? = 3,`type` = 4, FALSE ))
                    AND IF(?, created_by = ?, TRUE)
                    )
                    ,0
                ) AS expend,
            IFNULL(
                    (
                    SELECT SUM(amount) AS total_cash
                    FROM tr_cashes
                    WHERE `status` = 1
                    AND currency_id = cu.id
                    AND IF(?, tr_date >= ?, TRUE)
                    AND IF(?, tr_date <= ?, TRUE)
                    AND IF(?, `month` = ?, TRUE)
                    AND IF(?, item_id = ?, TRUE)
                    AND IF(?, other_name LIKE CONCAT('%', ?, '%'), TRUE)
                    AND IF(?, (to_from_id = ? AND `type` = 2), TRUE)
                    AND (IF(?, `type` = ?, TRUE) OR IF(? = 3,`type` = 4, FALSE ))
                    AND IF(?, created_by = ?, TRUE)
                    )
                    ,0
                ) AS total_cash
        FROM currencies AS cu WHERE cu.status = 'ENABLED' AND IF(?, cu.id = ?, TRUE) ORDER BY cu.position ASC
        ";

        // Return record with id, symbol, begin_amount, cash_in, expend, total_cash

        return DB::select($sql, $arrCondition);
    }
}
