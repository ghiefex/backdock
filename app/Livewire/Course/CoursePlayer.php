<?php

namespace App\Livewire\Course;

use App\Models\Course;
use App\Models\Material;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CoursePlayer extends Component
{
    public Course $course;
    public $currentMaterial = null;
    public $isLocked = true;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->checkAccess();

        // Select first material by default
        if (!$this->isLocked && $course->materials()->exists()) {
            $this->currentMaterial = $course->materials()->first();
        }
    }

    public function checkAccess()
    {
        if ($this->course->type === 'free') {
            $this->isLocked = false;
            return;
        }

        if (!Auth::check()) {
            $this->isLocked = true;
            return;
        }

        // Check for successful transaction
        $hasPaid = Auth::user()->transactions()
            ->where('course_id', $this->course->id)
            ->where('status', 'paid')
            ->exists();

        $this->isLocked = !$hasPaid;
    }

    public function selectMaterial($materialId)
    {
        if ($this->isLocked) {
            return;
        }

        $this->currentMaterial = $this->course->materials()->find($materialId);
    }

    public function render()
    {
        return view('livewire.course.course-player', [
            'materials' => $this->course->materials,
        ]);
    }
}
