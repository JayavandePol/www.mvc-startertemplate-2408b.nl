<?php

class Sneakers extends BaseController
{
    private $sneakersModel;

    public function __construct()
    {
        $this->sneakersModel = $this->model('SneakersModel');
    }

    public function index()
    {
        /**
         * Je roept de method getAllSneakers aan van de sneakersModel class
         */
        $results = $this->sneakersModel->getAllSneakers();
        
        $data = [
            'title' => 'Overzicht sneakers',
            'sneakers' => $results
        ];

        $this->view('sneakers/index', $data);
    }
    
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            if (
                empty($_POST['merk']) || 
                empty($_POST['model']) || 
                empty($_POST['type']) ||
                empty($_POST['prijs']))
            {
                echo "<div class='alert alert-danger text-center'><h5>Niet alle velden zijn ingevuld!</h5></div>";
                header('Refresh:3 ; url=' . URLROOT . '/sneakers/create');
            } else {
                $result = $this->sneakersModel->insertSneaker($_POST);
                echo "<div class='alert alert-success text-center'><h5>De sneaker is toegevoegd</h5></div>";
                header('Refresh:3 ; url=' . URLROOT . '/sneakers/index');
            }
        }

        $data = [
            'title' => 'Nieuwe sneaker toevoegen'
        ];

        $this->view('sneakers/create', $data);
    }
    
    public function delete($id)
    {
        $result = $this->sneakersModel->delete($id);

        $data = [
            'message' => 'De sneaker is verwijderd!'
        ];
        
        $this->view('sneakers/delete', $data);
        header('Refresh:3 ; url=' . URLROOT . '/sneakers/index');
    }
}