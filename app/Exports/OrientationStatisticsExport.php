<?php

namespace App\Exports;

use App\Orientation;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrientationStatisticsExport implements FromArray, ShouldAutoSize
{
    use Exportable;

    public function __construct(int $orientation)
    {
        $this->orientation = $orientation;
    }

    public function array(): array
    {
        $users = Orientation::find($this->orientation)->users;
        $completedAt = $name = null;

        /**
         * Start the array with some headers
         * These are the headers for the Excel document
         */
        $data[] = array( config('app.name'), );
        $data[] = array("Student Progress Report",);
        $data[] = array( Orientation::find($this->orientation)->name, );
        $data[] = array( date('m/d/Y h:i a') );
        $data[] = array("", "", "");
        $data[] = array("Name", "Email", "Completion Status");

        foreach($users as $user) {
            $name = $user->name;
            $email = $user->email;
            $completedAt = $user->pivot->completed_at;
            if ($completedAt) {
                $completedAt = date("m-d-Y h:i a", strtotime($completedAt));
            }

            $data[] = array($name, $email, $completedAt ?? "In progress");
        }

        return $data;
    }
}
