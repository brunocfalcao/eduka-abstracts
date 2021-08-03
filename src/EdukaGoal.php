<?php

namespace Eduka\Abstracts;

use Eduka\Analytics\Models\Goal;
use Eduka\Analytics\Services\Visit;

abstract class EdukaGoal
{
    protected $visit = null;
    protected $goal = null;
    protected $description = null;
    protected $attributes = [];
    protected $course_id = null;

    public function __invoke()
    {
        if ($this->compute()) {
            $this->saveGoal();
        }
    }

    public function compute()
    {
        //
    }

    public function saveGoal()
    {
        $goal = Goal::create([
            'name' => $this->goal,
            'description' => $this->description,
            'attributes' => $this->attributes,
            'course_id' => optional(course())->id,
        ]);

        // Save the goal reference in the visit instance.
        $this->visit = Visit::getModelInstance();
        $this->visit->goal_id = $goal->id;
        $this->visit->save();
    }
}
