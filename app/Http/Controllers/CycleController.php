<?php
    namespace App\Http\Controllers;
    use App\Models\Cycle;
    use Illuminate\Http\Request;

    class CycleController extends Controller
    {
        public function getCycles() 
        {
            $cycles = Cycle::select('cycleId', 'cycle', 'state')
                ->orderby('state')
                ->get();

            if ($cycles->isEmpty()) {
                return view('layouts.cycle')->with('noCycles', true);
            }

            return view('layouts.cycle', compact('cycles'));
        }

        public function addCycle(Request $request)
        {
            $state = $request->input('state');

            if($state === 'Activo') {
                $existingActiveCycle = Cycle::where('state', 'Activo')->first();
                if ($existingActiveCycle) {
                    $existingActiveCycle->state = 'Inactivo';
                    $existingActiveCycle->save();
                }

                $cycle = new Cycle();
                $cycle->cycle = $request->input('nameCycle');
                $cycle->state = $state;
                $cycle->save();
            } else {
                $cycle = new Cycle();
                $cycle->cycle = $request->input('nameCycle');
                $cycle->state = $state;
                $cycle->save();
            }

            return redirect()->route('cycle');
        }

        public function editCycle(Request $request)
        {
            $cycleId = $request->input('cycleId');
            $state = $request->input('state');

            if($state === 'Activo') {
                $existingActiveCycle = Cycle::where('state', 'Activo')->first();
                if ($existingActiveCycle) {
                    $existingActiveCycle->state = 'Inactivo';
                    $existingActiveCycle->save();
                }

                $cycle = Cycle::find($cycleId);
                $cycle->cycle = $request->input('nameCycle');
                $cycle->state = $state;
                $cycle->save();
            } else {
                $cycle = Cycle::find($cycleId);
                $cycle->cycle = $request->input('nameCycle');
                $cycle->state = $state;
                $cycle->save();
            }

            return redirect()->route('cycle');
        }

        public function deleteCycle(Request $request) {
            $cycleId = $request->input('cycleId');
            $cycle = Cycle::find($cycleId);
            $cycle->delete();
            
            return redirect()->route('cycle');
        }
    }
?>