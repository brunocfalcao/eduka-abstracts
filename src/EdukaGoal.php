<?php

namespace Eduka\Abstracts;

use Eduka\Analytics\Models\Goal;
use Eduka\Analytics\Models\Visit as VisitModel;
use Eduka\Analytics\Services\Visit;
use Eduka\Analytics\Services\Visitor;

abstract class EdukaGoal
{
    protected $visit = null;
    protected $visits = null;
    protected $goal = null;
    protected $attributes = [];
    protected $context = null;

    public function __invoke()
    {
        $this->getVisit();
        $this->getVisits();

        if ($this->compute()) {
            $this->setGoal();
        }
    }

    public function compute()
    {
    }

    public function getVisit()
    {
        $this->visit = Visit::getModelInstance();
    }

    public function getVisits()
    {
        $this->visits = VisitModel::where('visitor_id', Visitor::get()->id);
    }

    public function setGoal()
    {
        $goal = Goal::create([
            'name' => $this->goal,
            'description' => '',
            'attributes' => $this->attributes
        ]);

        // Save the goal reference in the visit instance.
        $this->visit->goal_id = $goal->id;
        $this->visit->save();
    }
}
