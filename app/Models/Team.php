<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'boatName',
        'plate',
        'hp',
    ];

    // Get the players for the team.
    public function players()
    {
        return $this->hasMany(\App\Models\Player::class);
    } 

    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class);
    }

    // team captures 
    public function captures()
    {
        return $this->hasMany(\App\Models\Fish::class);
    }

    public function stats($id)
    {// will return an array of stats for the team
        $team=\App\Models\Team::find($id);
        //$team=\App\Models\Team::where('number',$id)->sole();
        $species=\App\Models\Species::orderBy('name')->get()->toArray();
        $captures=\App\Models\Fish::where('team_id',$team->id);
        $data=[];
        // unique species count
        $data['species_count']=$captures->distinct('species_id')->count('species_id');
        // amount of pieces even repeated ones
        $data['pieces_count']=$captures->get()->count();
      
        // count of each species
        $fishCount=[];
        foreach($captures->get() as $fish){
            if (!isset($fishCount[$fish->species_id])){
                $fishCount[$fish->species_id]=0;
            }
            $fishCount[$fish->species_id]=$fishCount[$fish->species_id]+1;
        }
        
        // Points calculation
        $total_points=0;
        foreach($species as $s){
            $fish_count=$fishCount[$s['id']] ?? 0;
            $data['species'][$s['id']]=[
                'name'=>$s['name'],
                'fish_count'=>$fish_count,
            ];
            if( $fish_count>0 ){
                if ($fish_count==1){ 
                    $total_points+=$s['points1']; 
                    }
                else{ 
                    $total_points+=$s['points1']+$s['points2']; 
                    //$total_points=$s['points1']+($fish_count-1)*$s['points2']; 
                }
            }
        }
        $data['total_points']=$total_points;
        return $data;
    }
}
