<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
   //use HasFactory;

    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
    ];

    //Relation: A person can have multiple children
    public function children()
    {
        return $this->belongsToMany(
            Person::class,
            'relationships',
            'parent_id',
            'child_id'
        );
    }

    //Relation: A person can have multiple parents
    public function parents()
    {
        return $this->belongsToMany(
            Person::class,
            'relationships',
            'child_id',
            'parent_id'
        );
    }

    //Relation: A person is created by a user
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getDegreeWith($target_person_id)
    {
        $queue = [[
            'id' => $this->id,
            'path' => [$this->id],
            'degree' => 0,
        ]];

        $visited = [$this->id];

        while (!empty($queue)) {
            $current = array_shift($queue);

            // If the target person is reached
            if ($current['id'] == $target_person_id) {
                return [
                    'degree' => $current['degree'],
                    'path' => $current['path'],
                ];
            }

            // Stops searching if degree exceeds 25
            if ($current['degree'] > 25) {
                return false;
            }

            // to recover relationships parent-child
            $neighbors = DB::table('relationships')
                ->where('parent_id', $current['id'])
                ->orWhere('child_id', $current['id'])
                ->get()
                ->map(function ($relation) use ($current) {
                    // If the person is a parent, we collect the child and vice versa
                    $neighbor_id = $relation->parent_id == $current['id']
                        ? $relation->child_id
                        : $relation->parent_id;

                    return [
                        'id' => $neighbor_id,
                        'path' => array_merge($current['path'], [$neighbor_id]),
                        'degree' => $current['degree'] + 1,
                    ];
                });

            foreach ($neighbors as $neighbor) {
                // If the neighbor has not yet been visited, we add it to the queue
                if (!in_array($neighbor['id'], $visited)) {
                    $visited[] = $neighbor['id'];
                    $queue[] = $neighbor;
                }
            }
        }

        // No path 
        return false;
    }



}
