<?php namespace App\Http\Middleware;

use Closure;
use DB;

class AuthResource {


    static $table_map = [
    'history' => 'config_history'
    ];


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($req, Closure $next)
    {
        $isApi = $req->is('api/*');
        $params = $req->route()->parameters();
        $root_model = $req->segment(2);
        $rcode_id = $req->header('X-RCODE', $req->input('rcode_id'));
        //if ($req->user()->roles()->where('name','=','super')->first()){
        //  $req->user()->app_id = 0;
        //}
        if ($isApi && $root_model == 'station') {
            $req->user()->rcode_id = $rcode_id;
            //echo $req->user()->apps_with_regioncode()->where('app_id','=',$app_id)->get();
            //$req->user()->codes= $req->user()->apps_with_regioncode()->where('app_id','=',$app_id)->first()->pivot->regioncodes;
            $this->assertOwnership($req, $req->user()->app_id);
            $this->assertRelationship(['app'=>$req->user()->app_id] + $params);
        }
        return $next($req);
    }

    public function assertRelationship($stack) {
        if (empty($stack)) return;
        $tmp = [];
        foreach ($stack as $k => $v) {
            $tmp[@static::$table_map[$k]? : $k] = $v;
        }
        $stack = $tmp;

        $tables = array_keys($stack);
        $where = [];
        for ($i=0; $i < count($tables) - 1; $i++) {
            $a = $tables[$i];
            $b = $tables[$i + 1];
            $where[] = "{$a}.id = {$b}.{$a}_id";
        }
        foreach ($stack as $k => $v) {
            $where[] = "{$k}.id = {$v}";
        }
        $where_str = implode(' and ', $where);
        $from = implode(', ', $tables);
        $sql = "select count(*) as cnt from {$from} where {$where_str};";

        $mysql_keyword = ['schema', ];
        foreach($mysql_keyword as $keyword) {
            $sql = str_replace($keyword, "`$keyword`", $sql);
        }
        // die(json_encode($sql));

        $statment = DB::getPDO()->prepare($sql);
        $statment->execute();
        $ret = $statment->fetchAll();
        $cnt = $ret[0]['cnt'];
        if ($cnt != 1) {
            abort(403, "Resource Not Found");
        }
    }

    public function assertOwnership($req, $app_id) {
        if ($req->user()->app()->id !=$app_id) {
            abort(403, "Resource access denied");
        }
    }
}
