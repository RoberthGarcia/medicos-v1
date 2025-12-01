<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Medico;

class HomeController extends Controller
{

    public function index()
    {
        $medicos = Medico::getActiveMedicos();

        $data = [
            'title' => 'Inicio - Médicos Oaxaca',
            'medicos' => $medicos
        ];

        $this->view('home/index', $data);
    }

    public function buscar()
    {
        $term = $_GET['q'] ?? '';
        $medicos = Medico::search($term);

        $data = [
            'title' => 'Resultados de búsqueda - Médicos Oaxaca',
            'medicos' => $medicos,
            'term' => $term
        ];

        $this->view('home/index', $data);
    }

    public function perfil($id)
    {
        $medico = Medico::find($id);

        if (!$medico || !$medico->activo) {
            // 404 or redirect
            $this->redirect('');
        }

        $data = [
            'title' => $medico->nombre . ' ' . $medico->apellido . ' - Médicos Oaxaca',
            'medico' => $medico
        ];

        // Check plan to decide view
        if ($medico->esPremiumActivo()) {
            $this->view('medicos/perfil_premium', $data);
        } else {
            $this->view('medicos/perfil_basico', $data);
        }
    }
}
