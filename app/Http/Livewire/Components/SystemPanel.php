<?php

namespace App\Http\Livewire\Components;

use App\Models\ConnectionName;
use App\Models\Customer;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class SystemPanel extends Component
{
    public $connection = null;
    public $totalNewMember = 0;
    public $totalActiveMember = 0;
    public $totalInactiveMember = 0;
    public $totalAllMember = 0;
    public $isOutOfDate = false;
    public $lastUpdate = '...';

    public $sqlMemberInfo = "
    SELECT
        cw.CustomerID AS customer_id,
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
                webaccount.loginid AS LoginID,
                webaccount.clubName AS ClubName,
                winlose.GroupFor AS `WinloseDate`,
                winlose.trunover AS Turnover,
                winlose.wlamt AS `winlose`
            FROM
                winlose
                RIGHT JOIN webaccount ON winlose.accountId = webaccount.id
                INNER JOIN

                (SELECT customer.id, CONCAT(customer.firstName,' ',customer.lastName) AS Name, customer.mobile AS Mobile, customer.email AS Email,
                MIN(if(`transaction`.`type`=3,if(`transaction`.groupfor!='0000-00-00',`transaction`.groupfor,NULL),if(`transaction`.`type`=1,if(`transaction`.groupfor!='0000-00-00',`transaction`.groupfor,NULL),NULL)))AS FirstJoin,
                MAX(if(`transaction`.`type`IN(1,3),if(`transaction`.groupfor!='0000-00-00',`transaction`.groupfor,NULL),NULL))AS LastDP,
                MAX(if(`transaction`.`type`=2,if(`transaction`.groupfor!='0000-00-00',`transaction`.groupfor,NULL),NULL))AS LastWD,
                SUM(if(`transaction`.`type`IN(1,3),`transaction`.inputAmount,0))AS TotalDP,
                SUM(if(`transaction`.`type`=2,`transaction`.inputAmount,0))AS TotalWD
                FROM customer INNER JOIN `transaction` ON customer.Id = `transaction`.customerid
                GROUP BY customer.id) AS cf

                ON webaccount.customerId = cf.Id
        )as cw
    GROUP BY
        cw.LoginID
        ";
    public $listCustomer = null;

    public function mount(ConnectionName $connection)
    {
        $this->connection = $connection;

        // create system table it not exist
        if (!Schema::hasTable('tbl_' . $this->connection->connection_name)) {
            $this->createSystemTable('tbl_' . $this->connection->connection_name);
        }

        $this->initSumary();

    }

    public function createSystemTable($tableName)
    {
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
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

    public function initSumary()
    {
        $this->totalNewMember = $this->connection->new_member;
        $this->totalActiveMember = $this->connection->active_member;
        $this->totalAllMember = $this->connection->total_member;
        $this->totalInactiveMember = $this->totalAllMember - $this->totalActiveMember;
        $this->lastUpdate = $this->connection->updated_at;

        $this->initOutOfDate();
    }

    public function initOutOfDate()
    {
        if(date('Y-m-d', strtotime($this->connection->updated_at)) < date('Y-m-d', strtotime(now()))){
            $this->isOutOfDate = true;
        }else{
            $this->isOutOfDate = false;
        }
    }

    public function reloadMemberFromserver()
    {
        Schema::dropIfExists('tbl_' . $this->connection->connection_name);

        if (!Schema::hasTable('tbl_' . $this->connection->connection_name)) {
            $this->createSystemTable('tbl_' . $this->connection->connection_name);
        }

        $this->inseartRecordFromServer();

        $this->initSumary();
    }


    public function inseartRecordFromServer()
    {
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);
        ini_set('max_input_time', 1200);
        // ini_set('memory_limit','5120M');
        // Log::channel('stderr')->info("start load record:". date('Y-m-d H:i:s', strtotime(now())));
        $listCustomerOnServer = DB::connection($this->connection->connection_name)->select($this->sqlMemberInfo);
        // Log::channel('stderr')->info("record loaded:". date('Y-m-d H:i:s', strtotime(now())));
        $totalRecord = count($listCustomerOnServer);
        $j = 0;
        $i = 0;
        $recordPerInsert = [];
        foreach ($listCustomerOnServer as $customer) {
            $arrRecord = json_decode(json_encode($customer), true);
            $arrRecord['created_at'] = now();
            $arrRecord['updated_at'] = now();
            if(!$arrRecord['last_active']){
                $arrRecord['last_active'] = date('Y-m-d',strtotime(env('MINDATE')));
            }
            array_push($recordPerInsert, $arrRecord);
            $j += 1;
            $i += 1;
            if ($j == 1000 || $i == $totalRecord) {
                // Log::channel('stderr')->info("start Insert:". date('Y-m-d H:i:s', strtotime(now())));
                DB::table('tbl_' . $this->connection->connection_name)->insert($recordPerInsert);
                $j = 0;
                $recordPerInsert = [];
                // Log::channel('stderr')->info($i. date('Y-m-d H:i:s', strtotime(now())));
            }
        }
        $listCustomerOnServer = null;
        $this->updateConnectionInfo();
    }

    public function updateConnectionInfo()
    {
        $customer = new Customer();
        $customer->setTable('tbl_' . $this->connection->connection_name);

        $this->connection->new_member = $customer->where('first_join', '>', date('Y-m-t', strtotime("last Month")))->count();
        $this->connection->active_member = $customer->where('last_active', '>=', date('Y-m-d', strtotime("-30 days")))->count();
        $this->connection->total_member =  $customer->count();
        $this->connection->updated_at = now();
        $this->connection->update();
    }

    public function gotoCustomerList()
    {
        session(['selectedSystem' => $this->connection]);
        return redirect()->to(route('customer.list'));
    }

    public function gotoNewCustomerList()
    {
        session(['selectedSystem' => $this->connection]);
        return redirect()->to(route('customer.newmember'));
    }

    public function gotoActiveCustomer()
    {
        session(['selectedSystem' => $this->connection]);
        return redirect()->to(route('customer.active'));
    }

    public function gotoInactiveCustomer()
    {
        session(['selectedSystem' => $this->connection]);
        return redirect()->to(route('customer.inactive'));
    }



    public function render()
    {
        return view('livewire.components.system-panel');
    }
}
