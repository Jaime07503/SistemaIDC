<?php
    namespace App\Http\Controllers;
    use App\Models\Cycle;
    use App\Models\IDCDates;
    use Illuminate\Http\Request;

    class IDCDatesController extends Controller
    {
        public function getDates() {
            $cycle = Cycle::where('state', 'Activo')->first();

            $datesIDC = IDCDates::where('idCycle', $cycle->cycleId)
                ->first();

            return view('layouts.idcDates', compact('datesIDC'));
        }

        public function assignDates(Request $request) {
            $cycle = Cycle::where('state', 'Activo')->first();

            $dates = IDCDates::where('idCycle', $request->input('idCycle'))->first();

            if($dates === null) {
                $datesIDC = new IDCDates();
                $datesIDC->startDateSearchReport = $request->input('startDateSearchReport');
                $datesIDC->endDateSearchReport = $request->input('endDateSearchReport');
                $datesIDC->startDateScientificArticleReport = $request->input('startDateScientificArticleReport');
                $datesIDC->endDateScientificArticleReport = $request->input('endDateScientificArticleReport');
                $datesIDC->startDateNextIdcTopic = $request->input('startDateNextIdcTopic');
                $datesIDC->endDateNextIdcTopic = $request->input('endDateNextIdcTopic');
                $datesIDC->idCycle = $cycle->cycleId;
                $datesIDC->save();
            } else {
                $datesIDC = IDCDates::find($dates->dateId);
                $datesIDC->startDateSearchReport = $request->input('startDateSearchReport');
                $datesIDC->endDateSearchReport = $request->input('endDateSearchReport');
                $datesIDC->startDateScientificArticleReport = $request->input('startDateScientificArticleReport');
                $datesIDC->endDateScientificArticleReport = $request->input('endDateScientificArticleReport');
                $datesIDC->startDateNextIdcTopic = $request->input('startDateNextIdcTopic');
                $datesIDC->endDateNextIdcTopic = $request->input('endDateNextIdcTopic');
                $datesIDC->idCycle = $cycle->cycleId;
                $datesIDC->save();
            }

            return redirect()->route('idcDates');
        }
    }
?>