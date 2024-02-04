<?php
    namespace App\Http\Controllers;
    use App\Models\Cycle;
    use Illuminate\Http\Request;

    class CycleController extends Controller
    {
        public function getCycles() 
        {
            $cycles = Cycle::orderby('state')
                ->get();

            return view('layouts.cycle', compact('cycles'));
        }

        public function addCycle(Request $request)
        {
            $state = $request->input('state');

           // Verificar si hay algún ciclo activo
            $existingActiveCycle = Cycle::where('state', 'Activo')->first();
            if ($existingActiveCycle) {
                // Si hay un ciclo activo, cambiar su estado a Inactivo
                $existingActiveCycle->state = 'Inactivo';
                $existingActiveCycle->save();
            }

            // Crear el nuevo ciclo
            $cycle = new Cycle();
            $cycle->cycle = $request->input('nameCycle');
            $cycle->state = $state; // Establecer el estado apropiado
            $cycle->save();

            return redirect()->route('cycle');
        }

        public function editCycle(Request $request)
        {
            $cycleId = $request->input('cycleId');
            $state = $request->input('state');

            // Verificar si hay algún ciclo activo excepto el que se está editando
            $existingActiveCycle = Cycle::where('state', 'Activo')->first();
            if ($existingActiveCycle) {
                // Si hay un ciclo activo, cambiar su estado a Inactivo
                $existingActiveCycle->state = 'Inactivo';
                $existingActiveCycle->save();
            }

            // Encontrar el ciclo a editar
            $cycle = Cycle::find($cycleId);
            $cycle->cycle = $request->input('nameCycle');
            $cycle->state = $state; // Establecer el estado apropiado
            $cycle->save();

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