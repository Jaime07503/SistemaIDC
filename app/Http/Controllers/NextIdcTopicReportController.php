<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class NextIdcTopicReportController extends Controller
    {
        public function getSources($idcId) {
            $role = session('role');
            // $sources = BibliographicSource::all();

            return view('layouts.nextIdcTopicReport', compact('role', 'idcId'));
        }
    }
?>