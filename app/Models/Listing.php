<?php 

namespace App\Models;

class Listing{
    public static function all(){
        return [
            [
                'id' => 1,
                'title' => 'Listing One',
                'description' => 'I am baby slow-carb forage fingerstache, green juice DSA skateboard post-ironic bitters banjo yes plz iPhone mumblecore church-key pour-over narwhal. Selvage aesthetic bushwick mustache cold-pressed. ',
            ], 
            [
                'id' => 2,
                'title' => 'Listing Two',
                'description' => 'I am baby slow-carb forage fingerstache, green juice DSA skateboard post-ironic bitters banjo yes plz iPhone mumblecore church-key pour-over narwhal. Selvage aesthetic bushwick mustache cold-pressed. ',
            ]
            ];
    }
    public static function find($id){
        $listings = self::all();

        foreach($listings as $listing){
            if($listing['id'] == $id){
                return $listing;
            }
        }
    }
}

?>

