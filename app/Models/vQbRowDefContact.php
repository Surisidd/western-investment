<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vQbRowDefContact extends Model
{
    use HasFactory;

//     public function getRouteKeyName()
// {
//     return 'ContactID';
// }
protected $primaryKey = 'ContactID';



    public function getFullNameAttribute()
{
    return "{$this->FirstName} {$this->LastName}";
}

  public function portfolios(){
      return $this->hasMany(AdvPortfolio::class,'PrimaryContactID');
  }
  protected $table = 'vQbRowDefContact';

}
