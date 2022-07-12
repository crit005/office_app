<?php

namespace App\Http\Livewire\Components;

use App\Models\ConnectionName;
use App\Models\Customer;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class SystemPanel extends Component
{
    public $connection = null;

    public $sqlMemberInfo = "
        SELECT
        cw.CustomerID AS id,
        cw.Name AS name,
        cw.Email AS email,
        cw.Mobile AS mobile,
        cw.ClubName AS club_name,
        cw.LoginID AS login_id,
        cw.FirstJoin AS first_join,
        cw.LastDP AS last_dp,
        cw.LastWD AS last_wd,
        GREATEST(if(cw.LastDP,cw.LastDP,0),if(cw.LastWD,cw.LastWD,0),if(MAX(cw.WinloseDate),MAX(cw.WinloseDate),0)) AS last_active,
        cw.TotalDP AS total_dp,
        cw.TotalWD AS total_wd,
        sum(cw.Turnover) AS total_turnover,
        sum(cw.Winlose) AS totall_winlose
        FROM
            (
                SELECT
                    cf.id AS CustomerID,
                    cf.name AS Name,
                    cf.email AS Email,
                    CONCAT('\'',cf.mobile) AS Mobile,
                    cf.FirstJoin,
                    cf.LastDP,
                    cf.LastWD,
                    cf.TotalDP,
                    cf.TotalWD,
                    winlose.loginid AS LoginID,
                    webaccount.clubName AS ClubName,
                    winlose.GroupFor AS `WinloseDate`,
                    winlose.trunover AS Turnover,
                    winlose.wlamt AS `winlose`
                FROM
                    winlose
                    INNER JOIN webaccount ON winlose.accountId = webaccount.id
                    INNER JOIN

                    (SELECT customer.id, CONCAT(customer.firstName,' ',customer.lastName) AS Name, customer.mobile AS Mobile, customer.email AS Email,
                    MIN(if(`transaction`.`type`=3,`transaction`.groupfor,if(`transaction`.`type`=1,`transaction`.groupfor,NULL)))AS FirstJoin,
                    MAX(if(`transaction`.`type`IN(1,3),`transaction`.groupfor,NULL))AS LastDP,
                    MAX(if(`transaction`.`type`=2,`transaction`.groupfor,NULL))AS LastWD,
                    SUM(if(`transaction`.`type`IN(1,3),`transaction`.inputAmount,0))AS TotalDP,
                    SUM(if(`transaction`.`type`=2,`transaction`.inputAmount,0))AS TotalWD
                    FROM customer INNER JOIN `transaction` ON customer.Id = `transaction`.customerid
                    GROUP BY customer.id) AS cf

                    ON webaccount.customerId = cf.Id
            )as cw
        GROUP BY
            id
        ";
    public $listCustomer = null;

    public function mount(ConnectionName $connection)
    {
        $this->connection = $connection;

        // check system table exist
        /**
         * if not exist create
         * if exist selecte max date
         * compare maxdate and today
         * if today = maxdate do nothing
         * if today > maxdate => delete table and recreate
         * ** select customerinfor from server
         * ** insert to locall table 100 by 100
         */

        if (!Schema::hasTable('tbl_' . $this->connection->connection_name)) {
            $this->createSystemTable('tbl_' . $this->connection->connection_name);
        }

        $customer = new Customer();
        $customer->setTable('tbl_' . $this->connection->connection_name);
        $firstRecord = $customer->first();
        if (!$firstRecord) {
            // dd('norecord');
            //inseart record
            $this->inseartRecordFromServer();
            // dd('has inserted');
        } else {
            // dd($firstRecord);
        }

        // Schema::dropIfExists('connection_names');
        // $this->listCustomer = DB::connection($this->connection->connection_name)->select($this->sqlMemberInfo);
        // dd(count($this->listCustomer));

    }

    public function inseartRecordFromServer()
    {
        $listCustomerOnServer = DB::connection($this->connection->connection_name)->select($this->sqlMemberInfo);
        $totalRecord = count($listCustomerOnServer);
        $j = 0;
        $i = 0;
        $recordPerInsert = [];
        foreach ($listCustomerOnServer as $customer) {
            $arrRecord = json_decode(json_encode($customer), true);
            $arrRecord['created_at'] = now();
            $arrRecord['updated_at'] = now();
            array_push($recordPerInsert, $arrRecord);
            $j += 1;
            $i += 1;
            if($j==100 || $i == $totalRecord){
                DB::table('tbl_' . $this->connection->connection_name)->insert($recordPerInsert);
                $j=0;
                $recordPerInsert = [];
            }
        }
    }

    public function createSystemTable($tableName)
    {
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            // $table->string('customer_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('club_name')->nullable();
            $table->string('login_id')->nullable();
            $table->date('first_join')->nullable();
            $table->date('last_dp')->nullable();
            $table->date('last_wd')->nullable();
            $table->date('last_active')->nullable();
            $table->double('total_dp')->nullable();
            $table->double('total_wd')->nullable();
            $table->double('total_turnover')->nullable();
            $table->double('totall_winlose')->nullable();
            $table->timestamps();
        });
    }

    public function render()
    {
        return view('livewire.components.system-panel');
    }
}
