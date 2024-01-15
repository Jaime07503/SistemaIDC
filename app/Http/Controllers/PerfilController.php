<?php
    namespace App\Http\Controllers;
    use App\Models\User;
    use Illuminate\Http\Request;

    class PerfilController extends Controller
    {
        public function getInformation($idUser) {
            $user = User::find($idUser);

            return view('layouts.perfil', compact('user'));
        }
    }
?>