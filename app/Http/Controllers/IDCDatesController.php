<?php
    namespace App\Http\Controllers;
    use App\Models\IDCDates;
    use Illuminate\Http\Request;

    class IDCDatesController extends Controller
    {
        public function getDates() {
            $datesIDC = IDCDates::first();

            return view('layouts.idcDates', compact('datesIDC'));
        }

        public function assignDates(Request $request) {
            $dates = IDCDates::first();

            if($dates === null) {
                $datesIDC = new IDCDates();
                $datesIDC->startDateSearchReport = $request->input('startDateSearchReport');
                $datesIDC->endDateSearchReport = $request->input('endDateSearchReport');
                $datesIDC->startDateScientificArticleReport = $request->input('startDateScientificArticleReport');
                $datesIDC->endDateScientificArticleReport = $request->input('endDateScientificArticleReport');
                $datesIDC->startDateNextIdcTopic = $request->input('startDateNextIdcTopic');
                $datesIDC->endDateNextIdcTopic = $request->input('endDateNextIdcTopic');
                $datesIDC->save();
            } else {
                $datesIDC = IDCDates::find($dates->dateId);
                $datesIDC->startDateSearchReport = $request->input('startDateSearchReport');
                $datesIDC->endDateSearchReport = $request->input('endDateSearchReport');
                $datesIDC->startDateScientificArticleReport = $request->input('startDateScientificArticleReport');
                $datesIDC->endDateScientificArticleReport = $request->input('endDateScientificArticleReport');
                $datesIDC->startDateNextIdcTopic = $request->input('startDateNextIdcTopic');
                $datesIDC->endDateNextIdcTopic = $request->input('endDateNextIdcTopic');
                $datesIDC->save();
            }

            return redirect()->route('idcDates');
        }
    }
?>