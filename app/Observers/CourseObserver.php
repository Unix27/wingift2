<?php

namespace App\Observers;

use App\Models\Course;

class CourseObserver
{
    public function saved(Course $course)
    {
        $course->files()->delete();

        $files = request()->input('files');

        if($files) {
            $files = json_decode($files);
            foreach($files as $file) {
                $course->files()->updateOrCreate(
                    ['path' => $file->path],
                    ['title' => $file->title, 'description' => $file->description]
                );
            }
        }
    }

    public function deleting(Course $course)
    {
        $course->files()->delete();
    }
}
