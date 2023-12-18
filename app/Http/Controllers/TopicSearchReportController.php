<?php
    namespace App\Http\Controllers;

    use App\Models\BibliographicSource;
    use Illuminate\Http\Request;

    class TopicSearchReportController extends Controller
    {
        public function getSources() {
            $role = session('role');
            $sources = BibliographicSource::all();

            return view('layouts.topicSearchReport', compact('sources', 'role'));
        }
    }
?>