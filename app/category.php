<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $primarykey = 'id';
    protected $table = 'tbl_table';
    public function product(){
        return $this->belongsTo('App\Product', 'brand_id');
    }

    // sử dụng model ở controller: use App\ten_class (vd: App\category)

    // insert
    // $data = $request->all();
    // $ten_bien = new ten_class();
    // $ten_bien->ten_truong_database = $data['name_ô_input'];
    // $ten_bien->ten_truong_database = $data['name_ô_input'];
    // $ten_bien->ten_truong_database = $data['name_ô_input'];
    // $ten_bien->save();

    // lấy dữ liệu từ database
    // $ten_bien = ten_class::all(); // vd: $all_cate = category::all();
    // $ten_bien = ten_class::orderby('ten_trường', 'DESC' or 'ASC')->take(1)->get(); // ->take hoặc là ->paginate là lấy 1 bản ghi (giống với limit trong mysql, take thì cần get còn paginate thì không cần get)

    // edit 
    // $ten_bien = ten_class::find();
    // $ten_bien = ten_class::where('ten_trường', điều kiện)->get();

    // update
    // $data = $request->all();
    // $ten_bien = ten_class::find($id);
    // $ten_bien->ten_truong_database = $data['name_ô_input'];
    // $ten_bien->ten_truong_database = $data['name_ô_input'];
    // $ten_bien->ten_truong_database = $data['name_ô_input'];
    // $ten_bien->save();
}
